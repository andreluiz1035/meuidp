<?php
session_start();

$IDP_URL = "http://meuidp123xyz-aci-dns-dns.brazilsouth.azurecontainer.io";
$REDIRECT_URI = "http://meuapp123xyz-aci-dns-dns.brazilsouth.azurecontainer.io/callback.php";

if (!isset($_SESSION['user'])) {
    $authorize_url = $IDP_URL . "/authorize.php?" . http_build_query([
        "client_id" => "app",
        "redirect_uri" => $REDIRECT_URI
    ]);

    header("Location: $authorize_url");
    exit;
}

echo "Logado como " . $_SESSION['user']['username'];