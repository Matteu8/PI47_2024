<?php
    $host = "localhost";
    $login = "root";
    $senha = "";
    $banco = "revisao47";

    $mysqli = new mysqli ($host, $login, $senha, $banco);

    if($mysqli->connect_errno){
        echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_errno;
    }
?>

