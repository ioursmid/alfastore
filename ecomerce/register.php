<?php
include 'inc/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);

    if ($stmt->execute()) {
        $_SESSION['usuario_id'] = $conn->lastInsertId();
        $_SESSION['nome'] = $nome;
        header("Location: index.php");
    } else {
        echo "Erro ao registrar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
</head>
<body>
    <h2>Registrar</h2>
    <form method="post" action="register.php">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
