<?php
session_start();
require 'utils.php';

// Garante resposta em JSON
header('Content-Type: application/json');

// Pega dados do POST
$code = $_POST['code'] ?? null;
$client_id = $_POST['client_id'] ?? null;
$grant_type = $_POST['grant_type'] ?? null;

// Validação básica
if (!$code) {
    http_response_code(400);
    echo json_encode(["error" => "invalid_request", "error_description" => "code não enviado"]);
    exit;
}

// (Opcional, mas recomendado)
if ($grant_type && $grant_type !== 'authorization_code') {
    http_response_code(400);
    echo json_encode(["error" => "unsupported_grant_type"]);
    exit;
}

// (Opcional) validar client_id
if ($client_id && $client_id !== 'app') {
    http_response_code(400);
    echo json_encode(["error" => "invalid_client"]);
    exit;
}

/*
 ⚠️ IMPORTANTE:
 Aqui estamos SIMPLIFICANDO (mock).
 Em um OAuth real, você validaria o code em banco/cache.
*/

// Simula usuário associado ao code
//$user = "andre";
$user = [
    "id" => 1,
    "username" => "andre"
];


// Gera token (função que você já tem no utils.php)
$token = generateToken($user);

// Retorna resposta padrão
echo json_encode([
    "access_token" => $token,
    "token_type" => "bearer",
    "expires_in" => 3600,
    "username" => $user
]);