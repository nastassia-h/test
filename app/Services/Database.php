<?php

declare(strict_types=1);

namespace App\Services;

class Database
{
    private static $instance = null;
    private
        $_db,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    private function __construct($config)
    {
        $config = include_once "/config/$config";
        $this->_db = new \mysqli("localhost", 'root', '', 'testtask', 3306);
        if ($this->_db->connect_error) {
            die("Connection failed: " . $this->_db->connect_error);
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    public function query($sql, array $fields)
    {
        $this->_error = false;
        if ($this->_query = $this->_db->prepare($sql)) {
            $x = "";
            if (count($fields)) {
                foreach ($fields as $field) {
                    if (is_string($field)) {
                        $x .= "s";
                        continue;
                    } elseif (is_int($field)) {
                        $x .= "i";
                        continue;
                    } elseif (is_float($field)) {
                        $x .= "d";
                        continue;
                    } else $x .= "b";
                }
            }
            $this->_query->bind_param($x, ...array_values($fields));
            if ($this->_query->execute()) {
                $results = $this->_query->get_result();
                if ($results) {
                    $this->_results = $results->fetch_all(MYSQLI_ASSOC);
                    $this->_count = count($this->_results);
                } else $this->_count = 0;
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }
    public function action($action, $table, $where = array())
    {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }
    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }
    public function getAll($table)
    {
        $results = $this->_db->query("SELECT * FROM $table");
        $this->_results = $results->fetch_all(MYSQLI_ASSOC);
        $this->_count = count($this->_results);
        return $this->_results;
    }
    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }
    public function insert($table, $fields = array()): bool
    {
        $keys = array_keys($fields);
        $values = '';
        $x = 1;
        foreach ($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }
        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }


    public function update($table, $id, $fields)
    {
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }
    public function results()
    {
        return $this->_results;
    }
    public function first()
    {
        return $this->results()[0];
    }
    public function error()
    {
        return $this->_error;
    }
    public function count()
    {
        return $this->_count;
    }
}
