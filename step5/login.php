<?php
session_start();
require 'utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = getUsers();

    foreach ($users['users'] as $user) {
        if ($user['username'] === $_POST['username'] &&
            password_verify($_POST['password'], $user['password'])) {

            $_SESSION['user'] = $user;

            // volta para authorize
            $redirect = $_GET['redirect'] ?? '/';
            header("Location: $redirect");
            exit;
        }
    }

    echo "Login inválido";
}
?>

<form method="POST">
  <input name="username" placeholder="user">
  <input name="password" type="password">
  <button>Login</button>
</form>