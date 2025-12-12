<?php
class UserRepository
{

    protected function fetchAll($condition = null, $sort = null, $limit = null)
    {
        global $pdo;
        $users = [];
        $sql   = "SELECT * FROM users";
        if ($condition) {
            $sql .= " WHERE $condition";
        }
        if ($sort) {
            $sql .= " $sort";
        }
        if ($limit) {
            $sql .= " $limit";
        }

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            foreach ($rows as $row) {
                $users[] = $this->mapRowToUser($row);
            }
        }
        return $users;
    }

    public function getBy($array_conds = [], $array_sorts = [], $page = null, $qty_per_page = null)
    {
        if ($page) {
            $page_index = $page - 1;
        }

        // Điều kiện
        $temp = [];
        foreach ($array_conds as $column => $cond) {
            $type = $cond['type'];
            $val  = $cond['val'];
            $str  = "$column $type ";
            if (in_array($type, ["BETWEEN", "LIKE"])) {
                $str .= "$val";
            } else {
                $str .= "'$val'";
            }
            $temp[] = $str;
        }
        $condition = count($array_conds) ? implode(" AND ", $temp) : null;

        // Sắp xếp
        $temp = [];
        foreach ($array_sorts as $key => $sort) {
            $temp[] = "$key $sort";
        }
        $sort = count($array_sorts) ? "ORDER BY " . implode(" , ", $temp) : null;

        // Phân trang
        $limit = null;
        if ($qty_per_page) {
            $start = $page_index * $qty_per_page;
            $limit = "LIMIT $start, $qty_per_page";
        }

        return $this->fetchAll($condition, $sort, $limit);
    }

    public function getAll()
    {
        return $this->fetchAll();
    }

    public function find($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->mapRowToUser($row) : null;
    }
    public function findByEmail($email)
    {
        $condition = "email = '$email'";
        $users     = $this->fetchAll($condition);
        return current($users);
    }
    public function filterByInterests(array $userIds, array $interestIds): array
    {
        global $pdo;

        if (empty($userIds) || empty($interestIds)) {
            return [];
        }

        // Chuẩn bị placeholders
        $placeholdersUsers     = implode(',', array_map('intval', $userIds));
        $placeholdersInterests = implode(',', array_map('intval', $interestIds));

        $sql = "SELECT DISTINCT ui.user_id
            FROM user_interests ui
            WHERE ui.user_id IN ($placeholdersUsers)
              AND ui.interest_id IN ($placeholdersInterests)";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findByChallengeId($challengeId)
    {
        global $pdo;
        $sql  = "SELECT u.* FROM challenges c JOIN users u ON c.creator_id = u.id WHERE c.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$challengeId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->mapRowToUser($row) : null;
    }
    public function matchUser(User $currentUser): array
    {
        $matched  = [];
        $allUsers = $this->getAll(); // lấy toàn bộ user từ DB

        foreach ($allUsers as $user) {
            if ($user->getId() === $currentUser->getId()) {
                continue;
            }

            $score = 0;

            // Bước 1: match 2 chiều (ưu tiên cao nhất)
            if (
                $currentUser->getInterestedIn() === $user->getGender() &&
                $user->getInterestedIn() === $currentUser->getGender()
            ) {
                $score += 3;
            }
            // Bước 2: match một chiều
            if ($currentUser->getInterestedIn() === "everyone") {
                $score += 2;
            } else if ($user->getGender() === $currentUser->getInterestedIn()) {
                $score += 2;
            }

            // Bước 3: match orientation
            if ($user->getOrientation() === $currentUser->getOrientation()) {
                $score += 1;
            }

            // Bước 4: match interests
            $currentInterests = array_map(function ($i) {return $i->getId();}, $currentUser->getInterests());
            $userInterests = array_map(function ($i) {return $i->getId();}, $user->getInterests());

            $common = array_intersect($currentInterests, $userInterests);
            $score += count($common); // mỗi sở thích chung +1 điểm

            if ($score > 0) {
                $matched[] = ['user' => $user, 'score' => $score];
            }
        }

        // Sort theo score giảm dần
        usort($matched, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Trả về chỉ danh sách user (nếu không cần score)
        return array_map(function ($m) {return $m['user'];}, $matched);
    }

    public function getTopChallengeOwnersByAttempts(?int $limit = null)
    {
        global $pdo;
        $sql = "
        SELECT u.*, ch.id AS challenge_id, ch.title AS challenge_title, SUM(ca.attempt_count) AS total_attempts
        FROM challenges ch
        INNER JOIN challenge_attempts ca ON ch.id = ca.challenge_id
        INNER JOIN users u ON u.id = ch.creator_id
        GROUP BY ch.id
        ORDER BY total_attempts DESC
    ";

        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $pdo->prepare($sql);
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'user'            => $this->mapRowToUser($row),
                'challenge_id'    => $row['challenge_id'],
                'challenge_title' => $row['challenge_title'],
                'total_attempts'  => $row['total_attempts'],
            ];
        }
        return $result;
    }

    public function getTopUsersByFollowers(?int $limit = null)
    {
        global $pdo;
        $users = [];

        $sql = "
        SELECT u.*, COUNT(f.follower_id) AS follower_count
        FROM users u
        LEFT JOIN follows f ON u.id = f.followed_id
        GROUP BY u.id
        ORDER BY follower_count DESC
    ";

        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $pdo->prepare($sql);

        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                $user    = $this->mapRowToUser($row);
                $users[] = $user;
            }
        }

        return $users;
    }

    public function save(User $user)
    {
        global $pdo;
        $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password_hash, birth_date, gender, orientation, interested_in, relationship_intent, avatar_url, role)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
        $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPasswordHash(),
            $user->getBirthDate(),
            $user->getGender(),
            $user->getOrientation(),
            $user->getInterestedIn(),
            $user->getRelationshipIntent(),
            $user->getAvatarUrl(),
            $user->getRole(), // thêm role
        ]);

        return $pdo->lastInsertId();
    }

    public function saveUserInterests(int $userId, array $interestIds): void
    {
        global $pdo;
        $userId = (int) $userId;
        if (empty($interestIds)) {
            return;
        }

        $stmt = $pdo->prepare("INSERT INTO user_interests (user_id, interest_id) VALUES (?, ?)");
        foreach ($interestIds as $iid) {
            if (is_numeric($iid)) {
                $stmt->execute([$userId, $iid]);
            }
        }
    }
    public function updateUserInterests(int $userId, array $newInterests)
    {
        global $pdo;

        // Lấy danh sách interest cũ từ DB
        $stmt = $pdo->prepare("SELECT interest_id FROM user_interests WHERE user_id = ?");
        $stmt->execute([$userId]);
        $oldInterests = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Tìm những interest cần thêm
        $toAdd = array_diff($newInterests, $oldInterests);

        // Tìm những interest cần xóa
        $toRemove = array_diff($oldInterests, $newInterests);

        // Thêm mới
        if (! empty($toAdd)) {
            $stmt = $pdo->prepare("INSERT INTO user_interests (user_id, interest_id) VALUES (?, ?)");
            foreach ($toAdd as $interestId) {
                $stmt->execute([$userId, $interestId]);
            }
        }

        // Xóa những cái không còn
        if (! empty($toRemove)) {
            $in   = str_repeat('?,', count($toRemove) - 1) . '?';
            $sql  = "DELETE FROM user_interests WHERE user_id = ? AND interest_id IN ($in)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array_merge([$userId], $toRemove));
        }

    }

    public function update(User $user)
    {
        global $pdo;

        $fields = [
            'name'                => $user->getName(),
            'email'               => $user->getEmail(),
            'birth_date'          => $user->getBirthDate(),
            'gender'              => $user->getGender(),
            'orientation'         => $user->getOrientation(),
            'interested_in'       => $user->getInterestedIn(),
            'relationship_intent' => $user->getRelationshipIntent(),
            'avatar_url'          => $user->getAvatarUrl(),
            'role'                => $user->getRole(),
        ];
        if ($user->getPasswordHash()) {
            $fields['password_hash'] = $user->getPasswordHash();
        }

        $set = implode(', ', array_map(function ($k) {return "$k = ?";}, array_keys($fields)));
        $sql  = "UPDATE users SET $set WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        $values   = array_values($fields);
        $values[] = $user->getId();

        return $stmt->execute($values);
    }
    public function updatePassword(User $user)
    {
        global $pdo;

        // Chỉ update password_hash theo id
        $stmt = $pdo->prepare("
        UPDATE users
        SET password_hash = ?
        WHERE id = ?
    ");

        return $stmt->execute([
            $user->getPasswordHash(),
            $user->getId(),
        ]);
    }

    public function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    protected function mapRowToUser($row)
    {
        return new User(
            $row['id'],
            $row['name'],
            $row['email'],
            $row['password_hash'],
            $row['birth_date'],
            $row['gender'],
            $row['orientation'],
            $row['interested_in'],
            $row['relationship_intent'],
            $row['avatar_url'],
            $row['created_at'],
            $row['role']
        );
    }
}
