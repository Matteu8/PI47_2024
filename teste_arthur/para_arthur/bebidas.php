<?php
include("conexao.php");
$funcionou = "SELECT * FROM bebidas";
$sql_exec = $mysqli->query($funcionou) or die($mysqli->error);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bebidas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dieimes.css">
</head>

<body>
    <?php include("menu.php") ?>
    <br>
    <h1 class="text-center">Menu de Bebidas</h1>
    <br>

    <div class="container">
        <div class="row">

            <?php while ($bebida = $sql_exec->fetch_assoc()) { ?>
                <div class="col-md-3 mb-4"> 
                    <div class="card">
                        <img src="<?php echo $bebida['foto'] ?>" class="card-img-top" alt="<?php echo $bebida['nome']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $bebida['nome'] ?></h5>
                            <p class="card-text"><?php echo $bebida['tipo'] ?></p>
                            <p class="card-text">R$ <?php echo number_format($bebida['preco'], 2, ',', '.'); ?></p>
                            <a href="#" class="btn btn-primary">Ver mais</a>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
<br>
<br>
<br>
<br>
<br>
    <?php include("rodape.php") ?>
</body>

</html>
