```php
<?php
session_start();
require 'utils.php';

$client_id = $_GET['client_id'] ?? null;
$redirect_uri = isset($_GET['redirect_uri']) ? urldecode($_GET['redirect_uri']) : null;

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

// evita quebrar URL que já tem query string
$separator = (parse_url($redirect_uri, PHP_URL_QUERY) ? '&' : '?');

// redireciona corretamente
header("Location: {$redirect_uri}{$separator}code={$code}");
exit;
```
