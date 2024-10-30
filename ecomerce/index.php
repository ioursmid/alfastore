<?php
include 'inc/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Acessórios para Celular</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="font-family: 'Roboto', sans-serif;">
    <?php include 'inc/header.php'; ?>
    
    <!-- Conteúdo Principal -->
    <div class="container mt-4">
        <h2 class="text-center">Bem-vindo à nossa Loja de Acessórios para Celular!</h2>
        
        <!-- Barra de Pesquisa e Filtros de Categoria -->
        <form method="GET" action="index.php" class="form-inline justify-content-center my-3">
            <input type="text" name="search" class="form-control mr-2 mb-2 mb-md-0" placeholder="Buscar produtos..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <select name="categoria" class="form-control mr-2 mb-2 mb-md-0">
                <option value="">Todas as Categorias</option>
                <option value="capas" <?php if (isset($_GET['categoria']) && $_GET['categoria'] == 'capas') echo 'selected'; ?>>Capas</option>
                <option value="carregadores" <?php if (isset($_GET['categoria']) && $_GET['categoria'] == 'carregadores') echo 'selected'; ?>>Carregadores</option>
                <option value="peliculas" <?php if (isset($_GET['categoria']) && $_GET['categoria'] == 'peliculas') echo 'selected'; ?>>Películas</option>
            </select>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <!-- Vitrine de Produtos -->
        <div class="row mt-3">
            <?php
            // Constrói a consulta com filtros de pesquisa e categoria
            $query = "SELECT * FROM produtos WHERE 1";
            if (!empty($_GET['search'])) {
                $search = $_GET['search'];
                $query .= " AND (nome LIKE '%$search%' OR descricao LIKE '%$search%')";
            }
            if (!empty($_GET['categoria'])) {
                $categoria = $_GET['categoria'];
                $query .= " AND categoria = '$categoria'";
            }
            
            $stmt = $conn->query($query);
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Exibe os produtos em colunas responsivas
            foreach ($produtos as $produto): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <img src="uploads/<?php echo $produto['imagem']; ?>" class="card-img-top" alt="<?php echo $produto['nome']; ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                            <p class="card-text"><?php echo $produto['descricao']; ?></p>
                            <p class="card-text"><strong>R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong></p>
                            <div class="mt-auto">
                                <a href="produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-outline-info btn-block mb-2">Ver Detalhes</a>
                                <a href="carrinho.php?add_to_cart=<?php echo $produto['id']; ?>" class="btn btn-primary btn-block">Adicionar ao Carrinho</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php include 'inc/footer.php'; ?>

    <!-- Scripts do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
