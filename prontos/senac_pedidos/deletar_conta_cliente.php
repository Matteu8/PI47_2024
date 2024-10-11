<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id_cliente"])) {
    
    $stmt = $mysqli->prepare("SELECT * FROM pi_2024_pedidos_clientes WHERE id_clientes = ?");
    $stmt->bind_param("i", $_SESSION['id_cliente']);
    $stmt->execute();
    $result = $stmt->get_result();
    $consultar = $result->fetch_assoc();

    if (!$consultar) {
        die("Cliente não encontrado. Verifique o ID.");
    }

    if (isset($_POST['id_clientes'])) {
        $id_clientes = $_POST['id_clientes'];

        $stmt = $mysqli->prepare("DELETE FROM pi_2024_pedidos_clientes WHERE id_clientes = ?");
        $stmt->bind_param("i", $id_clientes);

        if ($stmt->execute()) {
            session_destroy(); 
            header("Location: login.php");
            exit();
        } else {
            echo "<script>alert('Erro ao remover a conta. Tente novamente.');</script>";
            header("Location:deletar_conta_cliente.php");
        }
    }
} else {
    echo "<script>alert('Nenhum cliente logado.');</script>";
    header("Location:login.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remover - Conta</title>
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
    <h1 class="text-center" style="background-color: orange; color: white;">Remover Conta</h1>
    <div class="container">

        <form action="" method="post">
            <input type="hidden" name="id_clientes" value="<?php echo htmlspecialchars($consultar['id_clientes']); ?>">
            <div class="alert alert-danger text-center" role="alert">
            Tem certeza de que deseja remover sua conta,
            <?php echo htmlspecialchars($consultar['nome']); ?>?
            </div>
            
            <div class="text-center">
                <button class="btn btn-warning mt-4 mx-1" type="button" onclick="window.location.href='area_cliente.php'">Voltar</button>
                <input class="btn btn-danger mt-4 mx-1" type="submit" value="Remover Conta">
            </div>
        </form>
    </div>
    <!--
    <footer>
        <div class="footer-links">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
-->
</body>

</html>