<?php

class OptionRepository
{

    public function fetchAll($condition = null)
    {
        global $pdo;
        $items = [];
        $sql   = "SELECT * FROM options";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                $items[] = $this->mapRowToOption($row);
            }
        }

        return $items;
    }

    public function getAll()
    {
        return $this->fetchAll();
    }

    // Tìm option theo ID
    public function find($id)
    {
        $condition = "id = $id";
        $option    = $this->fetchAll($condition);
        return current($option);
    }

    // Thêm option mới
    public function save(Option $option)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO options (question_id, content, is_correct)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $option->getQuestionId(),
            $option->getContent(),
            $option->isCorrect(),
        ]);
        return $pdo->lastInsertId();
    }

    // Cập nhật option
    public function update(Option $option)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE options
            SET question_id = ?, content = ?, is_correct = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $option->getQuestionId(),
            $option->getContent(),
            $option->isCorrect(),
            $option->getId(),
        ]);
    }

    // Xóa option
    public function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM options WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Helper: map row -> Option object
    protected function mapRowToOption($row)
    {
        return new Option(
            $row['id'],
            $row['question_id'],
            $row['content'],
            (bool) $row['is_correct']
        );
    }

    // Lấy tất cả option theo question
    public function findByQuestion($questionId)
    {
        $condition = "question_id = $questionId";
        $options   = $this->fetchAll($condition);
        return $options;
    }
    public function deleteByQuestion($questionId)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM options WHERE question_id = ?");
        return $stmt->execute([$questionId]);
    }
    public function deleteByChallenge($challengeId)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            DELETE FROM options
            WHERE question_id IN (SELECT id FROM questions WHERE challenge_id = ?)
        ");
        $stmt->execute([$challengeId]);
    }
    public function findCorrectByQuestion($questionId)
    {
        global $pdo;
        $stmt = $pdo->prepare("
        SELECT *
        FROM options
        WHERE question_id = ? AND is_correct = 1
        LIMIT 1
    ");
        $stmt->execute([$questionId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Option(
                $row['id'],
                $row['question_id'],
                $row['content'],
                $row['is_correct']
            );
        }

        return null;
    }

}
