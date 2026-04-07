<?php
session_start();
require 'utils.php';

$client_id = $_GET['client_id'] ?? null;
$redirect_uri = $_GET['redirect_uri'] ?? null;

if (!$client_id || !$redirect_uri) {
    http_response_code(400);
    echo "missing parameters";
    exit;
}

// se não estiver logado → vai pro login
if (!isset($_SESSION['user'])) {
    header("Location: /login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

// gera code
$code = generateCode();

// salva code na sessão
$_SESSION['code'] = [
    "value" => $code,
    "user" => $_SESSION['user']
];

// redireciona de volta para a aplicação
header("Location: $redirect_uri?code=$code");
exit;