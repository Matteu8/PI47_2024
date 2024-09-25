<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id_cliente"])) {
    $stmt = $mysqli->prepare("SELECT id_pedido, data_pedido, produto, quantidade, status, total, id_cliente FROM pedidos WHERE id_cliente = ?");
    $stmt->bind_param("i", $_SESSION['id_cliente']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $mensagem = "Nenhum pedido encontrado para este cliente.";
    }
} else {
    die("Acesso negado. Você precisa estar logado para visualizar seus pedidos.");
}

if (isset($_POST['cancelar_pedido'])) {
    $id_pedido = $_POST['id_pedido'];

    $stmt = $mysqli->prepare("UPDATE pedidos SET status = 'Cancelado' WHERE id_pedido = ? AND id_cliente = ?");
    $stmt->bind_param("ii", $id_pedido, $_SESSION['id_cliente']);

    if ($stmt->execute()) {
        echo "<script>alert('Pedido cancelado com sucesso.');</script>";
        header("Location: pedidos_cliente.php");
        exit();
    } else {
        echo "<script>alert('Erro ao cancelar o pedido. Tente novamente.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos</title>
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
        <h1 class="text-center" style="background-color: orange; color: white;">Meus Pedidos</h1>
        <div class="row">
            <div class="col-12">
                <?php if (isset($mensagem)): ?>
                    <p class="alert alert-info text-center"><?php echo $mensagem; ?></p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped mt-4 table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID do Pedido</th>
                                    <th>Nome do Cliente</th>
                                    <th>Data</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Valor Individual</th>
                                    <th>Valor Total</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($pedido = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
                                        <td><?php echo htmlspecialchars($_SESSION['nome']); ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($pedido['data_pedido'])); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['produto']); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['quantidade']); ?></td>
                                        <td>R$ <?php echo number_format($pedido['total'] / $pedido['quantidade'], 2, ',', '.'); ?></td>
                                        <td>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['status']); ?></td>
                                        <td>
                                            <?php if ($pedido['status'] == 'Aguardando Pagamento'): ?>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                                    <button type="submit" name="cancelar_pedido" class="btn btn-danger btn-sm">Cancelar</button>
                                                </form>
                                            <?php else: ?>
                                                <button class="btn btn-danger btn-sm" disabled>Cancelar (indisponível)</button>
                                            <?php endif; ?>

                                            <?php if ($pedido['status'] !== 'Pedido Concluído' && $pedido['status'] !== 'Cancelado'): ?>
                                                <a href="alterar_pedido.php?id_pedido=<?php echo $pedido['id_pedido']; ?>" class="btn btn-info btn-sm">Alterar</a>
                                            <?php else: ?>
                                                <button class="btn btn-info btn-sm" disabled>Alterar (indisponível)</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-4">
            <a href="area_cliente.php" class="btn btn-warning">Voltar para Área do Cliente</a>
        </div>
    </div>

    <footer class="text-center mt-4 d-none d-md-block">
        <div class="footer-links">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
