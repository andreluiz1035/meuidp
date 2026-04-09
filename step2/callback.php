<?php
session_start();

// 🔴 URL do IdP (outro container)
$IDP_URL = "http://meuidp123xyz-aci-dns-dns.brazilsouth.azurecontainer.io";

// Pega o 'code' enviado pelo IdP
$code = $_GET['code'] ?? null;

if (!$code) {
    echo "Erro: code não recebido";
    exit;
}

// Troca o code por token (simulação, você pode implementar validação real depois)
$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded",
        'content' => http_build_query([
            'code' => $code,
            'client_id' => 'app'       // importante enviar o client_id
        ])
    ]
];

$response = file_get_contents($IDP_URL . "/token.php", false, stream_context_create($options));

if (!$response) {
    echo "Erro ao conectar com IdP para obter token";
    exit;
}

// Decodifica o JSON do token (aqui simplificado)
$data = json_decode($response, true);

// ⚠️ Aqui simplificado: sem validar assinatura do token
$_SESSION['user'] = [
    "username" => $data['username'] ?? 'andre'
];

// Redireciona de volta para a página principal da aplicação cliente
header("Location: /index.php");
exit;