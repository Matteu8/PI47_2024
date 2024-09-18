<?php
    require("protecao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar nome</title>
</head>
<body>
    <h1>Deletar nome</h1>
    <p>Tem certeza que deseja deletar o nome: </p>

    <form action="" method="post">
        <input type="submit" value="Apagar definitivo">
    </form>

    <a href="index.php">Voltar</a>
    <a href="consultar_nome.php">Consultar nome</a>
    <a href="editar_nome.php">Editar nome</a>
    <a href="cadastrar_nome.php">Cadastrar nome</a>
</body>
</html>