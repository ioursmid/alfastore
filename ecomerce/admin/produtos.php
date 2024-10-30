<?php
include '../inc/db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] != 1) {  // Apenas o usuário 1 como admin
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Produtos</title>
</head>
<body>
    <h2>Gerenciamento de Produtos</h2>
    <a href="produto_add.php">Adicionar Novo Produto</a>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?php echo $produto['nome']; ?></td>
                    <td><?php echo $produto['descricao']; ?></td>
                    <td>R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $produto['estoque']; ?></td>
                    <td>
                        <a href="produto_edit.php?id=<?php echo $produto['id']; ?>">Editar</a> |
                        <a href="produto_delete.php?id=<?php echo $produto['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
