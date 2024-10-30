<?php
include '../inc/db.php';
session_start();

// Verifica se o usuário está logado e é administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Consultas para obter estatísticas
// Número total de produtos
$stmt = $conn->query("SELECT COUNT(*) AS total_produtos FROM produtos");
$total_produtos = $stmt->fetch(PDO::FETCH_ASSOC)['total_produtos'];

// Número total de pedidos
$stmt = $conn->query("SELECT COUNT(*) AS total_pedidos FROM pedidos");
$total_pedidos = $stmt->fetch(PDO::FETCH_ASSOC)['total_pedidos'];

// Total de vendas
$stmt = $conn->query("SELECT SUM(total) AS total_vendas FROM pedidos");
$total_vendas = $stmt->fetch(PDO::FETCH_ASSOC)['total_vendas'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Painel Administrativo</h2>

        <!-- Exibição das Estatísticas -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total de Produtos</h5>
                        <p class="card-text"><?php echo $total_produtos; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total de Pedidos</h5>
                        <p class="card-text"><?php echo $total_pedidos; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total de Vendas</h5>
                        <p class="card-text">R$<?php echo number_format($total_vendas, 2, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Links Rápidos -->
        <div class="row mt-4">
            <div class="col-md-6">
                <a href="produtos.php" class="btn btn-primary btn-block">Gerenciar Produtos</a>
            </div>
            <div class="col-md-6">
                <a href="pedidos.php" class="btn btn-secondary btn-block">Visualizar Pedidos</a>
            </div>
        </div>
    </div>
</body>
</html>
