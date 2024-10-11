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

    $sql = "SELECT * FROM pi_2024_pedidos_clientes WHERE email =  '$email'";
    $sql_exec = $mysqli->query($sql) or die($mysqli->error);

    if ($sql_exec->num_rows > 0) {

    } else {
        $mysqlierrno = "falha";

        $stmt = $mysqli->prepare("INSERT INTO pi_2024_pedidos_clientes (nome, curso, periodo, telefone, email, senha) values(?, ?, ?, ?, ? ,? )");
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
    <title>Cadastro de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">

</head>

<body>
    <?php include("menu.php");?>
    <div class="text-center">
        <h1 style="background-color: orange; color: white;">Cadastro de Cliente</h1>
    </div> 
    <div class="container mb-5 d-flex justify-content-center">
        <form method="POST" class="form">        
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input required type="text" pattern="[A-Za-zÀ-ÿ\s]+" class="form-control" name="bt_nome" id="nome">
            </div>
            <div class="mb-3">
                <label for="curso" class="form-label">Curso</label>
                <input required type="text" class="form-control" name="bt_curso" id="curso">
            </div>
            <div class="mb-3">
                <label for="periodo" class="form-label">Período</label>
                <input required type="text" class="form-control" name="bt_periodo" id="periodo">
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input required type="number" min="1" class="form-control" name="bt_telefone" id="telefone">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input required type="email" class="form-control" name="bt_email" id="email">
            </div>
            <?php
            if (isset($_POST["bt_email"])) {
                if ($sql_exec->num_rows > 0) {
                    echo "<div class='alert alert-danger mt-4' role='alert'>
                                Você já tem uma conta!
                            </div>";
                }
            }
            ?>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input required type="password" class="form-control" name="bt_senha" id="senha">
            </div>
            
            <div class="container text-center">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary">Cadastrar</button>
                    <input class="btn btn-danger" type="reset" value="Redefinir">
                </div>
                <p class="signin mt-3">Já tem uma Conta? <a href="login.php">Entrar</a></p>
            </div>
            
        </form>
        
    </div>   
   

    <?php include("rodape.php");?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>