<?php
session_start();
require 'utils.php';

$code = $_POST['code'] ?? null;

if (!$code || !isset($_SESSION['code'])) {
    http_response_code(400);
    echo json_encode(["error" => "invalid_request"]);
    exit;
}

if ($_SESSION['code']['value'] !== $code) {
    http_response_code(400);
    echo json_encode(["error" => "invalid_code"]);
    exit;
}

$user = $_SESSION['code']['user'];

$token = generateToken($user);

echo json_encode([
    "access_token" => $token,
    "token_type" => "bearer"
]);