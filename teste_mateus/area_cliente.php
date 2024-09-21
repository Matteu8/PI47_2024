<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();

}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <div class="row" style="background-color:#3a6da1;">
        <div class="col-md-12">
            <a href="">
                <img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Logo">
            </a>
        </div>
    </div>

    <div class="container mt-4">
        <h1>Área do Cliente</h1>
        <p>Nome: <?php echo $_SESSION["nome"]; ?></p>

        <div class="list-group mt-3">
            <a href="pedido.php" class="list-group-item list-group-item-action">Fazer Pedidos</a>
            <a href="#" class="list-group-item list-group-item-action">Visualizar Pedidos</a>
            <a href="#" class="list-group-item list-group-item-action">Cancelar Pedidos</a>
            <a href="#" class="list-group-item list-group-item-action">Alterar Pedidos</a>
            <a href="alterar_conta_cliente.php" class="list-group-item list-group-item-action">Alterar Conta</a>
            <a href="deletar_conta_cliente.php" class="list-group-item list-group-item-action">Deletar Conta</a>
            <a href="contato_andre.php" class="list-group-item list-group-item-action">Enviar Feedback</a>
            <a href="sair.php" class="list-group-item list-group-item-action ">Sair</a>
        </div>
    </div>

    <footer class="text-center mt-4">
        <div class="social-icons">
            <a href="Sobre Nós">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>


</body>

</html>