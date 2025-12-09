<?php

class InterestRepository
{

    public function fetchAll($condition = null)
    {
        global $pdo;
        $items = [];
        $sql   = "SELECT * FROM interests";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                $items[] = $this->mapRowToInterest($row);
            }
        }

        return $items;
    }

    public function getAll()
    {
        return $this->fetchAll();
    }

    // Tìm interest theo ID
    public function find($id)
    {
        $condition = "id = $id";
        $interest  = $this->fetchAll($condition);
        return current($interest);
    }

    // Thêm interest mới
    public function save(Interest $interest)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO interests (name) VALUES (?)");
        $stmt->execute([$interest->getName()]);
        return $pdo->lastInsertId();
    }

    // Cập nhật interest
    public function update(Interest $interest)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE interests SET name = ? WHERE id = ?");
        return $stmt->execute([
            $interest->getName(),
            $interest->getId(),
        ]);
    }

    // Xóa interest
    public function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM interests WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Helper: map row -> Interest object
    protected function mapRowToInterest($row)
    {
        return new Interest(
            $row['id'],
            $row['name']
        );
    }

    // Lấy tất cả interest của một user
    public function findByUser($userId)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT i.* FROM interests i
            INNER JOIN user_interests ui ON i.id = ui.interest_id
            WHERE ui.user_id = ?
        ");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $interests = [];
        foreach ($rows as $row) {
            $interests[] = $this->mapRowToInterest($row);
        }
        return $interests;
    }
}
