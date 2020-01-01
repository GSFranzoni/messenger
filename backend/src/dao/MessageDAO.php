<?php 

    class MessageDAO extends DAO {

        static $columns = array('id', '_to', '_from', 'text', 'moment');
        static $tableName = 'Message';

        public static function getChat($user1, $user2) {
            return Database::getResultsFromQuery(
                "select * from Message WHERE 
                (${user1} = _to AND ${user2} = _from) OR 
                (${user2} = _to AND ${user1} = _from) ORDER BY moment;"
            );
        }
        
    }

?>