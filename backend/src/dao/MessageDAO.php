<?php 

    class MessageDAO extends DAO {

        static $columns = array('id', '_from', '_to', 'chat', 'text', 'moment');
        static $tableName = 'Message';

        public static function getFromChat($chat) {
            return Database::getResultsFromQuery(
                "select * from Message WHERE chat=${chat} ORDER BY moment;"
            );
        }
        
    }

?>