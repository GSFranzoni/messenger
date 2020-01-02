<?php 

    class User extends Model implements JsonSerializable {
        protected $name, $admin, $email, $password;

        public function __construct($data){
            parent::__construct($data);
        }

        public function toJson() {
            return json_encode(array_merge(parent::toArray(), get_object_vars($this)));
        }

        public static function fromJson($json) {
            return new User(json_decode($json, true));
        }

        public function jsonSerialize() {
            return Array(
               'id' => (int) $this->id,
               'name' => $this->name,
               'email' => $this->email
            );
        }
        
    }
