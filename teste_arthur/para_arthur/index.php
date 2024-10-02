<?php
include("conexao.php");

if ((!isset($_SESSION))) {
    session_start();
}

$bebidas = "SELECT * FROM bebidas";
$lanches = "SELECT * FROM lanches";
$sobremesa = "SELECT * FROM sobremesa";

$bebidas_result = $mysqli->query($bebidas) or die($mysqli->error);
$lanches_result = $mysqli->query($lanches) or die($mysqli->error);
$sobremesa_result = $mysqli->query($sobremesa) or die($mysqli->error);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bebidas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dieimes.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .row {
            margin-bottom: 20px;
        }

        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-img-top {
            border-radius: 8px;
            height: 300px;
            object-fit: cover;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 14px;
        }

        .img-thumbnail {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <?php include "menu.php"; ?>

    <h1 class="mt-5">Cardapio</h1>

    <h1 class="mt-5">Lanches</h1>
    <!-- Lanches -->
    <div class="container">
        <div class="row">
            <?php while ($lanche = $lanches_result->fetch_assoc()) { ?>
                <div class=" d-flex col-md-3 mb-4">
                    <div class="card d-flex">
                        <img src="<?php echo htmlspecialchars($lanche['foto']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($lanche['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($lanche['nome']); ?></h5>
                            <p class="card-text">Tipo: <?php echo htmlspecialchars($lanche['ingredientes']); ?></p>
                            <p class="card-text">R$ <?php echo number_format($lanche['preco'], 2, ',', '.'); ?></p>

                            <?php if (isset($_SESSION['tipo_usuario'])): ?>
                                <a href="lanches.php" class="btn btn-primary">sim</a>
                            <?php else: ?>
                                <p class="text-danger">Necessário fazer <a href="login.php">login</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <h1 class="mt-5">Bebidas</h1>
    <!-- Bebidas -->
    <div class="container">
        <div class="row">
            <?php while ($bebida = $bebidas_result->fetch_assoc()) { ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($bebida['foto']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($bebida['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($bebida['nome']); ?></h5>
                            <p class="card-text">Tipo: <?php echo htmlspecialchars($bebida['tipo']); ?></p>
                            <p class="card-text">R$ <?php echo number_format($bebida['preco'], 2, ',', '.'); ?></p>

                            <?php if (isset($_SESSION['tipo_usuario'])): ?>
                                <a href="lanches.php" class="btn btn-primary">sim</a>
                            <?php else: ?>
                                <p class="text-danger">Necessário fazer <a href="login.php">login</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>



    <h1 class="mt-5">Sobremesas</h1>

    <!-- Sobremesas -->
    <div class="container">
        <div class="row">
            <?php while ($sobremesa = $sobremesa_result->fetch_assoc()) { ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($sobremesa['imagem']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($sobremesa['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($sobremesa['nome']); ?></h5>
                            <p class="card-text">R$ <?php echo number_format($sobremesa['preco'], 2, ',', '.'); ?></p>
                            <p class="card-text">Tipo: <?php echo htmlspecialchars($sobremesa['quantidade']); ?></p>

                            <?php if (isset($_SESSION['tipo_usuario'])): ?>
                                <a href="lanches.php" class="btn btn-primary">sim</a>
                            <?php else: ?>
                                <p class="text-danger">Necessário fazer <a href="login.php">login</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <br><br><br><br><br><br>
    <?php include "rodape.php"; ?>
</body>

</html>