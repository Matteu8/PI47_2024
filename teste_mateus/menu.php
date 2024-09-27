<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #3a6da1;">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Logo">
        </a>

        <!-- Botão de "hamburger" para dispositivos móveis -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Itens do menu que serão mostrados/ocultados -->
        <div class="collapse navbar-collapse me-5" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="deslog_lanches.php">Lanches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="deslog_bebidas">Bebidas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="deslog_sobremesas">Sobremesas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="lanches.php">Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Sobre Nós</a>
                </li>
                <?php if (isset($_SESSION['tipo_usuario'])): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="sair.php">Sair</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>