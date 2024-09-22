<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id_cliente"]) && isset($_GET['id_pedido'])) {
    $id_pedido = $_GET['id_pedido'];

    $stmt = $mysqli->prepare("SELECT * FROM pedidos WHERE id_pedido = ? AND id_cliente = ?");
    $stmt->bind_param("ii", $id_pedido, $_SESSION['id_cliente']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Pedido não encontrado.");
    }

    $pedido = $result->fetch_assoc();

    if (isset($_POST['atualizar_pedido'])) {
        $quantidade = (int) $_POST['quantidade'];
        $valor_unitario = (float) str_replace(',', '.', $_POST['valor_unitario']);

        $total = $valor_unitario * $quantidade;

        $stmt = $mysqli->prepare("UPDATE pedidos SET quantidade = ?, total = ? WHERE id_pedido = ? AND id_cliente = ?");
        $stmt->bind_param("idii", $quantidade, $total, $id_pedido, $_SESSION['id_cliente']);

        if ($stmt->execute()) {
            echo "<script>alert('Pedido atualizado com sucesso.');</script>";
            header("Location: pedidos_cliente.php");
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar o pedido. Tente novamente.');</script>";
        }
    }
} else {
    die("Acesso negado. Você precisa estar logado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <div class="row" style="background-color:#3a6da1;">
        <div class="col-md-12">
            <a href="">
                <img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Logo">
            </a>
        </div>
    </div>
    <div class="container mt-4">
        <h1 class="text-center" style="background-color: orange; color: white;">Alterar Pedido</h1>
        <form method="post">
            <div class="mb-3">
                <label class="form-label" for="produto">Produto</label>
                <input type="text" class="form-control" id="produto" name="produto"
                    value="<?php echo htmlspecialchars($pedido['produto']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label" for="valor_unitario">Valor Unitário</label>
                <input type="text" class="form-control" id="valor_unitario" name="valor_unitario"
                    value="<?php echo number_format($pedido['total'] / $pedido['quantidade'], 2, ',', '.'); ?>"
                    readonly>
            </div>
            <div class="mb-3">
                <label class="form-label" for="quantidade">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade"
                    value="<?php echo htmlspecialchars($pedido['quantidade']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="total">Valor Total</label>
                <input type="text" class="form-control" id="total" name="total"
                    value="<?php echo number_format($pedido['total'], 2, ',', '.'); ?>" readonly>
            </div>
            <button type="submit" name="atualizar_pedido" class="btn btn-primary">Atualizar Pedido</button>
            <a href="pedidos_cliente.php" class="btn btn-warning">Voltar</a>
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