<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário está logado e se o tipo de usuário está na sessão
if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['tipo_usuario'] == 'cliente' && !isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['tipo_usuario'] == 'funcionario' && !isset($_SESSION['id_funcionario'])) {
    header("Location: login.php");
    exit();
}

// Define a URL de redirecionamento para o botão "Voltar" com base no tipo de usuário
if ($_SESSION['tipo_usuario'] == 'cliente') {
    $voltar_url = "area_cliente.php";
} else if ($_SESSION['tipo_usuario'] == 'funcionario') {
    $voltar_url = "area_funcionarios.php";
}

// Inicializa o carrinho na sessão, se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Verifica se o formulário foi enviado para adicionar ao carrinho
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_lanche'])) {
    $id_lanche = intval($_POST['id_lanche']);
    $nome_lanche = htmlspecialchars($_POST['nome_lanche']);
    $preco_lanche = htmlspecialchars($_POST['preco_lanche']);
    
    // Adiciona o lanche ao carrinho
    $_SESSION['carrinho'][$id_lanche] = [
        'nome' => $nome_lanche,
        'preco' => $preco_lanche,
        'quantidade' => isset($_SESSION['carrinho'][$id_lanche]) ? $_SESSION['carrinho'][$id_lanche]['quantidade'] + 1 : 1
    ];
    
    // Redireciona para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Verifica se o formulário foi enviado para esvaziar o carrinho
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['esvaziar_carrinho'])) {
    // Esvazia o carrinho
    $_SESSION['carrinho'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
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
            height: 150px; /* Ajuste a altura como preferir */
            object-fit: cover; /* Mantém a proporção da imagem */
            border-radius: 20%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Lista de Lanches</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ingredientes</th>
                        <th>Preço</th>
                        <th>Foto</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($lanche = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($lanche['id_lanches']); ?></td>
                            <td><?php echo htmlspecialchars($lanche['nome']); ?></td>
                            <td><?php echo htmlspecialchars($lanche['ingredientes']); ?></td>
                            <td>R$ <?php echo number_format((float)$lanche['preco'], 2, ',', '.'); ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($lanche['foto']); ?>" alt="<?php echo htmlspecialchars($lanche['nome']); ?>" class="img-lanche">
                            </td>
                            <td>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="id_lanche" value="<?php echo $lanche['id_lanches']; ?>">
                                    <input type="hidden" name="nome_lanche" value="<?php echo $lanche['nome']; ?>">
                                    <input type="hidden" name="preco_lanche" value="<?php echo $lanche['preco']; ?>">
                                    <button type="submit" class="btn btn-success">Adicionar ao Carrinho</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Exibir o conteúdo do carrinho -->
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

            <!-- Botão para esvaziar o carrinho -->
            <form method="post">
                <button type="submit" name="esvaziar_carrinho" class="btn btn-danger">Esvaziar Carrinho</button>
            </form>
        <?php else: ?>
            <p>Carrinho vazio.</p>
        <?php endif; ?>

        <div class="container text-center mt-3">
            <button class="btn btn-primary">
                <a href="<?php echo isset($voltar_url) ? $voltar_url : 'login.php'; ?>" style="text-decoration: none; color: white;">Voltar</a>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
