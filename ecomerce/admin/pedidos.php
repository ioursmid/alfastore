<?php
include '../inc/db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Consulta para listar pedidos
$stmt = $conn->query("SELECT * FROM pedidos ORDER BY criado_em DESC");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pedidos</title>
</head>
<body>
    <h2>Relatório de Pedidos</h2>
    <table>
        <thead>
            <tr>
                <th>ID do Pedido</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?php echo $pedido['id']; ?></td>
                    <td><?php echo $pedido['criado_em']; ?></td>
                    <td><?php
                        $usuario_stmt = $conn->prepare("SELECT nome FROM usuarios WHERE id = :usuario_id");
                        $usuario_stmt->bindParam(':usuario_id', $pedido['usuario_id']);
                        $usuario_stmt->execute();
                        $usuario = $usuario_stmt->fetch(PDO::FETCH_ASSOC);
                        echo $usuario['nome'];
                    ?></td>
                    <td>R$<?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                    <td><a href="pedido_detalhes.php?id=<?php echo $pedido['id']; ?>">Ver Detalhes</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
