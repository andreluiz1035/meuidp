<?php
session_start();

// 🔴 URL do IdP (corrigido - sem duplicação de dns)
$IDP_URL = "http://meuidp123xyz-aci-dns.brazilsouth.azurecontainer.io";

// Pega o 'code' enviado pelo IdP
$code = $_GET['code'] ?? null;

if (!$code) {
    echo "Erro: code não recebido";
    exit;
}

// Monta requisição para trocar code por token
$postData = http_build_query([
    'grant_type' => 'authorization_code',
    'code'       => $code,
    'client_id'  => 'app'
]);

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => $postData,
        'timeout' => 10
    ]
];

// Faz chamada ao IdP
$response = @file_get_contents(
    $IDP_URL . "/token.php",
    false,
    stream_context_create($options)
);

// Tratamento de erro de conexão
if ($response === false) {
    echo "Erro ao conectar com IdP para obter token";
    exit;
}

// Decodifica resposta JSON
$data = json_decode($response, true);

// Validação básica da resposta
if (!$data || !isset($data['access_token'])) {
    echo "Erro: resposta inválida do IdP";
    echo "<pre>";
    print_r($data);
    exit;
}

// ⚠️ Aqui simplificado (sem validar token de verdade)
$_SESSION['user'] = [
    "username" => $data['username'] ?? 'andre'
];

// (Opcional) salvar token na sessão
$_SESSION['access_token'] = $data['access_token'];

// Redireciona para aplicação
header("Location: /index.php");
exit;