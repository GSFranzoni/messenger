<?php 

    class Message extends Model implements JsonSerializable {
        protected $to, $from, $text, $moment;

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
               'to' => (int) $this->to,
               'from' => (int) $this->from,
               'text' => $this->text,
               'moment' => (int) $this->moment
            );
        }
        
    }
