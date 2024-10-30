<?php
include '../inc/db.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: produtos.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    $imagem = $produto['imagem'];  // Manter a imagem antiga por padrão
    $uploadDir = '../uploads/';
    
    // Verifica se há uma nova imagem sendo enviada
    if (!empty($_FILES['imagem']['name'])) {
        $imagemName = basename($_FILES['imagem']['name']);
        $imagemPath = $uploadDir . $imagemName;
        $imagemType = strtolower(pathinfo($imagemPath, PATHINFO_EXTENSION));

        $validTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imagemType, $validTypes)) {
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath)) {
                $imagem = $imagemName;

                // Remove a imagem antiga se for substituída
                if (!empty($produto['imagem']) && file_exists($uploadDir . $produto['imagem'])) {
                    unlink($uploadDir . $produto['imagem']);
                }
            } else {
                echo "Erro ao enviar a nova imagem.";
            }
        } else {
            echo "Formato de imagem inválido. Use JPG, JPEG, PNG ou GIF.";
        }
    }

    $stmt = $conn->prepare("UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, estoque = :estoque, imagem = :imagem WHERE id = :id");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':estoque', $estoque);
    $stmt->bindParam(':imagem', $imagem);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: produtos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    <h2>Editar Produto</h2>
    <form method="post" action="produto_edit.php?id=<?php echo $produto['id']; ?>" enctype="multipart/form-data">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $produto['nome']; ?>" required><br>
        <label>Descrição:</label>
        <textarea name="descricao" required><?php echo $produto['descricao']; ?></textarea><br>
        <label>Preço:</label>
        <input type="number" name="preco" value="<?php echo $produto['preco']; ?>" step="0.01" required><br>
        <label>Estoque:</label>
        <input type="number" name="estoque" value="<?php echo $produto['estoque']; ?>" required><br>
        <label>Imagem Atual:</label><br>
        <?php if ($produto['imagem']): ?>
            <img src="../uploads/<?php echo $produto['imagem']; ?>" alt="Imagem do Produto" width="100"><br>
        <?php endif; ?>
        <label>Substituir Imagem:</label>
        <input type="file" name="imagem" accept="image/*"><br><br>
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
