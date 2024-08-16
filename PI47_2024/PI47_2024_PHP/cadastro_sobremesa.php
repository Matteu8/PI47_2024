<?php 


    if(isset($_POST)["#"]){
        $nome = $_POST["#"];
        $ingredientes = $_POST["#"];
        $descricao = $_POST["#"];
        $imagem = $_POST["#"];
        $preco = $_POST["#"];

        $mysqli->query("INSERT INTO lanches (nome, ingredientes, preco, descricao) values('$nome', '$ingredientes', '$preco', '$descricao')") or
                    die($mysqlierrno);
    }

?>