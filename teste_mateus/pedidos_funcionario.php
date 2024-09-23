<?php
include("conexao.php");
require("protecao.php");

if (!isset($_SESSION)) {
    session_start();
}

$stmt = $mysqli->prepare("SELECT id_pedido, data_pedido, produto, quantidade, status, total FROM pedidos");
$stmt->execute();
$result = $stmt->get_result();

if (isset($_POST['atualizar_status'])) {
    $id_pedido = $_POST['id_pedido'];
    $novo_status = 'Pedido Concluído';

    $stmt = $mysqli->prepare("UPDATE pedidos SET status = ? WHERE id_pedido = ?");
    $stmt->bind_param("si", $novo_status, $id_pedido);

    if ($stmt->execute()) {
        echo "<script>alert('Status do pedido atualizado com sucesso.');</script>";
        header("Location: pedidos_funcionario.php");
        exit();
    } else {
        echo "<script>alert('Erro ao atualizar o status. Tente novamente.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Todos os Pedidos</title>
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
        <h1 class="text-center" style="background-color: orange; color: white;">Todos os Pedidos</h1>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped mt-4">
                        <thead class="table-dark">
                            <tr>
                                <th>ID do Pedido</th>
                                <th>Data</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows === 0): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Nenhum pedido encontrado.</td>
                                </tr>
                            <?php else: ?>
                                <?php while ($pedido = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($pedido['data_pedido'])); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['produto']); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['quantidade']); ?></td>
                                        <td>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['status']); ?></td>
                                        <td>
                                            <?php if ($pedido['status'] == 'Aguardando Pagamento'): ?>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="id_pedido"
                                                        value="<?php echo $pedido['id_pedido']; ?>">
                                                    <button type="submit" name="atualizar_status"
                                                        class="btn btn-success btn-sm">Concluir Pedido</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">Status já atualizado</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="area_funcionarios.php" class="btn btn-warning">Voltar para Área do Funcionário</a>
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