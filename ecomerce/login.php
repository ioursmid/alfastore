<?php
include 'inc/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        header("Location: index.php");
    } else {
        echo "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
