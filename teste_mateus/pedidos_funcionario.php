<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id_funcionario"])) {
    // Consulta para obter todos os pedidos
    $stmt = $mysqli->prepare("SELECT id_pedido, data_pedido, status, id_clientes, nome_funcionario FROM pedidos");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $mensagem = "Nenhum pedido encontrado.";
    }

    // Concluir pedido
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['concluir_pedido'])) {
        $id_pedido = $_POST['id_pedido'];
        $stmt_concluir = $mysqli->prepare("UPDATE pedidos SET status = 'Pedido Concluído' WHERE id_pedido = ?");
        $stmt_concluir->bind_param("i", $id_pedido);
        $stmt_concluir->execute();
        $stmt_concluir->close();
        // Recarregar a lista de pedidos
        $stmt->execute();
        $result = $stmt->get_result();
    }

    // Remover pedido
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remover_pedido'])) {
        $id_pedido = $_POST['id_pedido'];
        $stmt_remover = $mysqli->prepare("DELETE FROM pedidos WHERE id_pedido = ?");
        $stmt_remover->bind_param("i", $id_pedido);
        $stmt_remover->execute();
        $stmt_remover->close();
        // Recarregar a lista de pedidos
        $stmt->execute();
        $result = $stmt->get_result();
    }

    // Esvaziar tabelas
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['esvaziar_tabela'])) {
        $stmt_truncate_items = $mysqli->prepare("TRUNCATE TABLE itens_pedido");
        $stmt_truncate_items->execute();
        $stmt_truncate_items->close();
        
        $stmt_truncate_pedidos = $mysqli->prepare("TRUNCATE TABLE pedidos");
        $stmt_truncate_pedidos->execute();
        $stmt_truncate_pedidos->close();
        
        // Recarregar a lista de pedidos
        $stmt->execute();
        $result = $stmt->get_result();
    }
} else {
    die("Acesso negado. Você precisa estar logado para visualizar os pedidos.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>
<body>
    <?php include("menu.php") ?>
    <div class="container mt-4">
        <h1 class="text-center">Todos os Pedidos</h1>
        <div class="table-responsive">
            <table class="table table-striped mt-4 text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID do Pedido</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Funcionário</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($mensagem)): ?>
                        <tr>
                            <td colspan="9" class="text-center"><?php echo $mensagem; ?></td>
                        </tr>
                    <?php else: ?>
                        <?php while ($pedido = $result->fetch_assoc()): ?>
                            <?php
                            // Buscar itens do pedido
                            $stmt_itens = $mysqli->prepare("SELECT id_item_pedido, id_lanches, quantidade FROM itens_pedido WHERE id_pedido = ?");
                            $stmt_itens->bind_param("i", $pedido['id_pedido']);
                            $stmt_itens->execute();
                            $result_itens = $stmt_itens->get_result();

                            // Obter nome do cliente
                            $stmt_cliente = $mysqli->prepare("SELECT nome FROM clientes WHERE id_clientes = ?");
                            $stmt_cliente->bind_param("i", $pedido['id_clientes']);
                            $stmt_cliente->execute();
                            $resultado_cliente = $stmt_cliente->get_result();
                            $cliente = $resultado_cliente->fetch_assoc();
                            $nome_cliente = $cliente ? htmlspecialchars($cliente['nome']) : '';

                            // Verifica se o pedido é de cliente e se o nome do funcionário deve ser preenchido
                            $nome_funcionario = ($pedido['id_clientes'] ? '' : htmlspecialchars($pedido['nome_funcionario']));

                            while ($item = $result_itens->fetch_assoc()) {
                                // Obter o nome e o preço do lanche
                                $stmt_produto = $mysqli->prepare("SELECT nome, preco FROM lanches WHERE id_lanches = ?");
                                $stmt_produto->bind_param("i", $item['id_lanches']);
                                $stmt_produto->execute();
                                $resultado_produto = $stmt_produto->get_result();
                                $produto = $resultado_produto->fetch_assoc();

                                $nome_produto = $produto ? htmlspecialchars($produto['nome']) : 'Desconhecido';
                                $preco = $produto ? $produto['preco'] : 0;
                                $totalItem = $preco * $item['quantidade'];
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($pedido['data_pedido'])); ?></td>
                                    <td><?php echo $nome_cliente ? $nome_cliente : ''; ?></td>
                                    <td><?php echo $nome_funcionario; ?></td>
                                    <td><?php echo htmlspecialchars($nome_produto); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                                    <td>R$ <?php echo number_format($totalItem, 2, ',', '.'); ?></td>
                                    <td><?php echo htmlspecialchars($pedido['status']); ?></td>
                                    <td>
                                        <?php if ($pedido['status'] == 'Aguardando Pagamento'): ?>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                                <button type="submit" name="concluir_pedido" class="btn btn-success btn-sm">Concluir Pedido</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted">Ação indisponível</span>
                                        <?php endif; ?>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                            <button type="submit" name="remover_pedido" class="btn btn-danger btn-sm">Remover</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center">
            <form method="post">
                <button type="submit" name="esvaziar_tabela" class="btn btn-warning">Esvaziar Tabela</button>
            </form>
        </div>
        <div class="mt-4 text-center">
            <a href="area_funcionarios.php" class="btn btn-warning">Voltar para Área do Funcionário</a>
        </div>
    </div>
    <?php include("rodape.php") ?>
</body>
</html>
