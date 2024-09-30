<?php
include("conexao.php");
require("protecao.php");

if (!isset($_SESSION)) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Funcionario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php"); ?>
    
    <div class="container mt-4">
        <h1>Área do Funcionário</h1>
        <p>Nome: <?php echo $_SESSION["nome"]; ?></p>

        <div class="list-group mt-3">
            <a href="pedido.php" class="list-group-item list-group-item-action">Fazer Pedido</a>
            <a href="pedidos_funcionario.php" class="list-group-item list-group-item-action">Lista de Pedidos</a>
            <a href="alterar_conta_funcionario.php" class="list-group-item list-group-item-action">Alterar Conta</a>
            <a href="deletar_conta_funcionario.php" class="list-group-item list-group-item-action">Deletar Conta</a>
            <a href="cadastro_do_funcionario.php" class="list-group-item list-group-item-action ">Cadastrar
                Funcionário</a>
            <a href="cadastro_lanche.php" class="list-group-item list-group-item-action">Cadastrar Lanches</a>
            <a href="lista_lanches.php" class="list-group-item list-group-item-action">Lista Lanches</a>
            <a href="feedback_funcionario.php" class="list-group-item list-group-item-action">Visualizar Feedback</a>
            <a href="sair.php" class="list-group-item list-group-item-action ">Sair</a>
        </div>
    </div>
    <br><br><br><br>
    <footer class="text-center mt-4">
        <div class="social-icons">
            <a href="Sobre Nós">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>

</html>