<?php
    require("conexao.php");

    if(isset($_POST["bt_nome"])){
        $nome = $_POST["bt_nome"];
        
        $stmt = $mysqli->prepare("INSERT INTO tabela_nome (nome) VALUES (?)");
        $stmt->bind_param("s", $nome);

        
        $stmt->execute();
        $stmt->close();
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar nome</title>
</head>
<body>
    <h1>Cadastrar nome</h1>

    <form action="" method="post">
        <label for="">Escreva o nome:</label>
        <input type="text" name="bt_nome">

        <input type="submit" value="Cadastrar">
        <a href="editar_nome.php">Editar nome</a>
        <a href="deletar_nome.php">Deletar nome</a>
        <a href="index.php">Voltar</a>
    </form>
</body>
</html>