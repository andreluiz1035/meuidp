<?php
// Caminho do arquivo que vai armazenar os usuários
$filename = "users.txt";
$message = "";

// Quando o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");

    if (!empty($username)) {
        // Escreve no arquivo, adicionando nova linha
        file_put_contents($filename, $username . PHP_EOL, FILE_APPEND | LOCK_EX);
        $message = "Usuário '$username' cadastrado com sucesso!";
    } else {
        $message = "Digite um nome de usuário!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h1>Sou eu, o Tiririca!</h1>

    <?php if ($message): ?>
        <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Nome do usuário:</label>
        <input type="text" id="username" name="username" required>
        <button type="submit">Cadastrar usuário</button>
    </form>

    <h2>Usuários cadastrados:</h2>
    <ul>
        <?php
        if (file_exists($filename)) {
            $users = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($users as $user) {
                echo "<li>" . htmlspecialchars($user) . "</li>";
            }
        } else {
            echo "<li>Nenhum usuário cadastrado ainda.</li>";
        }
        ?>
    </ul>
</body>
</html>