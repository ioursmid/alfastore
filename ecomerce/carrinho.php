<?php
include 'inc/db.php';
session_start();

$produtos = [];
$total = 0;

// Atualiza a quantidade do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_carrinho'])) {
    foreach ($_POST['quantidade'] as $produto_id => $quantidade) {
        if ($quantidade <= 0) {
            unset($_SESSION['carrinho'][$produto_id]);  // Remove o produto se a quantidade for zero ou menos
        } else {
            $_SESSION['carrinho'][$produto_id] = $quantidade;  // Atualiza a quantidade
        }
    }
}

// Exibe os produtos no carrinho
if (!empty($_SESSION['carrinho'])) {
    $ids = implode(",", array_keys($_SESSION['carrinho']));
    $stmt = $conn->query("SELECT * FROM produtos WHERE id IN ($ids)");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($produtos as $produto) {
        $quantidade = $_SESSION['carrinho'][$produto['id']];
        $total += $produto['preco'] * $quantidade;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
</head>
<body>
    <h2>Seu Carrinho</h2>
    <?php if ($produtos): ?>
        <form method="post" action="carrinho.php">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?php echo $produto['nome']; ?></td>
                            <td>
                                <input type="number" name="quantidade[<?php echo $produto['id']; ?>]" value="<?php echo $_SESSION['carrinho'][$produto['id']]; ?>" min="0">
                            </td>
                            <td>R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                            <td>R$<?php echo number_format($produto['preco'] * $_SESSION['carrinho'][$produto['id']], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total: R$<?php echo number_format($total, 2, ',', '.'); ?></h3>
            <button type="submit" name="atualizar_carrinho">Atualizar Carrinho</button>
            <a href="checkout.php">Finalizar Compra</a>
        </form>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>
</body>
</html>
