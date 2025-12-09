<?php

class ChallengeRepository
{
    public function fetchAll($condition = null)
    {
        global $pdo;
        $challenges = [];
        $sql        = "SELECT * FROM challenges";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                $challenges[] = $this->mapRowToChallenge($row);
            }
        }

        return $challenges;
    }

    public function getAll()
    {
        return $this->fetchAll();
    }

    // Tìm challenge theo ID
    public function find($id)
    {
        $condition = "id = $id";
        $challenge = $this->fetchAll($condition);
        return current($challenge);
    }

    // Thêm challenge mới
    public function save(Challenge $challenge)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO challenges (creator_id, title, description)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $challenge->getCreatorId(),
            $challenge->getTitle(),
            $challenge->getDescription(),
        ]);
        return $pdo->lastInsertId();
    }

    // Cập nhật challenge
    public function update(Challenge $challenge)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE challenges
            SET creator_id = ?, title = ?, description = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $challenge->getCreatorId(),
            $challenge->getTitle(),
            $challenge->getDescription(),
            $challenge->getId(),
        ]);
    }

    // Xóa challenge
    public function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM challenges WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Helper: map row -> Challenge object
    protected function mapRowToChallenge($row)
    {
        return new Challenge(
            $row['id'],
            $row['creator_id'],
            $row['title'],
            $row['description'],
            $row['created_at']
        );
    }
    public function findByCreator($creatorId)
    {
        $condition  = "creator_id = $creatorId";
        $challenges = $this->fetchAll($condition);
        return $challenges;
    }

}
