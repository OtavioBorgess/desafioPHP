<?php

    namespace App\Db;

    use PDO;
    use PDOException;

    class DataBase
    {
        const HOST = 'localhost';
        const NAME = 'agrifood';
        const USER = 'root';
        const PASS = '';

        private $table;
        private $conn;

        public function __construct($table = null)
        {
            $this->table = $table;
            $this->setConnection();
        }

        private function setConnection()
        {
            try {
                $this->conn = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('ERROR: ' . $e->getMessage());
            }
        }

        public function execute($query, $params = [])
        {
            try {
                $statement = $this->conn->prepare($query);
                $statement->execute($params);
                return $statement;
            } catch (PDOException $e) {
                die('ERROR: ' . $e->getMessage());
            }
        }

        public function insert($values)
        {
            $fields = array_keys($values);
            $binds = array_pad([], count($fields), '?');

            $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';
            $this->execute($query, array_values($values));

            return $this->conn->lastInsertId();
        }

        public function select($where = null, $order = null, $limit = null)
        {
            $where = strlen($where) ? 'WHERE ' . $where : '';
            $order = strlen($order) ? 'ORDER BY ' . $order : '';
            $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

            $query = 'SELECT * FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;
            return $this->execute($query);
        }

        public function update($where, $values)
        {
            $fields = array_keys($values);

            $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE ' . $where;
            $this->execute($query, array_values($values));

            return true;
        }

        public
        function delete($where)
        {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;

            $this->execute($query);

            return true;
        }
    }