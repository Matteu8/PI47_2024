<?php
    require("conexao.php");

    if(isset($_POST["bt_nome"])){

        $mysqlierrno= "Seu código está com erro";
        $nome = $_POST["bt_nome"];
        $curso = $_POST["bt_curso"];
        $periodo = $_POST["bt_periodo"];
        $telefone = $_POST["bt_telefone"];
        $email = $_POST["bt_email"];
         /*$imagem = $_POST["#"];  FALTA ENSINAR MANDAR IMAGENS E ARQUIVOS PARA O BANCO DE DADOS*/

        $mysqli->query("INSERT INTO clientes (nome, curso, periodo, telefone, email) values('$nome', '$curso', '$periodo', '$telefone', '$email')") or
                    die($mysqlierrno);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="test.css">
</head>
<body>
    <div class="container text-center">
        <h1>Cadastro de Cliente</h1>
    </div>
    <div class="container">
        <form action="" method="post">

            <label for="">Nome:</label>
            <input class="form-control"  type="text" name="bt_nome">
            
            <label for="">Curso:</label>
            <input class="form-control" type="text" name="bt_curso" >

            <label for="">Período</label>
            <input class="form-control" type="text" name="bt_periodo" >

            <label for="">Telefone</label>
            <input class="form-control" type="text" name="bt_telefone" >

            <label for="">Email</label>
            <input class="form-control" type="text" name="bt_email" >

            <input class="btn btn-success "  type="submit" value="Cadastrar">
            <input class="btn btn-danger " type="reset" value="Voltar">

            


        </form>
    </div>
    
</body>