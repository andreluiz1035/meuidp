<?php
session_start();

// 🔴 ALTERE AQUI PARA O DNS DO SEU IDP NO ACI
$IDP_URL = "http://tiririca-aci-dns.eastus.azurecontainer.io";

if (!isset($_SESSION['user'])) {

    $authorize_url = $IDP_URL . "/authorize.php?" . http_build_query([
        "client_id" => "app",
        "redirect_uri" => "http://tiririca-aci-dns.eastus.azurecontainer.io/callback.php"
    ]);

    header("Location: $authorize_url");
    exit;
}

echo "Logado como " . $_SESSION['user']['username'];