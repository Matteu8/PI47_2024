<?php
include("conexao.php");

// Inicia a sessão, caso ainda não tenha sido iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário está logado e se o tipo de usuário está na sessão
if (!isset($_SESSION['tipo_usuario'])) {
    // Redireciona para a página de login caso não esteja logado
    header("Location: login.php");
    exit();
}

// Verifica se o tipo de usuário é "cliente" e se o id_cliente está definido
if ($_SESSION['tipo_usuario'] == 'cliente' && !isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o tipo de usuário é "funcionario" e se o id_funcionario está definido
if ($_SESSION['tipo_usuario'] == 'funcionario' && !isset($_SESSION['id_funcionario'])) {
    header("Location: login.php");
    exit();
}

// Define a URL de redirecionamento para o botão "Voltar" com base no tipo de usuário
if ($_SESSION['tipo_usuario'] == 'cliente') {
    $voltar_url = "area_cliente.php";
} else if ($_SESSION['tipo_usuario'] == 'funcionario') {
    $voltar_url = "area_funcionarios.php";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senac-PR - Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php") ?>
    <h1 class="text-center" style="background-color: #FFA500; color: white;" >Pedidos</h1>

    <div class="container d-flex justify-content-center">
        <div class="row justify-content-center">
            <!-- Card 1 -->
            <div class="col-10 col-sm-6 col-md-4 mb-3 mt-5 d-flex justify-content-center">
                <div class="card" style="width: 100%;">
                    <img src="img/lanche.jfif" class="card-img-top" alt="Lanches" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Lanches</h5>
                        <a href="lanches.php" class="btn btn-primary">Pedir</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-10 col-sm-6 col-md-4 mb-3 mt-5 d-flex justify-content-center">
                <div class="card" style="width: 100%;">
                    <img src="img/bebida.jfif" class="card-img-top" alt="Bebidas" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Bebidas</h5>
                        <a href="bebidas.php" class="btn btn-primary">Pedir</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-10 col-sm-6 col-md-4 mb-3 mt-5 d-flex justify-content-center">
                <div class="card" style="width: 100%;">
                    <img src="img/sobremesa.jfif" class="card-img-top" alt="Sobremesas" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Sobremesas</h5>
                        <a href="#" class="btn btn-primary">Pedir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center mt-3">
        <button class="btn btn-primary">
            <a href="<?php echo isset($voltar_url) ? $voltar_url : 'login.php'; ?>" style="text-decoration: none; color: white;">Voltar</a>
        </button>
    </div>
    <br><br><br><br><br><br><br>
    <?php include("rodape.php") ?>
</body>

</html>
