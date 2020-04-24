<?php 
#<!-- This is protected route. Accessed by only loggged in users -->
include_once 'config/dbh.php';
include_once '../vendor/autoload.php';

use \Firebase\JWT\JWT;

include_once 'config/cors.php';

// get request headers
$authHeader = getallheaders();
if (isset($authHeader['Authorization']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $authHeader['Authorization'];
    $token = explode(" ", $token)[1];

    try {
        $key = "YOUR_SECRET_KEY";
        $decoded = JWT::decode($token, $key, array('HS256'));

        // Do some actions if token decoded successfully.

        // But for this demo let return decoded data
        http_response_code(200);
        echo json_encode($decoded);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array('message' => 'Please authenticate'));
    }
} else {
    http_response_code(401);
    echo json_encode(array('message' => 'Please authenticate'));
}