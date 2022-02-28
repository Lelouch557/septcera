<?php

abstract class HTTP {
    const GET = "GET";
    const POST = "POST";
    const DELETE = "DELETE";
}

class EntryPoint {
    public $method;
    public $uri;
    public $action;
    public $beforeArgs;
    public function __construct($method, $uri, $action, $beforeArgs) {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = @$action;
        $this->beforeArgs = $beforeArgs;
    }
}

class Response extends Exception {
    private $json_content;

    public function __construct($json_content, $code = 200) {
        parent::__construct("", $code, null);
        $this->json_content = $json_content;
    }

    public function __toString() {
        header( "HTTP/2.0 " . $this->code, true, $this->code );
        return json_encode( ["response" => $this->json_content] );
    }
}

class API {
    private $entrypoints = [];
    private $pdo = null;
    private $before = [];

    public function Add($beforeArgs, $method, $uri, $action)
    {
        $this->entrypoints[] = new EntryPoint($method, $uri, $action, $beforeArgs);
    }

    public function SetDB($database_host, $database_name, $database_user, $database_pass) {
        try {
            $this->pdo = new PDO("mysql:host=" . $database_host . ";dbname=" . $database_name . ";", $database_user, $database_pass, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ));
        }catch(PDOException $e) {
            throw new Response("Unable to connect to database", 500);
        }
    }

    public function AddBefore($action) {
        $this->before[] = $action;
    }

    public function Listen()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        session_start();
        $path = $_SERVER["PATH_INFO"];
        $method = $_SERVER["REQUEST_METHOD"];
        $raw_payload = file_get_contents('php://input');
        $payload = json_decode($raw_payload);
        // throw new Response($payload);

        try {
            foreach ($this->entrypoints as $entrypoint) {
                if($entrypoint->method !== $method) continue;
                $regex = str_replace("/", "\/", $entrypoint->uri);
                $regex = @"/^" . preg_replace(@"/<([a-zA-Z0-9_]+)>/", "(?'$1'[a-zA-Z0-9_]+)", $regex) . "$/";
                if(!preg_match($regex, $path, $matches)) continue;
                
                foreach($this->before as $before) $before($this->pdo, $entrypoint->beforeArgs);
                
                $f = @$entrypoint->action;
                $f($this->pdo, $matches, $payload);
            }
            
            throw new Response("Unknown request", 400);
        } catch (Response $e) {
            echo $e;
        }
    }
}