<?php
include("conexao.php");

session_start();

if (isset($_SESSION["id_funcionario"])) {
    $stmt = $mysqli->prepare("SELECT * FROM funcionarios WHERE id_funcionario = ?");
    $stmt->bind_param("i", $_SESSION['id_funcionario']);
    $stmt->execute();
    $result = $stmt->get_result();
    $consultar = $result->fetch_assoc();

    if (!$consultar) {
        die("Funcionário não encontrado. Verifique o ID.");
    }

    if (isset($_POST['id_funcionario'])) {
        $id_funcionario = $_POST['id_funcionario'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if (!empty($senha)) {
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("UPDATE funcionarios SET nome = ?, email = ?, senha = ? WHERE id_funcionario = ?");
            $stmt->bind_param("sssi", $nome, $email, $senha, $id_funcionario);
        } else {
            $stmt = $mysqli->prepare("UPDATE funcionarios SET nome = ?, email = ? WHERE id_funcionario = ?");
            $stmt->bind_param("ssi", $nome, $email, $id_funcionario);
        }

        if ($stmt->execute()) {
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar. Tente novamente.');</script>";
        }
    }
} else {
    
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
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <div class="row visible-md visible-lg" style="background-color:#3a6da1;">
        <div class="col-md-5" style="background-color:#3a6da1;">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive" alt="Logo"></a>
        </div>
    </div>

    <div class="container">
        <h1 class="text-center">Alterar Conta</h1>
        <form action="" method="post">
            <label class="form-label" for="">Nome: </label>
            <input type="hidden" name="id_funcionario"
                value="<?php echo htmlspecialchars($consultar['id_funcionario']); ?>">
            <input class="form-control" type="text" name="nome"
                value="<?php echo htmlspecialchars($consultar['nome']); ?>">
            <label class="form-label" for="">Email: </label>
            <input class="form-control" type="text" name="email"
                value="<?php echo htmlspecialchars($consultar['email']); ?>">
            <label class="form-label" for="">Senha: </label>
            <input placeholder="Deixe vazio se não quiser alterar" class="form-control" type="password" name="senha">

            <button class="btn btn-warning mt-4" type="button" onclick="window.location.href='area_funcionarios.php'">Voltar</button>
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
