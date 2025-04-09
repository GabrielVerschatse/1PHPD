<?php

require_once 'connection_bdd.php';


// Handle GET requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $headers = getallheaders();
    $id = isset($headers['user_id']) ? $headers['user_id'] : '';
    $token = isset($headers['token']) ? $headers['token'] : '';
    $input = [
        "user_id" => $id,
        "token" => $token
    ];
    get_cart($input);

} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    if ($input["action"] == "add_cart") {
        add_cart($input);
    } else {
        http_response_code(400);
        echo json_encode("Invalid action");
    }

} else {
    http_response_code(400);
    echo json_encode("Invalid Method");
}






?>