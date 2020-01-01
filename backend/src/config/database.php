<?php 
    class Database {
        public static function getConnection() {
            $environmentPath = realpath(dirname(__FILE__). '/../environment.ini');
            $environment = parse_ini_file($environmentPath);
            $connection = new mysqli(
                $environment['host'], 
                $environment['username'], 
                $environment['password'],
                $environment['database'],
                $environment['port']
            );
            if($connection->error) {
                throw new Exception($connection->error);
            }
            return $connection;
        }

        public static function getResultsFromQuery($sql) {
            $connection = self::getConnection();
            $result = $connection->query($sql);
            if($connection->error) {
                throw new Exception($connection->error);
            }
            $connection->close();
            return $result;
        }

        public static function executeSQL($sql) {
            $conn = self::getConnection();
            if(!mysqli_query($conn, $sql)) {
                throw new Exception(mysqli_error($conn));
            }
            $id = $conn->insert_id;
            $conn->close();
            return $id;
        }
    }
?>