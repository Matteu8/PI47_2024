<?php
     require("conexao.php");

     if(isset($_POST["bt_login"])){
         $login = $_POST["bt_login"];
         $senha = $_POST["bt_senha"];
         //$rsenha = $_POST["bt_resenha"];
         
         $stmt = $mysqli->prepare("INSERT INTO tabela_adm (login, senha) VALUES (?,?)");
         $stmt->bind_param("ss", $login, $senha);
 
         
         $stmt->execute();
         $stmt->close();
     }
 
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Adm</title>
</head>
<body>
    <h1>Cadastrar Adm</h1>
    <form action="" method="post">
        <label for="">Escreva o login</label>
        <input type="text" name="bt_login">

        <label for="">Escreva a senha</label>
        <input type="text" name="bt_senha">

        <label for="">Repita a senha</label>
        <input type="text" name="bt_rsenha">

        <input type="submit">
        <a href="index.php">Voltar</a>
    </form>
</body>
</html>