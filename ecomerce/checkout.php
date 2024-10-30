<?php
include 'inc/db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$produtos = [];
$total = 0;

// Obtém os produtos do carrinho
if (!empty($_SESSION['carrinho'])) {
    $ids = implode(",", array_keys($_SESSION['carrinho']));
    $stmt = $conn->query("SELECT * FROM produtos WHERE id IN ($ids)");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($produtos as $produto) {
        $quantidade = $_SESSION['carrinho'][$produto['id']];
        $total += $produto['preco'] * $quantidade;
    }
}

// Processa o pedido ao submeter o formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($produtos)) {
    // Insere o pedido no banco de dados
    $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (:usuario_id, :total)");
    $stmt->bindParam(':usuario_id', $_SESSION['usuario_id']);
    $stmt->bindParam(':total', $total);
    $stmt->execute();
    $pedido_id = $conn->lastInsertId();

    // Insere os itens do pedido
    foreach ($produtos as $produto) {
        $quantidade = $_SESSION['carrinho'][$produto['id']];
        $stmt = $conn->prepare("INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unitario) VALUES (:pedido_id, :produto_id, :quantidade, :preco_unitario)");
        $stmt->bindParam(':pedido_id', $pedido_id);
        $stmt->bindParam(':produto_id', $produto['id']);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':preco_unitario', $produto['preco']);
        $stmt->execute();
    }

    // Limpa o carrinho
    $_SESSION['carrinho'] = [];
    echo "<p>Pedido realizado com sucesso!</p>";
    echo "<a href='index.php'>Voltar para a Página Inicial</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
</head>
<body>
    <h2>Resumo do Pedido</h2>
    <?php if ($produtos): ?>
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
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $_SESSION['carrinho'][$produto['id']]; ?></td>
                        <td>R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                        <td>R$<?php echo number_format($produto['preco'] * $_SESSION['carrinho'][$produto['id']], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: R$<?php echo number_format($total, 2, ',', '.'); ?></h3>
        <form method="post" action="checkout.php">
            <button type="submit">Confirmar Pedido</button>
        </form>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>
</body>
</html>
