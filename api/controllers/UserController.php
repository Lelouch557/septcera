<?php

class PERMISSION {
    const NONE = 0;
    const USER = 1;
    const ADMIN = 2;
}

class User
{
    public $id;
    public $name;
    public $password;
    public $mail;
    public $phone_number;
    public $phone_number2;
    public $age;
    public $city;
    public $text;
    public $points;
    public $salt;
    public $active;
    public $last_ping;
}

class UserController
{
    public static $currentUser = null;

    public static function GetUser() {
        throw new Response(UserController::$currentUser);
    }

    public static function GetUsers(PDO $pdo)
    {
        try {
            $query = $pdo->prepare("SELECT * FROM user");
            if($query->execute()) {
                $users = [];
                while($user = $query->fetchObject(User::class)) {
                    unset($user->password);
                    unset($user->salt);
                    $users[] = $user;
                }
                throw new Response($users);
            }
        } catch (PDOException $e) {
            throw new Response($e->getMessage(), 500);
        }
    }

    public static function GetUserById(PDO $pdo, $id)
    {
        try {
            $query = $pdo->prepare("SELECT * FROM user WHERE `id` = :id");
            $query->bindParam(":id", $id);
            if($query->execute()) {
                $user = $query->fetchObject(User::class);
                if($user == null) throw new Response("User does not exist.", 400);
                unset($user->password);
                unset($user->salt);
                throw new Response($user);
            }
        } catch (PDOException $e) {
            throw new Response($e->getMessage(), 500);
        }
    }

    public static function UpsertUser(PDO $pdo, $user)
    {
        throw new Response($user);
    }

    public static function Login(PDO $pdo, $payload) {
        // Validation
        if( !preg_match('/^[0-9a-zA-Z_]{1,16}$/', $payload->name)) {
            throw new Response(  $payload, 400);
        }

        $query = $pdo->prepare( "SELECT * FROM user WHERE name = :name" );
        $query->bindParam(":name", $payload->name);

        if( $query->execute() ) {
            $user = $query->fetchObject(User::class);
            if(isset($user->password)){
                if(password_verify($payload->password, $user->password)) {
                    $query = $pdo->prepare( "SELECT village_id FROM `user_village` WHERE `user_id` = ? limit 1" );
                    $query->bindParam(1, $user->id);
                    $query->execute();
                    $village = $query->fetchall(PDO::FETCH_ASSOC);
                    if(count($village) > 0){
                        $_SESSION["user_id"] = $user->id;
                        $_SESSION['village_id'] = $village[0]['village_id'];
                        throw new Response("Logged in", 200);
                    }
                }
            }
        }
        throw new Response( "Username and/or password is incorrect", 409);
    }

    public static function Logout() {
        unset($_SESSION["user_id"]);
        unset($_SESSION["village_id"]);
        throw new Response("Logged out");
    }

    public static function CheckLogin(PDO $pdo, $permission) {
        if($permission == PERMISSION::NONE) return;

        if(isset($_SESSION["user_id"])) {
            try {
                $query = $pdo->prepare("SELECT * FROM user WHERE id = :id");
                $query->bindParam(":id", $_SESSION["user_id"]);
                if($query->execute()) {
                    $user = $query->fetchObject(User::class);
                    if($user == null) throw new Response("Unauthorized", 401);
                    unset($user->password);
                    unset($user->salt);
                    UserController::$currentUser = $user;
                    return;
                }
            } catch (PDOException $e) {
                throw new Response($e->getMessage(), 500);
            }
        }
        throw new Response("Unauthorized", 401);
    }
}
