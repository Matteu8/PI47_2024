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
        if ($mysql->query($sql) === TRUE) {
            echo "Bebida cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar bebida: " . $mysql->error;
        }
    
        // Fechando a conexão
        $mysql->close();
    }
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Bebidas</title>
</head>
<body>
    <h1>Cadastrar Bebidas</h1>

    <form action="cadastrar_bebidas.php" method="POST">
        <label for="nome">Nome da Bebida:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="tipo">Tipo de Bebida:</label>
        <input type="text" id="tipo" name="tipo" required><br><br>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" required><br><br>

        <label for="quantidade">Quantidade em Estoque:</label>
        <input type="number" id="quantidade" name="quantidade" required><br><br>

        <input type="submit" value="Cadastrar Bebida">
    </form>
</body>
</html>
