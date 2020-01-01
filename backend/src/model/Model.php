<?php 

    abstract class Model {
        public $id;

        public function __construct($data) {
            $this->loadFromArray($data);
        }

        public function loadFromArray($array) {
            if($array) {
                foreach ($array as $key => $value) {
                    $this->$key = $value;
                }
            }
        }

        public function __get($key) {
            return $this->values[$key];
        }
        public function __set($key, $value) {
            $this->values[$key] = $value;
        }

        public function toArray() {
            return get_object_vars($this);
        }

        public abstract static function fromJson($json);
        public abstract function toJson();
    }
