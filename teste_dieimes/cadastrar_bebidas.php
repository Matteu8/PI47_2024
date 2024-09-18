<?php
    require("conexao.php");
    //require("protecao");

    if (isset($_POST['nome'])) {
        // Coletando os dados do formulário
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
    
        // Preparando a consulta SQL para inserir os dados
        $sql = "INSERT INTO bebidas (nome, tipo, preco, quantidade) VALUES ('$nome', '$tipo', '$preco', '$quantidade')";
    
        // Executando a consulta
        if ($mysqli->query($sql) === TRUE) {
            echo "Bebida cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar bebida: " . $mysqli->error;
        }
    
        // Fechando a conexão
        $mysqli->close();
    }
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Bebidas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="dieimes.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
</head>
<body>
    <?php include("menu.php");?>

    <div class="container text-center">
        <h1 class="mt-3">Cadastrar Bebidas</h1>
        <form action="cadastrar_bebidas.php" method="POST">

            <div class="mb-3">
                <label class="form-label" for="nome">Nome da Bebida:</label>
                <input class="form-control" type="text" id="nome" name="nome" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="tipo">Tipo de Bebida:</label>
                <input class="form-control" type="text" id="tipo" name="tipo" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="preco">Preço:</label>
                <input class="form-control" type="number" id="preco" name="preco" step="0.01" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="quantidade">Quantidade em Estoque:</label>
                <input class="form-control" type="number" id="quantidade" name="quantidade" required>
            </div>       

            

            <input class="btn btn-success" type="submit" value="Cadastrar Bebida">
            <a  class="btn btn-secondary" href="#">Cancelar</a>
        </form>
    </div>
   

    <?php include("rodape.php");?>
</body>
</html>
