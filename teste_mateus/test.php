<?php
include("conexao.php");

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION["nome"])){
    header("Location:login.php");
}else{

}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teste</title>
</head>

<body>
    <h1>certo</h1>
    <?php 
    var_dump($_SESSION);
    
    
    
    ?>
    <a href="sair.php">voltar</a>

</body>

</html>