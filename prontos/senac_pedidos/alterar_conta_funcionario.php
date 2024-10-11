<?php
include("conexao.php");
require("protecao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id_funcionario"])) {
    $stmt = $mysqli->prepare("SELECT * FROM pi_2024_pedidos_funcionarios WHERE id_funcionario = ?");
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

        $email_check = $mysqli->prepare("SELECT id_funcionario FROM pi_2024_pedidos_funcionarios WHERE email = ? AND id_funcionario != ?");
        $email_check->bind_param("si", $email, $id_funcionario);
        $email_check->execute();
        $email_result = $email_check->get_result();

        if ($email_result->num_rows > 0) {
        } else {
            if (!empty($senha)) {
                $senha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $mysqli->prepare("UPDATE pi_2024_pedidos_funcionarios SET nome = ?, email = ?, senha = ? WHERE id_funcionario = ?");
                $stmt->bind_param("sssi", $nome, $email, $senha, $id_funcionario);
            } else {
                $stmt = $mysqli->prepare("UPDATE pi_2024_pedidos_funcionarios SET nome = ?, email = ? WHERE id_funcionario = ?");
                $stmt->bind_param("ssi", $nome, $email, $id_funcionario);
            }

            if ($stmt->execute()) {
                session_destroy();
                header("Location: login.php");
                exit();
            } else {
                echo "<script>alert('Erro ao atualizar. Tente novamente.');</script>";
                header("Location: login.php");
            }
        }
    }
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
            <a href="/principal/">
                <img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Logo">
            </a>
        </div>
    </div>
    <h1 class="text-center" style="background-color: orange; color: white;">Alterar Conta</h1>
    <div class="container">

        <form action="" method="post">
            <input type="hidden" name="id_funcionario" value="<?php echo htmlspecialchars($consultar['id_funcionario']); ?>">
            
            <div class="mb-3">
                <label class="form-label" for="nome">Nome:</label>
                <input class="form-control" type="text" name="nome" id="nome" 
                    value="<?php echo htmlspecialchars($consultar['nome']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email:</label>
                <input class="form-control" type="email" name="email" id="email" 
                    value="<?php echo htmlspecialchars($consultar['email']); ?>">
            </div>

            <?php
            if (isset($_POST["email"]) && $email_result->num_rows > 0) {
                echo "<div class='alert alert-danger mt-4' role='alert'>Email já está em uso por outro funcionário.</div>";
            }
            ?>

            <div class="mb-3">
                <label class="form-label" for="senha">Senha:</label>
                <input placeholder="Deixe vazio se não quiser alterar" class="form-control" type="password" name="senha" id="senha">
            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-warning" type="button" onclick="window.location.href='area_funcionarios.php'">Voltar</button>
                <input class="btn btn-success" type="submit" value="Alterar">
            </div>
        </form>
    </div>

    <footer class="text-center mt-4">
        <div class="footer-links">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>

</html>

