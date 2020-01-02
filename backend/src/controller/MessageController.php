<?php 

    class MessageController extends Controller {

        static $dao = 'MessageDAO';
        static $model = 'Message';
        
        public static function getFromChat($chat) {
            $result = MessageDAO::getFromChat($chat);
            $messages = [];
            while($message = $result->fetch_assoc()) {
                $message['to'] = UserController::get($message['_to']);
                $message['from'] = UserController::get($message['_from']);
                unset($message['_to'], $message['_from']);
                array_push($messages, $message);
            }
            return $messages;
        }

        public static function insert($message) {
            $message['chat'] = ChatDAO::getFromUsers($message['_to'], $message['_from'])->fetch_array()[0];
            MessageDAO::insert($message);
        }

    }

?>