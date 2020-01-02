<?php 

    class UserDAO extends DAO {

        static $columns = array('id', 'name', 'email', 'password');
        static $tableName = 'User';

        public static function signin($email, $password) {
            if(!(int)Database::getResultsFromQuery("SELECT COUNT(*) FROM User WHERE email=". static::getFormatedValue($email))->fetch_array()[0]) {
                throw new Exception('Email não cadastrado!');
            }
            if(!(int)Database::getResultsFromQuery(
                "SELECT COUNT(*) FROM User WHERE email=". static::getFormatedValue($email). " AND password=". static::getFormatedValue($password))->fetch_array()[0]
            ) {
                throw new Exception('Email ou senha não correspondem!');
            }
            $user = static::getByEmail($email);
            return Auth::generateToken($user);
        }

        public static function signup($user) {
            foreach (static::$columns as $column) {
                if (!isset($user[$column]) and $column != 'id') {
                    throw new Exception('O campo ' . $column . ' é requerido!');
                    return;
                } else if ($user[$column] == '' and $column != 'id') {
                    throw new Exception('O campo ' . $column . ' é inválido!');
                    return;
                }
            }
            $values = " VALUES(0, ";
            foreach (static::$columns as $column) {
                if ($column != 'id')
                    $values .= static::getFormatedValue($user[$column]) . ",";
            }
            $values[strlen($values) - 1] = ')';
            Database::getResultsFromQuery("INSERT INTO " . static::$tableName . "(" . implode(',', static::$columns) . ")" . $values);
        }

        public static function getByEmail($email) {
            $result = Database::getResultsFromQuery("SELECT name, email, id FROM User WHERE email=". static::getFormatedValue($email));
            if($result->num_rows>0)
                return $result->fetch_assoc();
            return [];
        }
        
    }

?>