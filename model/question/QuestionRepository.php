<?php

class QuestionRepository
{

    public function fetchAll($condition = null)
    {
        global $pdo;
        $items = [];
        $sql   = "SELECT * FROM questions";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                $items[] = $this->mapRowToQuestion($row);
            }
        }

        return $items;
    }

    public function getAll()
    {
        return $this->fetchAll();
    }

    // Tìm câu hỏi theo ID
    public function find($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->mapRowToQuestion($row) : null;
    }

    // Thêm câu hỏi mới
    public function save(Question $question)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO questions (challenge_id, content)
            VALUES (?, ?)
        ");
        $stmt->execute([
            $question->getChallengeId(),
            $question->getContent(),
        ]);
        return $pdo->lastInsertId();
    }

    // Cập nhật câu hỏi
    public function update(Question $question)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE questions
            SET challenge_id = ?, content = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $question->getChallengeId(),
            $question->getContent(),
            $question->getId(),
        ]);
    }

    // Xóa câu hỏi
    public function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function deleteByChallenge($challengeId)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM questions WHERE challenge_id = ?");
        $stmt->execute([$challengeId]);
    }

    // Helper: map row -> Question object
    protected function mapRowToQuestion($row)
    {
        return new Question(
            $row['id'],
            $row['challenge_id'],
            $row['content']
        );
    }

    // Lấy tất cả câu hỏi theo challenge
    public function findByChallenge($challengeId)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE challenge_id = ?");
        $stmt->execute([$challengeId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($rows as $row) {
            $questions[] = $this->mapRowToQuestion($row);
        }
        return $questions;
    }
}
