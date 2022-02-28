<?php

class ChatRoom {
    public $Chat_ID;
    public $User_ID;
    public $name;
}

class ChatMessage {
    public $AmI;
    public $User_ID;
    public $message;
}

class ChatController{
    public static function get_personal_chats(PDO $db)
    {
        try {
            $query = $db->prepare('Select count(Chat_ID) as count from `chat` where ? IN(User1_ID, User2_ID)');
            $query->bindParam(1, $_SESSION["user_id"], PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if($result[0]["count"] > 0){
                $query = $db->prepare('SELECT Chat_ID, u.id, u.name FROM `chat` 
                inner join `user` as u on u.id IN(User1_ID, User2_ID) 
                WHERE 1 IN(User1_ID, User2_ID) and u.id != 1 group by Chat_ID ASC');
                $query->bindParam(1, $_SESSION["user_id"], PDO::PARAM_INT);
                $query->bindParam(2 ,$_SESSION["user_id"], PDO::PARAM_INT);
                $query->execute();
                
                $chat_rooms;
                while ($chat_room = $query->fetchObject(ChatRoom::class)) {
                    $chat_rooms[] = $chat_room;
                }
                
                throw new  Response($chat_rooms, 200);
            }else{
                throw new  Response("No chats found", 200);
            }
        } catch (PDOException $e) {
            throw new Response($e->getMessage(), 500);
        }
    }

    public static function get_chat_messages(PDO $db, $chat_id)
    {
        try {
            $query = $db->prepare('Select count(Chat_ID) as count from `chat` where Chat_ID = ?');
            $query->bindParam(1, $chat_id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            
            if($result[0]["count"] > 0){
                $query = $db->prepare('SELECT CASE WHEN User_ID = ? THEN 1 ELSE 0 END as "AmI", `User_ID`, `message` from `chat_message` where Chat_ID = ? order BY `Message_ID` asc');
                $query->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
                $query->bindParam(2, $chat_id, PDO::PARAM_INT);
                $query->execute();

                $chat_messages;
                while ($chat_room = $query->fetchObject(ChatMessage::class)) {
                    $chat_messages[] = $chat_room;
                }
                
                throw new  Response($chat_messages, 200);
            }else{
                throw new  Response("No valid Chat", 200);
            }
            throw new  Response("lol", 200);
        } catch (PDOException $e) {
            throw new Response($e->getMessage(), 500);
        }
    }
}
?>