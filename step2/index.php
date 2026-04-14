<?php
/*
session_start();
Em camada 3 acontece isso:
cliente: SYN
server: SYN - ACK
cliente: SYN

Em camada 4 aconteece isso:
O cliente faz uma solicitação HTTP com um GET no arquivo index e passa um cookie de sessão, uma variável,
com um valor aleatório. Entendo que isso é nativo do browser.
GET /index.php HTTP/1.1
Host: meuapp...
Cookie: PHPSESSID=abc123

Quando o server side executa session_start(); , ele lê a variável Cookie. Se o valor já existir (fica salvo
em arquivo no disco, ele carrega uma sessão existente (um elemento no vetor $_SESSION). Se não existir ele cria uma nova.

Estrutura do array $_SESSION

$_SESSION = [
    "user" => [
        "id" => 42,
        "username" => "andre",
        "roles" => ["admin", "user"]
    ],
    "csrf_token" => "abc123",
    "login_time" => 1712750000
];

E salvo em disco em /var/lib/php/sessions/sess_<ID>

Isso me dá a entender que dessa forma a sessão de usuário é desplugada da conexão TCP. O que parece ser 
mais seguro, por que o cookie pode ter um TTL grande (facilitar a vida do usuário), e o time out da conexão
em L3 seguir o padrão do TCP, mitigando ataques de deixar muitas sessões abertas e esgotar recurso do servidor.
E quando a conexão TCP é legítima (F5 num browser inativo por exemplo), o server reusa a sessão, em nova conexão TCP.

*/
session_start();

/*
Trabalhando com ACI descobri que o azure por arquitetura não resolve DNS de serviço do azure dentro de conteiner, imagino
que pra evitar ataques.
Mas aqui não da problema por que essas urls são usadas com comandos HTTP Redirect no navegador do cliente, então a 
a resolução de nomes é externa, por conta do DNS da placa de rede do cliente.
*/



$IDP_URL = "http://meuidp123xyz-aci-dns-dns.brazilsouth.azurecontainer.io";
$REDIRECT_URI = "http://meuapp123xyz-aci-dns-dns.brazilsouth.azurecontainer.io/callback.php";

/*
$_SESSION → array carregado pela função  session_start(), acredito que com todas as sessões.

caso 1:
$_SESSION = []
→ user NÃO existe 
> Executa o código dentro do if, redireciona o usuário para logar no idp.
> O REDIRECT_URI é a url de volta para a aplicação, depois do usuário autenticar no idp.
caso 2:
$_SESSION = ["user" => [...]]
→ user existe

O comando header, envia o HTTP Redirect para o browser do cliente, redirecionando para o idp, chamando o authorize.php

*/





if (!isset($_SESSION['user'])) {
    $authorize_url = $IDP_URL . "/authorize.php?" . http_build_query([
        "client_id" => "app",
        "redirect_uri" => $REDIRECT_URI
    ]);

    header("Location: $authorize_url");
    exit;
}

#*Se a sessão ja existe, aproveita ela.

echo "Logado como " . $_SESSION['user']['username'];