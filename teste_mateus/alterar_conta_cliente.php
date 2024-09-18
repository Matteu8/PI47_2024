<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION["id_cliente"])) {

    $stmt = $mysqli->prepare("SELECT * FROM clientes WHERE id_clientes = ?");

    $stmt->bind_param("i", $_SESSION['id_cliente']);
    $stmt->execute();
    $result = $stmt->get_result();
    $consultar = $result->fetch_assoc();


    if (isset($_POST['id_clientes'])) {
        $id_clientes = $_POST['id_clientes'];
        $nome = $_POST['nome'];
        $curso = $_POST['curso'];
        $periodo = $_POST['periodo'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];


        if (!empty($senha)) {
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("UPDATE clientes SET nome = ?, telefone = ?, curso = ?, periodo = ?, email = ?, senha = ? WHERE id_clientes = ?");
            $stmt->bind_param("ssssssi", $nome, $telefone, $curso, $periodo, $email, $senha, $id_clientes);
        } else {
            $stmt = $mysqli->prepare("UPDATE clientes SET nome = ?, telefone = ?, curso = ?, periodo = ?, email = ? WHERE id_clientes = ?");
            $stmt->bind_param("sssssi", $nome, $telefone, $curso, $periodo, $email, $id_clientes);
        }

        $stmt->execute();

        session_destroy();

        header("Location:login.php");
        exit();
    }
} else {
    die("Não tem um id selecionado. Página não permitida");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar - Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <div class="row visible-md visible-lg" style="background-color:#3a6da1;">
        <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
        </div>
    </div>

    <div class="container">
        <h1 class="text-center">Alterar Conta</h1>
        <form action="" method="post">
            <label class="form-label" for="">Nome: </label>
            <input type="hidden" name="id_clientes" value="<?php echo htmlspecialchars($consultar['id_clientes']); ?>">
            <input class="form-control" type="text" name="nome"
                value="<?php echo htmlspecialchars($consultar['nome']); ?>">
            <label class="form-label" for="">Curso: </label>
            <input class="form-control" type="text" name="curso"
                value="<?php echo htmlspecialchars($consultar['curso']); ?>">
            <label class="form-label" for="">Período: </label>
            <input class="form-control" type="text" name="periodo"
                value="<?php echo htmlspecialchars($consultar['periodo']); ?>">
            <label class="form-label" for="">Telefone: </label>
            <input class="form-control" type="text" name="telefone"
                value="<?php echo htmlspecialchars($consultar['telefone']); ?>">
            <label class="form-label" for="">Email: </label>
            <input class="form-control" type="text" name="email"
                value="<?php echo htmlspecialchars($consultar['email']); ?>">
            <label class="form-label" for="">Senha: </label>
            <input placeholder="É obrigatório preencher senha" class="form-control" type="password" name="senha"
                value="">

            <a href="area_cliente.php"><button class="btn btn-warning mt-4" type="button">Voltar</button></a>
            <input class="btn btn-success mt-4" type="submit" value="Alterar">
        </form>
    </div>

    <footer>
        <div class="footer-links">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Sua Empresa. Todos os direitos reservados.</p>
    </footer>
</body>

</html>