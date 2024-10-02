<?php

class Database
{
    private $connection;

    public function __construct($config, $username = 'root', $password = '')
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'] ?? 'localhost',
            $config['port'] ?? 3306,
            $config['dbname'] ?? '',
            $config['charset'] ?? 'utf8mb4'
        );

        try {
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions
            ]);
        } catch (PDOException $e) {
            // Handle connection errors gracefully
            throw new Exception('Database connection error: ' . $e->getMessage());
        }
    }

    public function query($query, $params = [])
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    // Getter for the PDO connection if needed elsewhere
    public function getConnection()
    {
        return $this->connection;
    }

    public function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);

        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $where)
    {
        $setPart = '';
        foreach ($data as $column => $value) {
            $setPart .= "{$column} = :{$column}, ";
        }
        $setPart = rtrim($setPart, ', ');

        $wherePart = '';
        foreach ($where as $column => $value) {
            $wherePart .= "{$column} = :where_{$column} AND ";
        }
        $wherePart = rtrim($wherePart, ' AND ');

        $params = array_merge($data, array_combine(
            array_map(fn($key) => 'where_' . $key, array_keys($where)),
            array_values($where)
        ));

        $sql = "UPDATE {$table} SET {$setPart} WHERE {$wherePart}";
        $this->query($sql, $params);
    }

    public function delete($table, $where)
    {
        $wherePart = '';
        foreach ($where as $column => $value) {
            $wherePart .= "{$column} = :{$column} AND ";
        }
        $wherePart = rtrim($wherePart, ' AND ');

        $sql = "DELETE FROM {$table} WHERE {$wherePart}";
        $this->query($sql, $where);
    }

    public function select($table, $where = [], $columns = '*', $limit = null, $offset = null)
    {
        $sql = "SELECT {$columns} FROM {$table}";

        if (!empty($where)) {
            $wherePart = '';
            foreach ($where as $column => $value) {
                $wherePart .= "{$column} = :{$column} AND ";
            }
            $wherePart = rtrim($wherePart, ' AND ');
            $sql .= " WHERE {$wherePart}";
        }

        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";
            if ($offset !== null) {
                $sql .= " OFFSET {$offset}";
            }
        }

        return $this->query($sql, $where)->fetchAll();
    }
}
