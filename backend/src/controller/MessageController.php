<?php 

    class MessageController extends Controller {

        static $dao = 'MessageDAO';
        static $model = 'Message';
        
        public static function getChat($user1, $user2) {
            $result = MessageDAO::getChat($user1, $user2);
            $messages = [];
            while($message = $result->fetch_assoc()) {
                $message['to'] = UserController::get($message['_to'])['name'];
                $message['from'] = UserController::get($message['_from'])['name'];
                unset($message['_to']);
                unset($message['_from']);
                array_push($messages, $message);
            }
            return $messages;
        }

    }

?>