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

    <style>
        body {
            background-color: #f8f9fa; /* Cor de fundo leve */
        }

        .container {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            border: none;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05); /* Efeito de zoom ao passar o mouse */
        }

        .card-img-top {
            border-radius: 8px 8px 0 0; /* Bordas arredondadas para a imagem */
            height: 200px; /* Altura fixa para as imagens */
            object-fit: cover; /* Cobre o espaço da imagem */
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
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
    
</head>

<body>
    
    
    <h1>Menu de Bebidas</h1>

    <div class="container">
        <div class="row">
            <?php while ($bebida = $sql_exec->fetch_assoc()) { ?>
                <div class="col-md-3 mb-4"> 
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($bebida['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($bebida['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($bebida['nome']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($bebida['tipo']); ?></p>
                            <p class="card-text">R$ <?php echo number_format($bebida['preco'], 2, ',', '.'); ?></p>
                            <a href="#" class="btn btn-primary">Ver mais</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</body>

</html>
