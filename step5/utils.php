<?php
function getUsers() {
    return json_decode(file_get_contents('users.json'), true);
}

function generateCode() {
    return bin2hex(random_bytes(16));
}

function generateToken($user) {
    $payload = [
        "sub" => $user['id'],
        "name" => $user['username'],
        "iat" => time(),
        "exp" => time() + 3600
    ];

    return base64_encode(json_encode($payload));
}