<?php
include '../inc/db.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: pedidos.php");
    exit;
}

$id = $_GET['id'];

// Consulta para buscar o pedido
$stmt = $conn->prepare("SELECT * FROM pedidos WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

// Consulta para buscar itens do pedido
$stmt = $conn->prepare("SELECT p.nome, pi.quantidade, pi.preco_unitario 
                        FROM pedido_itens pi 
                        JOIN produtos p ON pi.produto_id = p.id 
                        WHERE pi.pedido_id = :pedido_id");
$stmt->bindParam(':pedido_id', $id);
$stmt->execute();
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido</title>
</head>
<body>
    <h2>Detalhes do Pedido #<?php echo $pedido['id']; ?></h2>
    <p><strong>Data do Pedido:</strong> <?php echo $pedido['criado_em']; ?></p>
    <p><strong>Total:</strong> R$<?php echo number_format($pedido['total'], 2, ',', '.'); ?></p>

    <h3>Produtos</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itens as $item): ?>
                <tr>
                    <td><?php echo $item['nome']; ?></td>
                    <td><?php echo $item['quantidade']; ?></td>
                    <td>R$<?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></td>
                    <td>R$<?php echo number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="pedidos.php">Voltar aos pedidos</a>
</body>
</html>
