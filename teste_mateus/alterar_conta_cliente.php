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

        $email_check = $mysqli->prepare("SELECT id_clientes FROM clientes WHERE email = ? AND id_clientes != ?");
        $email_check->bind_param("si", $email, $id_clientes);
        $email_check->execute();
        $email_result = $email_check->get_result();

        if ($email_result->num_rows > 0) {
        } else {
            if (!empty($senha)) {
                $senha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $mysqli->prepare("UPDATE clientes SET nome = ?, telefone = ?, curso = ?, periodo = ?, email = ?, senha = ? WHERE id_clientes = ?");
                $stmt->bind_param("ssssssi", $nome, $telefone, $curso, $periodo, $email, $senha, $id_clientes);
            } else {
                $stmt = $mysqli->prepare("UPDATE clientes SET nome = ?, telefone = ?, curso = ?, periodo = ?, email = ? WHERE id_clientes = ?");
                $stmt->bind_param("sssssi", $nome, $telefone, $curso, $periodo, $email, $id_clientes);
            }

            if ($stmt->execute()) {
                session_destroy();
                header("Location:login.php");
                exit();
            } else {
                echo "<script>alert('Erro ao atualizar. Tente novamente.');</script>";
            }
        }
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
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <div class="row" style="background-color:#3a6da1;">
        <div class="col-12">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Topo do Site"></a>
        </div>
    </div>
    <h1 class="text-center" style="background-color: orange; color: white;">Alterar Conta</h1>
    <div class="container">

        <form action="" method="post">
            <input type="hidden" name="id_clientes" value="<?php echo htmlspecialchars($consultar['id_clientes']); ?>">
            <div class="mb-3">
                <label class="form-label" for="nome">Nome:</label>
                <input class="form-control" type="text" name="nome" id="nome"
                    value="<?php echo htmlspecialchars($consultar['nome']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="curso">Curso:</label>
                <input class="form-control" type="text" name="curso" id="curso"
                    value="<?php echo htmlspecialchars($consultar['curso']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="periodo">Período:</label>
                <input class="form-control" type="text" name="periodo" id="periodo"
                    value="<?php echo htmlspecialchars($consultar['periodo']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="telefone">Telefone:</label>
                <input class="form-control" type="text" name="telefone" id="telefone"
                    value="<?php echo htmlspecialchars($consultar['telefone']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email:</label>
                <input class="form-control" type="email" name="email" id="email"
                    value="<?php echo htmlspecialchars($consultar['email']); ?>">
                <?php
                if (isset($_POST['id_clientes'])) {
                    if ($email_result->num_rows > 0) {
                        echo "<div class='alert alert-danger mt-2' role='alert'>Email já está em uso por outro Usuário.</div>";
                    }
                }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="senha">Senha:</label>
                <input placeholder="Deixe vazio se não quiser alterar" class="form-control" type="password" name="senha"
                    id="senha" value="">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="area_cliente.php" class="btn btn-warning">Voltar</a>
                <input class="btn btn-success" type="submit" value="Alterar">
            </div>
        </form>
    </div>

    <footer class="text-center mt-4 d-none d-md-block">
        <div class="footer-links">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
