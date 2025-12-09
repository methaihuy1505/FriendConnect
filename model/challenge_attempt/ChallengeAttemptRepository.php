<?php

class ChallengeAttemptRepository
{

    public function fetchAll($condition = null)
    {
        global $pdo;
        $items = [];
        $sql   = "SELECT * FROM challenge_attempts";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                $items[] = $this->mapRowToAttempt($row);
            }
        }

        return $items;
    }

    public function getAll()
    {
        return $this->fetchAll();
    }

    // Tìm attempt theo ID
    public function find($id)
    {
        $condition = "id = $id";
        $attempt   = $this->fetchAll($condition);
        return current($attempt);
    }

    // Thêm attempt mới
    public function save(ChallengeAttempt $attempt)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO challenge_attempts (challenge_id, user_id, score, attempt_count)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $attempt->getChallengeId(),
            $attempt->getUserId(),
            $attempt->getScore(),
            $attempt->getAttemptCount(),
        ]);
        return $pdo->lastInsertId();
    }

    // Cập nhật attempt
    public function update(ChallengeAttempt $attempt)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE challenge_attempts
            SET challenge_id = ?, user_id = ?, score = ?, attempt_count = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $attempt->getChallengeId(),
            $attempt->getUserId(),
            $attempt->getScore(),
            $attempt->getAttemptCount(),
            $attempt->getId(),
        ]);
    }

    // Xóa attempt
    public function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM challenge_attempts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Helper: map row -> ChallengeAttempt object
    protected function mapRowToAttempt($row)
    {
        return new ChallengeAttempt(
            $row['id'],
            $row['challenge_id'],
            $row['user_id'],
            $row['score'],
            $row['attempt_count'],
            $row['created_at']
        );
    }

    // Lấy tất cả attempt theo challenge
    public function findByChallenge($challengeId)
    {
        $condition = "challenge_id = $challengeId";
        $attempts  = $this->fetchAll($condition);
        return $attempts;
    }

    // Lấy tất cả attempt theo user
    public function findByUser($userId)
    {
        $condition = "user_id = $userId";
        $attempts  = $this->fetchAll($condition);
        return $attempts;
    }
    public function findLastAttempt($challengeId, $userId)
    {
        global $pdo;
        $stmt = $pdo->prepare("
        SELECT *
        FROM challenge_attempts
        WHERE challenge_id = ? AND user_id = ?
        ORDER BY attempt_count DESC
        LIMIT 1
    ");
        $stmt->execute([$challengeId, $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new ChallengeAttempt(
                $row['id'],
                $row['challenge_id'],
                $row['user_id'],
                $row['score'],
                $row['attempt_count'],
                $row['created_at']
            );
        }

        return null;
    }

}
