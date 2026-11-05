<?php

namespace core\database\traits;

trait HasCrud
{

    public function all()
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table}"
        );

        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})"
        );

        return $stmt->execute(array_values($data));
    }

    public function update($id, $data)
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

    public function delete($id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }


public function where($column, $operator, $value)
{
    $allowedOperators = ['=', '>', '<', '>=', '<=', '!=', '<>'];

    if (!in_array($operator, $allowedOperators)) {
        throw new \InvalidArgumentException('Invalid operator');
    }

    $stmt = $this->db->prepare(
        "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?"
    );

    $stmt->execute([$value]);

    return $stmt->fetchAll();
}

}
