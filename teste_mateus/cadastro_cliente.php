<?php
include("conexao.php");

if (isset($_POST["bt_nome"])) {
    $mysqlierrno = "Seu código está com erro";
    $nome = $_POST["bt_nome"];
    $curso = $_POST["bt_curso"];
    $periodo = $_POST["bt_periodo"];
    $telefone = $_POST["bt_telefone"];
    $email = $_POST["bt_email"];
    $senha = $_POST["bt_senha"];



    $senha = password_hash($_POST['bt_senha'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM clientes WHERE email =  '$email'";
    $sql_exec = $mysqli->query($sql) or die($mysqli->error);

    if ($sql_exec->num_rows > 0) {


    } else {

        $mysqlierrno = "falha";

        $stmt = $mysqli->prepare("INSERT INTO clientes (nome, curso, periodo, telefone, email, senha) values(?, ?, ?, ?, ? ,? )");
        $stmt->bind_param("ssssss", $nome, $curso, $periodo, $telefone, $email, $senha);
        $stmt->execute();
        $stmt->close();

        header("Location:login.php");

        exit();
    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="test.css">
</head>

<body>
    <div class="container text-center">
        <h1>Cadastro de Cliente</h1>
    </div>
    <div class="container">
        <form action="" method="post">

            <label for="">Nome:</label>
            <input class="form-control" type="text" name="bt_nome">

            <label for="">Curso:</label>
            <input class="form-control" type="text" name="bt_curso">

            <label for="">Período:</label>
            <input class="form-control" type="text" name="bt_periodo">

            <label for="">Telefone:</label>
            <input class="form-control" type="text" name="bt_telefone">

            <label for="">Email:</label>
            <input class="form-control" type="text" name="bt_email">

            <?php
            if (isset($_POST["bt_email"])) {
                if ($sql_exec->num_rows > 0)
                    echo "<div class='alert alert-danger mt-4' role='alert'>
                        Você já tem uma conta!
                    </div>";
            }
            ?>

            <label for="">Senha:</label>
            <input class="form-control" type="text" name="bt_senha">

            <input class="btn btn-success " type="submit" value="Cadastrar">
            <input class="btn btn-danger " type="reset" value="Redefinir">


            <a href="login.php">Já tem um Conta ?</a>


        </form>
    </div>

</body>