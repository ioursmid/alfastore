<?php
include '../inc/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    // Diretório de upload e tratamento do arquivo de imagem
    $uploadDir = '../uploads/';
    $imagem = null;
    if (!empty($_FILES['imagem']['name'])) {
        $imagemName = basename($_FILES['imagem']['name']);
        $imagemPath = $uploadDir . $imagemName;
        $imagemType = strtolower(pathinfo($imagemPath, PATHINFO_EXTENSION));

        // Verifica se o arquivo é uma imagem válida
        $validTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imagemType, $validTypes)) {
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath)) {
                $imagem = $imagemName;  // Nome do arquivo para salvar no banco
            } else {
                echo "Erro ao enviar a imagem.";
            }
        } else {
            echo "Formato de imagem inválido. Use JPG, JPEG, PNG ou GIF.";
        }
    }

    // Insere o produto no banco com o nome do arquivo de imagem
    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, estoque, imagem) VALUES (:nome, :descricao, :preco, :estoque, :imagem)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':estoque', $estoque);
    $stmt->bindParam(':imagem', $imagem);
    $stmt->execute();

    header("Location: produtos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Produto</title>
</head>
<body>
    <h2>Adicionar Produto</h2>
    <form method="post" action="produto_add.php" enctype="multipart/form-data">
        <label>Nome:</label>
        <input type="text" name="nome" required><br>
        <label>Descrição:</label>
        <textarea name="descricao" required></textarea><br>
        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" required><br>
        <label>Estoque:</label>
        <input type="number" name="estoque" required><br>
        <label>Imagem:</label>
        <input type="file" name="imagem" accept="image/*"><br><br>
        <button type="submit">Adicionar Produto</button>
    </form>
</body>
</html>
