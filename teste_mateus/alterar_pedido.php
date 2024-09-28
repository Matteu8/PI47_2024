<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["id_cliente"])) {
    die("Acesso negado. Você precisa estar logado para visualizar seus pedidos.");
}

if (isset($_GET["id_pedido"])) {
    $id_pedido = $_GET["id_pedido"];
    
    $stmt = $mysqli->prepare("SELECT id_pedido, data_pedido, status FROM pedidos WHERE id_pedido = ? AND id_clientes = ?");
    $stmt->bind_param("ii", $id_pedido, $_SESSION["id_cliente"]);
    
    if (!$stmt->execute()) {
        die("Erro ao executar consulta: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $pedido = $result->fetch_assoc();

    if (!$pedido) {
        die("Nenhum pedido encontrado com o ID: " . $id_pedido);
    }

    // Obter itens do pedido
    $stmt_itens = $mysqli->prepare("SELECT id_item_pedido, id_lanches, quantidade FROM itens_pedido WHERE id_pedido = ?");
    $stmt_itens->bind_param("i", $id_pedido);
    $stmt_itens->execute();
    $result_itens = $stmt_itens->get_result();
    $itens = $result_itens->fetch_all(MYSQLI_ASSOC);
} else {
    die("ID do pedido não encontrado na URL.");
}

// Processar a atualização do pedido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantidades = $_POST['quantidade'];

    foreach ($itens as $index => $item) {
        $nova_quantidade = intval($quantidades[$index]);
        $quantidade_atual = intval($item['quantidade']);

        // Atualizar a quantidade no itens_pedido
        $stmt_update = $mysqli->prepare("UPDATE itens_pedido SET quantidade = ? WHERE id_item_pedido = ?");
        $stmt_update->bind_param("ii", $nova_quantidade, $item['id_item_pedido']);
        $stmt_update->execute();

        // Calcular a diferença e atualizar a tabela lanches
        $diferenca = $nova_quantidade - $quantidade_atual;
        $id_lanches = $item['id_lanches'];

        if ($diferenca > 0) {
            // Se a quantidade aumentou, subtrair da tabela lanches
            $stmt_lanches = $mysqli->prepare("UPDATE lanches SET quantidade = quantidade - ? WHERE id_lanches = ?");
            $stmt_lanches->bind_param("ii", $diferenca, $id_lanches);
            $stmt_lanches->execute();
        } elseif ($diferenca < 0) {
            // Se a quantidade diminuiu, somar na tabela lanches
            $diferenca_abs = abs($diferenca);
            $stmt_lanches = $mysqli->prepare("UPDATE lanches SET quantidade = quantidade + ? WHERE id_lanches = ?");
            $stmt_lanches->bind_param("ii", $diferenca_abs, $id_lanches);
            $stmt_lanches->execute();
        }
    }

    // Redirecionar ou exibir mensagem de sucesso
    echo "<script>alert('Pedido atualizado com sucesso.'); window.location.href='pedidos_cliente.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include("menu.php") ?>
    <div class="container mt-4">
        <h1 class="text-center">Alterar Pedido</h1>
        <form method="post">
            <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($pedido['id_pedido']); ?>">
            <div class="mb-3">
                <label for="data_pedido" class="form-label">Data do Pedido</label>
                <input type="text" class="form-control" id="data_pedido" value="<?php echo date("d/m/Y", strtotime($pedido['data_pedido'])); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" value="<?php echo htmlspecialchars($pedido['status']); ?>" readonly>
            </div>
            <?php foreach ($itens as $item): ?>
                <?php
                $stmt_produto = $mysqli->prepare("SELECT nome, preco FROM lanches WHERE id_lanches = ?");
                $stmt_produto->bind_param("i", $item['id_lanches']);
                $stmt_produto->execute();
                $resultado_produto = $stmt_produto->get_result();
                $produto = $resultado_produto->fetch_assoc();
                ?>
                <div class="mb-3">
                    <label class="form-label">Produto</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($produto['nome']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantidade</label>
                    <input type="number" class="form-control" name="quantidade[]" value="<?php echo htmlspecialchars($item['quantidade']); ?>" min="1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Preço</label>
                    <input type="text" class="form-control" value="R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Valor Total</label>
                    <input type="text" class="form-control" value="R$ <?php echo number_format($produto['preco'] * $item['quantidade'], 2, ',', '.'); ?>" readonly>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Alterar</button>
            <a href="pedidos_cliente.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</body>
</html>
