<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_cliente'])) {
    die("Você precisa estar logado para fazer pedidos.");
}

if (isset($_POST['fazer_pedido'])) {
    $id_cliente = $_SESSION['id_cliente'];
    $produto = $_POST['produto'];
    $quantidade = 1; // Quantidade fixa

    // Verificar o preço do produto (definindo valores estáticos para simplificar)
    switch ($produto) {
        case 'lanche':
            $preco = 10.00;
            break;
        case 'bebida':
            $preco = 5.00;
            break;
        case 'sobremesa':
            $preco = 7.00;
            break;
        default:
            die("Produto inválido.");
    }
    $total = $preco * $quantidade;

    $stmt = $mysqli->prepare("INSERT INTO pedidos (id_cliente, produto, quantidade, total, data_pedido, status) VALUES (?, ?, ?, ?, NOW(), 'Aguardando Pagamento')");
    $stmt->bind_param("isid", $id_cliente, $produto, $quantidade, $total);

    if ($stmt->execute()) {
        echo "<script>alert('Pedido realizado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao realizar o pedido. Tente novamente.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>

    <div class="row" style="background-color:#3a6da1;">
        <div class="col-12">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Topo do Site"></a>
        </div>
    </div>

    <h1 class="text-center" style="background-color: orange; color: white;">Pedidos</h1>

    <div class="container d-flex justify-content-center">
        <div class="row justify-content-center">
            <!-- Card 1 -->
            <div class="col-10 col-sm-6 col-md-4 mb-3 mt-5 d-flex justify-content-center">
                <div class="card" style="width: 100%;">
                    <img src="img/lanche.jfif" class="card-img-top" alt="Lanches" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Lanches</h5>
                        <form method="post" action="">
                            <input type="hidden" name="produto" value="lanche">
                            <button type="submit" name="fazer_pedido" class="btn btn-primary">Pedir</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-10 col-sm-6 col-md-4 mb-3 mt-5 d-flex justify-content-center">
                <div class="card" style="width: 100%;">
                    <img src="img/bebida.jfif" class="card-img-top" alt="Bebidas" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Bebidas</h5>
                        <form method="post" action="">
                            <input type="hidden" name="produto" value="bebida">
                            <button type="submit" name="fazer_pedido" class="btn btn-primary">Pedir</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-10 col-sm-6 col-md-4 mb-3 mt-5 d-flex justify-content-center">
                <div class="card" style="width: 100%;">
                    <img src="img/sobremesa.jfif" class="card-img-top" alt="Sobremesas" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Sobremesas</h5>
                        <form method="post" action="">
                            <input type="hidden" name="produto" value="sobremesa">
                            <button type="submit" name="fazer_pedido" class="btn btn-primary">Pedir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center mt-3">
        <button class="btn btn-warning">
            <a href="login.php" style="text-decoration: none; color: black;">Voltar</a>
        </button>
    </div>

    <!-- Rodapé oculto em dispositivos móveis -->
    <footer class="d-none d-md-block">
        <div class="footer-links text-center">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p class="text-center">&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
