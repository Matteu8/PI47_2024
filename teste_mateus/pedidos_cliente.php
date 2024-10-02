<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id_cliente"])) {
    $stmt = $mysqli->prepare("SELECT id_pedido, data_pedido, status FROM pedidos WHERE id_clientes = ?");
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

    $stmt = $mysqli->prepare("UPDATE pedidos SET status = 'Cancelado' WHERE id_pedido = ? AND id_clientes = ?");
    $stmt->bind_param("ii", $id_pedido, $_SESSION['id_cliente']);

    if ($stmt->execute()) {
        echo "<script>alert('Pedido cancelado com sucesso.');</script>";
        header("Location: pedidos_cliente.php");
        exit();
    } else {
        echo "<script>alert('Erro ao cancelar o pedido. Tente novamente.');</script>";
    }
}

if (isset($_POST['alterar_pedido'])) {
    $id_pedido = $_POST['id_pedido'];
    header("Location: alterar_pedido.php?id_pedido=" . $id_pedido);
    exit();
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
    <?php include("menu.php") ?>
    <div class="container mt-4">
        <h1 class="text-center">Meus Pedidos</h1>
        <div class="row">
            <div class="col-12">
                <?php if (isset($mensagem)): ?>
                    <p class="alert alert-info text-center"><?php echo $mensagem; ?></p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped mt-4">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID do Pedido</th>
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
                                    <?php
                                    // Obtenha itens do pedido
                                    $stmt_itens = $mysqli->prepare("SELECT id_lanches, quantidade FROM itens_pedido WHERE id_pedido = ?");
                                    $stmt_itens->bind_param("i", $pedido['id_pedido']);
                                    $stmt_itens->execute();
                                    $result_itens = $stmt_itens->get_result();

                                    while ($item = $result_itens->fetch_assoc()) {
                                        $stmt_produto = $mysqli->prepare("SELECT nome, preco FROM lanches WHERE id_lanches = ?");
                                        $stmt_produto->bind_param("i", $item['id_lanches']);
                                        $stmt_produto->execute();
                                        $resultado_produto = $stmt_produto->get_result();
                                        $produto = $resultado_produto->fetch_assoc();
                                        
                                        $nome_produto = $produto ? $produto['nome'] : 'Desconhecido';
                                        $preco_unitario = $produto ? $produto['preco'] : 0;
                                        $valor_total = $preco_unitario * $item['quantidade'];
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
                                            <td><?php echo date("d/m/Y", strtotime($pedido['data_pedido'])); ?></td>
                                            <td><?php echo htmlspecialchars($nome_produto); ?></td>
                                            <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                                            <td>R$ <?php echo number_format($preco_unitario, 2, ',', '.'); ?></td>
                                            <td>R$ <?php echo number_format($valor_total, 2, ',', '.'); ?></td>
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
                                                
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                                    <?php if ($pedido['status'] == 'Pedido Concluído' || $pedido['status'] == 'Cancelado'): ?>
                                                        <button type="submit" class="btn btn-primary btn-sm" disabled>Alterar (indisponível)</button>
                                                    <?php else: ?>
                                                        <button type="submit" name="alterar_pedido" class="btn btn-primary btn-sm">Alterar</button>
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
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
</body>
</html>
