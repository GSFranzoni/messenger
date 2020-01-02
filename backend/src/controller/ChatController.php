<?php 

    class ChatController extends Controller {

        static $dao = 'ChatDAO';
        static $model = 'Chat';
        
        public static function getFromUsers($user1, $user2) {
            $result = ChatDAO::getFromUsers($user1, $user2);
            if($result->num_rows===0) {
                ChatDAO::insert(array('user1' => $user1,'user2' => $user2));
            }
            $result = ChatDAO::getFromUsers($user1, $user2);
            $chat = $result->fetch_assoc();
            return $chat;
        }

    }

?>