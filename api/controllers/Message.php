<?php

class PERMISSION {
    const NONE = 0;
    const USER = 1;
    const ADMIN = 2;
}

// class Response extends Exception {
//     private $json_content;

//     public function __construct($json_content, $code = 200) {
//         parent::__construct("", $code, null);
//         $this->json_content = $json_content;
//     }

//     public function __toString() {
//         header( "HTTP/2.0 " . $this->code, true, $this->code );
//         return json_encode( ["response" => $this->json_content] );
//     }
// }

class Message {
    public $amount;
}

class MessageController{
    public static function get_new_messages(PDO $db)
    {
        try {
            $query = $db->prepare('Select Count(*) as count from `messages` where reciever=? AND seen=0');
            $query->bindParam(1,$_SESSION['user_id'],PDO::PARAM_INT);
            if($query->execute()) {
                throw new  Response($query->fetchObject(Message::class));
            }
        } catch (PDOException $e) {
            throw new Response($e->getMessage(), 500);
        }
    }
}
?>