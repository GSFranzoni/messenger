<?php

class DAO
{

    protected static $columns = array();
    protected static $tableName = 'TableName';

    public static function get($id)
    {
        return Database::getResultsFromQuery("SELECT " . implode(',', static::$columns) . " FROM " . static::$tableName . " WHERE id=${id}");
    }

    public static function count()
    {
        return (int) Database::getResultsFromQuery("SELECT COUNT(*) as count FROM " . static::$tableName)->fetch_array()[0];
    }

    public static function getAll()
    {
        return Database::getResultsFromQuery("SELECT " . implode(',', static::$columns) . " FROM " . static::$tableName);
    }

    public static function delete($id)
    {
        Database::getResultsFromQuery("DELETE FROM " . static::$tableName . " WHERE id=${id}");
    }

    public static function update($id, $object)
    {
        $set = ' SET';
        foreach ($object as $key => $value) {
            if (($value === '') and $key != 'id') {
                throw new Exception('O campo ' . $key . ' é inválido!');
                return;
            }
            $set .= " ${key}=" . static::getFormatedValue($value) . ",";
        }
        $set[strlen($set) - 1] = ' ';
        Database::getResultsFromQuery("UPDATE " . static::$tableName . $set . " WHERE id=${id}");
    }

    public static function insert($object)
    {
        foreach (static::$columns as $column) {
            if (!isset($object[$column]) and $column != 'id') {
                throw new Exception('O campo ' . $column . ' é requerido!');
                return;
            } else if ($object[$column] === '' and $column != 'id') {
                throw new Exception('O campo ' . $column . ' é inválido!');
                return;
            }
        }
        $values = " VALUES(0, ";
        foreach (static::$columns as $column) {
            if ($column != 'id')
                $values .= static::getFormatedValue($object[$column]) . ",";
        }
        $values[strlen($values) - 1] = ')';
        Database::getResultsFromQuery("INSERT INTO " . static::$tableName . "(" . implode(',', static::$columns) . ")" . $values);
    }

    public static function stats() {
        return array(
            'users' => UserDAO::count(),
            'categories' => CategoryDAO::count(),
            'articles' => ArticleDAO::count()
        );
    }

    public static function getFormatedValue($value)
    {
        if (is_null($value)) {
            return "null";
        } elseif (gettype($value) === 'string') {
            return "'${value}'";
        } else {
            return $value;
        }
    }
}
