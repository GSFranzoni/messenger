<?php 

    class ChatDAO extends DAO {

        static $columns = array('id', 'user1', 'user2');
        static $tableName = 'Chat';

        public static function getFromUsers($user1, $user2) {
            return Database::getResultsFromQuery("SELECT * FROM Chat WHERE (user1=${user1} AND user2=${user2}) OR (user1=${user2} AND user2=${user1})");
        }
        
    }

?>