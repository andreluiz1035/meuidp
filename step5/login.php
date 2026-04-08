```php
<?php
session_start();
require 'utils.php';

// Se já estiver logado, redireciona
if (isset($_SESSION['user'])) {
    header("Location: /");
    exit;
}

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = getUsers();

    // Sanitiza input
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    foreach ($users['users'] as $user) {
        if (
            $user['username'] === $username &&
            (
                $password === $user['password'] || // plaintext
                password_verify($password, $user['password']) // bcrypt
            )
        ) {
            $_SESSION['user'] = $user;

            // Redireciona (ex: OAuth authorize)
            $redirect = $_GET['redirect'] ?? '/';
            header("Location: $redirect");
            exit;
        }
    }

    $erro = "Login inválido";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if ($erro): ?>
    <p style="color:red;"><?php echo $erro; ?></p>
<?php endif; ?>

<form method="POST">
    <input name="username" placeholder="Usuário" required>
    <br><br>
    <input name="password" type="password" placeholder="Senha" required>
    <br><br>
    <button type="submit">Entrar</button>
</form>

</body>
</html>

