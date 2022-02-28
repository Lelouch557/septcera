<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include_once "api.php";
// Usage:       https://iabamun.nl/game/lab-jari/api/index.php/ + uri
// Protocol:    JSON

// Include controllers
include_once "controllers/UserController.php";
include_once "controllers/Chat.php";
include_once "controllers/Economy.php";
include_once "controllers/Resource.php";

// Create API
$api = new API();

// Setup database PDO connection
$api->SetDB("localhost", "deb118487_iabamun", "deb118487_iabamun", "ZyAvvBc33U");

// Security
$api->AddBefore(function($pdo, $permission) { UserController::CheckLogin($pdo, $permission); });

// User entrypoints
$api->Add(PERMISSION::NONE,     HTTP::POST, "/login",               function($pdo, $args, $payload) { UserController::Login($pdo, $payload); });
$api->Add(PERMISSION::NONE,     HTTP::POST, "/logout",              function($pdo, $args, $payload) { UserController::Logout(); });
// $api->Add(PERMISSION::USER,     HTTP::GET,  "/users",       function($pdo, $args, $payload) { UserController::GetUsers($pdo); });
$api->Add(PERMISSION::USER,     HTTP::GET,  "/users/<id>",          function($pdo, $args, $payload) { UserController::GetUserById($pdo, $args["id"]); });
// $api->Add(PERMISSION::USER,     HTTP::GET,  "/user",        function($pdo, $args, $payload) { UserController::GetUser(); });
// $api->Add(PERMISSION::USER,     HTTP::POST, "/user",        function($pdo, $args, $payload) { UserController::UpsertUser($pdo, $payload); });

// User entrypoints
$api->Add(PERMISSION::USER,     HTTP::GET,  "/chat",                function($pdo, $args, $payload) { ChatController::get_personal_chats($pdo); });
$api->Add(PERMISSION::USER,     HTTP::GET,  "/chat/<id>",           function($pdo, $args, $payload) { ChatController::get_chat_messages($pdo, $args["id"]); });

// market entrypoints
$api->Add(PERMISSION::USER,     HTTP::GET,  "/accept_order/<id>/<r_id>",   function($pdo, $args, $payload) { EconomyController::accept_order($pdo, $args["id"], $args["r_id"]); });
$api->Add(PERMISSION::USER,     HTTP::GET,  "/orders/<id>",              function($pdo, $args, $payload) { EconomyController::get_orders($pdo, $args["id"]); });
$api->Add(PERMISSION::USER,     HTTP::GET,  "/values",              function($pdo, $args, $payload) { EconomyController::get_values($pdo); });

// resource entrypoints
$api->Add(PERMISSION::NONE,     HTTP::POST,  "/resources/increment", function($pdo, $args, $payload) { ResourceController::increment_resources($pdo); });


$api->Add(PERMISSION::NONE,     HTTP::GET,  "/login",               function($pdo, $args, $payload) { throw new Response("Wassup"); });

// Start API
$api->Listen();