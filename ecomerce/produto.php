<?php
include 'inc/db.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $produto['nome']; ?> - Detalhes</title>
</head>
<body>
    <?php include 'inc/header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="uploads/<?php echo $produto['imagem']; ?>" class="img-fluid" alt="<?php echo $produto['nome']; ?>">
            </div>
            <div class="col-md-6">
                <h2><?php echo $produto['nome']; ?></h2>
                <p><?php echo $produto['descricao']; ?></p>
                <h3>R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></h3>
                <a href="carrinho.php?add_to_cart=<?php echo $produto['id']; ?>" class="btn btn-primary">Adicionar ao Carrinho</a>
            </div>
        </div>
    </div>

    <?php include 'inc/footer.php'; ?>
</body>
</html>
