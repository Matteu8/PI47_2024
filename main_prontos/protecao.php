<?php
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION["id_funcionario"])){
    echo "Você não tem permissão para verificar essa página";
    echo "<a href='login.php'>Voltar</a>";
    exit;
}
