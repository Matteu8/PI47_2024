<?php
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION["id_adm"])){
    echo "Você não tem permissão para verificar essa página";
    echo "<a href='index.php'>Voltar</a>";
    exit;
}
