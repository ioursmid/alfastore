<!-- Fontes do Google e ícones do Font Awesome -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="font-family: 'Roboto', sans-serif;">
    <div class="container">
        <!-- Logo e Nome da Loja -->
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-mobile-alt"></i> Loja de Acessórios
        </a>

        <!-- Botão de Colapso para Mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links de Navegação -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./produto.php">
                        <i class="fas fa-box-open"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./contato.php">
                        <i class="fas fa-envelope"></i> Contato
                    </a>
                </li>
                
                <!-- Link para o Carrinho -->
                <li class="nav-item">
                    <a class="nav-link" href="./carrinho.php">
                        <i class="fas fa-shopping-cart"></i> Carrinho
                    </a>
                </li>

                <!-- Links Dinâmicos de Login/Logout -->
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">
                            <i class="fas fa-user-plus"></i> Registrar
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
