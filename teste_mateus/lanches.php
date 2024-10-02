<?php
include("conexao.php");
if (!isset($_SESSION)) {
    session_start();
}

// Inicializa o carrinho na sessão, se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Inicializa a variável voltar_url
$voltar_url = 'login.php'; // URL padrão caso nenhuma condição seja atendida

// Verifica se existe a sessão 'id_cliente'
if (isset($_SESSION['id_cliente'])) {
    $voltar_url = 'area_cliente.php'; // Altera para a URL desejada
}
// Verifica se existe a sessão 'id_funcionario'
elseif (isset($_SESSION['id_funcionario'])) {
    $voltar_url = 'area_funcionarios.php'; // Altera para a URL desejada
}

// Processa o formulário para adicionar ao carrinho
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_lanche'])) {
    $id_lanche = intval($_POST['id_lanche']);
    $nome_lanche = htmlspecialchars($_POST['nome_lanche']);
    $preco_lanche = htmlspecialchars($_POST['preco_lanche']);
    $quantidade = intval($_POST['quantidade']);

    $item_key = 'lanche_' . $id_lanche;

    // Verifica a quantidade disponível no banco de dados
    $stmt_verifica = $mysqli->prepare("SELECT quantidade FROM lanches WHERE id_lanches = ?");
    $stmt_verifica->bind_param("i", $id_lanche);
    $stmt_verifica->execute();
    $stmt_verifica->bind_result($quantidade_disponivel);
    $stmt_verifica->fetch();
    $stmt_verifica->close();

    if ($quantidade <= $quantidade_disponivel) {
        // Adiciona ou atualiza o lanche no carrinho
        if (isset($_SESSION['carrinho'][$item_key])) {
            $_SESSION['carrinho'][$item_key]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$item_key] = [
                'id_lanche' => $id_lanche,
                'nome' => $nome_lanche,
                'preco' => $preco_lanche,
                'quantidade' => $quantidade
            ];
        }

        // Atualiza a quantidade no banco de dados
        $nova_quantidade = $quantidade_disponivel - $quantidade;
        $stmt_atualiza = $mysqli->prepare("UPDATE lanches SET quantidade = ? WHERE id_lanches = ?");
        $stmt_atualiza->bind_param("ii", $nova_quantidade, $id_lanche);
        $stmt_atualiza->execute();
        $stmt_atualiza->close();
    } else {
        echo "<script>alert('Quantidade solicitada não disponível.');</script>";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Processa o formulário para esvaziar o carrinho
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['esvaziar_carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        // Reverte a quantidade no banco de dados
        $stmt_reverte = $mysqli->prepare("SELECT quantidade FROM lanches WHERE id_lanches = ?");
        $stmt_reverte->bind_param("i", $item['id_lanche']);
        $stmt_reverte->execute();
        $stmt_reverte->bind_result($quantidade_atual);
        $stmt_reverte->fetch();
        $nova_quantidade = $quantidade_atual + $item['quantidade'];
        $stmt_reverte->close();

        // Atualiza a quantidade no banco de dados
        $stmt_atualiza = $mysqli->prepare("UPDATE lanches SET quantidade = ? WHERE id_lanches = ?");
        $stmt_atualiza->bind_param("ii", $nova_quantidade, $item['id_lanche']);
        $stmt_atualiza->execute();
        $stmt_atualiza->close();
    }

    $_SESSION['carrinho'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Processa a finalização do pedido
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['finalizar_pedido'])) {
    $id_cliente = $_SESSION['id_cliente'] ?? null; // ID do cliente se disponível
    $id_pedido = null; // Inicializa a variável para o ID do pedido.

    // Obtém o nome do funcionário ou define como null
    $nome_funcionario = isset($_SESSION["nome"]) ? $_SESSION["nome"] : null;

    // Primeiro, insira um novo pedido na tabela 'pedidos'
    $stmt_pedido = $mysqli->prepare("INSERT INTO pedidos (id_clientes, data_pedido, status, nome_funcionario) VALUES (?, NOW(), 'Aguardando Pagamento', ?)");
    if ($stmt_pedido) {
        $stmt_pedido->bind_param("is", $id_cliente, $nome_funcionario);
        $stmt_pedido->execute();
        $id_pedido = $stmt_pedido->insert_id; // Obtém o ID do pedido inserido
        $stmt_pedido->close();
    } else {
        echo "<script>alert('Erro ao criar o pedido.');</script>";
        exit();
    }

    // Agora insira os itens do carrinho na tabela 'itens_pedido'
    foreach ($_SESSION['carrinho'] as $item) {
        $quantidade = $item['quantidade'];

        // Prepare a consulta para inserir os itens do pedido
        $stmt_item = $mysqli->prepare("INSERT INTO itens_pedido (id_pedido, id_lanches, quantidade) VALUES (?, ?, ?)");
        if ($stmt_item) {
            $stmt_item->bind_param("iii", $id_pedido, $item['id_lanche'], $quantidade);
            $stmt_item->execute();
            $stmt_item->close();
        } else {
            echo "<script>alert('Erro ao adicionar item ao pedido.');</script>";
            exit();
        }
    }

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
    <link rel="stylesheet" href="gabriell.css">
    <style>
        .img-lanche {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php include("menu.php"); ?>
    <div class="container mt-3">

        <?php if (isset($_SESSION['tipo_usuario'])): ?>
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
                        foreach ($_SESSION['carrinho'] as $item_key => $item) {
                            // Verifica se é um lanche ou uma bebida
                            if (strpos($item_key, 'lanche_') === 0) {
                                // É um lanche
                                $totalItem = $item['quantidade'] * floatval(str_replace(['R$', ','], ['', '.'], $item['preco']));
                            } elseif (strpos($item_key, 'bebida_') === 0) {
                                // É uma bebida
                                $totalItem = $item['quantidade'] * floatval(str_replace(['R$', ','], ['', '.'], $item['preco']));
                            }
                            $totalCarrinho += $totalItem;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['nome']); ?></td>
                                <td>R$ <?php echo number_format((float) $item['preco'], 2, ',', '.'); ?></td>
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
        <?php endif; ?>

        <h1 class="text-center mt-3">Lista de Lanches</h1>
        <div class="row">
            <?php while ($lanche = $resultado->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($lanche['foto']); ?>" class="card-img-top img-lanche"
                            alt="<?php echo htmlspecialchars($lanche['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($lanche['nome']); ?></h5>
                            <p class="card-text">Ingredientes: <?php echo htmlspecialchars($lanche['ingredientes']); ?></p>
                            <p class="card-text">Preço: R$
                                <?php echo number_format((float) $lanche['preco'], 2, ',', '.'); ?>
                            </p>
                            <p class="card-text">Quantidade Disponível:
                                <?php echo htmlspecialchars($lanche['quantidade']); ?>
                            </p>
                            <?php if (isset($_SESSION['tipo_usuario'])): ?>
                                <form method="post">
                                    <input type="hidden" name="id_lanche" value="<?php echo $lanche['id_lanches']; ?>">
                                    <input type="hidden" name="nome_lanche" value="<?php echo $lanche['nome']; ?>">
                                    <input type="hidden" name="preco_lanche" value="<?php echo $lanche['preco']; ?>">
                                    <input class="form-control" type="number" name="quantidade" min="1"
                                        max="<?php echo $lanche['quantidade']; ?>" required value="1"><br>
                                    <button type="submit" class="btn btn-primary mt-2">Adicionar ao Carrinho</button>
                                </form>
                            <?php else: ?>
                                <p class="text-danger">Necessário <a href="login.php">Login</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="container text-center mb-5 mt-3">
            <button class="btn btn-primary">
                <a href="<?php echo isset($voltar_url) ? $voltar_url : 'login.php'; ?>"
                    style="text-decoration: none; color: white;">Voltar</a>
            </button>
            <button class="btn btn-primary ms-3">
                <a href="bebidas.php" style="text-decoration: none; color: white;">Página de Bebidas</a>
            </button>
        </div>
    </div>
    <br><br><br><br><br><br><br>
    <?php include("rodape.php") ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>