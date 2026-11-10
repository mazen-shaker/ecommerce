<?php

namespace core\database\traits;

trait HasCrud
{
    public function all(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table}"
        );

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert($data): int|false
    {
       $columns = implode(', ', array_keys($data));
       $placeholders = implode(', ', array_fill(0, count($data), '?'));

      $stmt = $this->db->prepare(
         "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})"
      );

       if(!$stmt->execute(array_values($data))) {
          return false;
       }

       return (int) $this->db->lastInsertId();
    }

    public function update($id, $data): bool
    {
        $columns = [];
        $values = [];

        foreach ($data as $column => $value) {
            $columns[] = "{$column} = ?";
            $values[] = $value;
        }

        $columns = implode(', ', $columns);

        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET {$columns} WHERE id = ?"
        );

        $values[] = $id;

        return $stmt->execute($values);
    }

    public function destroy($id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }

    public function where($column, $operator, $value): array
    {
        $allowedOperators = ['=', '>', '<', '>=', '<=', '!=', '<>'];

        if (!in_array($operator, $allowedOperators, true)) {
            throw new \InvalidArgumentException('Invalid operator');
        }

        // Prevent SQL injection through column name
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $column)) {
            throw new \InvalidArgumentException('Invalid column name');
        }

        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?"
        );

        $stmt->execute([$value]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
