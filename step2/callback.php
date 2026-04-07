<?php
session_start();

// 🔴 ALTERE AQUI PARA O DNS DO IDP
$IDP_URL = "http://idp-container.eastus.azurecontainer.io";

$code = $_GET['code'] ?? null;

if (!$code) {
    echo "Erro: code não recebido";
    exit;
}

// troca code por token
$response = file_get_contents($IDP_URL . "/token.php", false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded",
        'content' => http_build_query([
            'code' => $code
        ])
    ]
]));

$data = json_decode($response, true);

// ⚠️ Aqui simplificado (sem validar token ainda)
$_SESSION['user'] = [
    "username" => "andre"
];

header("Location: /index.php");