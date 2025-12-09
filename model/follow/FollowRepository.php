<?php

class FollowRepository
{
    // Lấy tất cả follow
    public function fetchAll($condition = null)
    {
        global $pdo;
        $follows = [];
        $sql     = "SELECT * FROM follows";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                $follows[] = $this->mapRowToFollow($row);
            }
        }

        return $follows;
    }

    public function getAll()
    {
        return $this->fetchAll();
    }

    // Tìm follow theo ID
    public function find($id)
    {
        $condition = "id = $id";
        $follow    = $this->fetchAll($condition);
        return current($follow);
    }

    // Cập nhật follow
    public function update(Follow $follow)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE follows
            SET follower_id = ?, followed_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $follow->getFollowerId(),
            $follow->getFollowedId(),
            $follow->getId(),
        ]);
    }
// Thêm follow mới
    public function save(Follow $follow)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO follows (follower_id, followed_id)
            VALUES (?, ?)
        ");
        $stmt->execute([
            $follow->getFollowerId(),
            $follow->getFollowedId(),
        ]);
        return $pdo->lastInsertId();
    }
    // Xóa follow
    public function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM follows WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Helper: map row -> Follow object
    protected function mapRowToFollow($row)
    {
        return new Follow(
            $row['id'],
            $row['follower_id'],
            $row['followed_id'],
            $row['created_at']
        );
    }

    public function findFollowing($userId)
    {
        global $pdo;
        $sql  = "SELECT followed_id FROM follows WHERE follower_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userRepo = new UserRepository();
        $users    = [];
        foreach ($rows as $row) {
            $users[] = $userRepo->find($row['followed_id']);
        }
        return $users;
    }

    public function findFollowers($userId)
    {
        global $pdo;
        $sql  = "SELECT follower_id FROM follows WHERE followed_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userRepo = new UserRepository();
        $users    = [];
        foreach ($rows as $row) {
            $users[] = $userRepo->find($row['follower_id']);
        }
        return $users;
    }
    public function follow($followerId, $followedId)
    {
        global $pdo;
        $sql  = "INSERT INTO follows (follower_id, followed_id, created_at) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$followerId, $followedId]);
    }

    public function unfollow($followerId, $followedId)
    {
        global $pdo;
        $sql  = "DELETE FROM follows WHERE follower_id = ? AND followed_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$followerId, $followedId]);
    }

}
