<?php 

    class UserController extends Controller {

        static $dao = 'UserDAO';
        static $model = 'User';
        
        public static function signin($email, $password) {
            return UserDAO::signin($email, $password);
        }

        public static function signup($user) {
            UserDAO::signup($user);
        }

        public static function getByEmail($email) {
            return UserDAO::getByEmail($email);
        }

    }

?>