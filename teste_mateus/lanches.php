<?php
include("conexao.php");
if(!isset($_SESSION)){}
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: login.php");
    exit();
}

// Redireciona para login se o id do cliente ou funcionário não estiver na sessão
if ($_SESSION['tipo_usuario'] == 'cliente' && !isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['tipo_usuario'] == 'funcionario' && !isset($_SESSION['id_funcionario'])) {
    header("Location: login.php");
    exit();
}

// Define a URL de redirecionamento para o botão "Voltar"
$voltar_url = $_SESSION['tipo_usuario'] == 'cliente' ? "area_cliente.php" : "area_funcionarios.php";

// Inicializa o carrinho na sessão, se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Processa o formulário para adicionar ao carrinho
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_lanche'])) {
    $id_lanche = intval($_POST['id_lanche']);
    $nome_lanche = htmlspecialchars($_POST['nome_lanche']);
    $preco_lanche = htmlspecialchars($_POST['preco_lanche']);
    $quantidade = intval($_POST['quantidade']);

    // Adiciona ou atualiza o lanche no carrinho
    if (isset($_SESSION['carrinho'][$id_lanche])) {
        $_SESSION['carrinho'][$id_lanche]['quantidade'] += $quantidade;
    } else {
        $_SESSION['carrinho'][$id_lanche] = [
            'nome' => $nome_lanche,
            'preco' => $preco_lanche,
            'quantidade' => $quantidade
        ];
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Processa o formulário para esvaziar o carrinho
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['esvaziar_carrinho'])) {
    $_SESSION['carrinho'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Processa o pedido finalizado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['finalizar_pedido'])) {
    // Insere cada item do carrinho como um novo pedido
    $id_cliente = $_SESSION['id_cliente']; // Captura o id do cliente
    foreach ($_SESSION['carrinho'] as $item) {
        $produto = $item['nome'];
        $quantidade = $item['quantidade'];
        $totalItem = $quantidade * floatval(str_replace(['R$', ','], ['', '.'], $item['preco']));

        // Insere o pedido no banco de dados
        $stmt = $mysqli->prepare("INSERT INTO pedidos (id_cliente, produto, quantidade, data_pedido, total, status) VALUES (?, ?, ?, NOW(), ?, 'Aguardando Pagamento')");
        if ($stmt) {
            $stmt->bind_param("isid", $id_cliente, $produto, $quantidade, $totalItem);
            $stmt->execute();
            $stmt->close();
        } else {
            // Trate o erro de preparação da declaração
            echo "<script>alert('Erro ao finalizar o pedido.');</script>";
            exit();
        }
    }

    // Esvazia o carrinho após finalizar o pedido
    $_SESSION['carrinho'] = [];
    echo "<script>alert('Pedido finalizado com sucesso!');</script>";
    header("Refresh:0");
}

// Consulta os lanches da tabela lanches
$resultado = $mysqli->query("SELECT * FROM lanches");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senac-PR - Lanches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-lanche {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Carrinho</h2>
        <?php if (!empty($_SESSION['carrinho'])): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalCarrinho = 0;
                    foreach ($_SESSION['carrinho'] as $item) {
                        $totalItem = $item['quantidade'] * floatval(str_replace(['R$', ','], ['', '.'], $item['preco']));
                        $totalCarrinho += $totalItem;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nome']); ?></td>
                            <td>R$ <?php echo number_format((float)$item['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo $item['quantidade']; ?></td>
                            <td>R$ <?php echo number_format($totalItem, 2, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                        <td><strong>R$ <?php echo number_format($totalCarrinho, 2, ',', '.'); ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <form method="post">
                <button type="submit" name="esvaziar_carrinho" class="btn btn-danger">Esvaziar Carrinho</button>
                <button type="submit" name="finalizar_pedido" class="btn btn-success">Finalizar Pedido</button>
            </form>
        <?php else: ?>
            <p>Carrinho vazio.</p>
        <?php endif; ?>

        <h1 class="text-center mt-5">Lista de Lanches</h1>
        <div class="row">
            <?php while ($lanche = $resultado->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($lanche['foto']); ?>" class="card-img-top img-lanche" alt="<?php echo htmlspecialchars($lanche['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($lanche['nome']); ?></h5>
                            <p class="card-text">Ingredientes: <?php echo htmlspecialchars($lanche['ingredientes']); ?></p>
                            <p class="card-text">Preço: R$ <?php echo number_format((float)$lanche['preco'], 2, ',', '.'); ?></p>
                            <form method="post">
                                <input type="hidden" name="id_lanche" value="<?php echo $lanche['id_lanches']; ?>">
                                <input type="hidden" name="nome_lanche" value="<?php echo $lanche['nome']; ?>">
                                <input type="hidden" name="preco_lanche" value="<?php echo $lanche['preco']; ?>">
                                <div class="mb-3">
                                    <label for="quantidade_<?php echo $lanche['id_lanches']; ?>" class="form-label">Quantidade:</label>
                                    <input type="number" name="quantidade" id="quantidade_<?php echo $lanche['id_lanches']; ?>" value="1" min="1" class="form-control" style="width: 80px;">
                                </div>
                                <button type="submit" class="btn btn-success">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="container text-center mb-5 mt-3">
            <button class="btn btn-primary">
                <a href="<?php echo isset($voltar_url) ? $voltar_url : 'login.php'; ?>" style="text-decoration: none; color: white;">Voltar</a>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
