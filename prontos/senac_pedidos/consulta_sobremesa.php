<?php
include("conexao.php");
include("protecao.php");
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o botão para esvaziar a tabela foi clicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['truncate_sobremesa'])) {
    $mysqli->query("TRUNCATE TABLE sobremesa") or die($mysqli->error);
    header("Location: " . $_SERVER['PHP_SELF']); // Redireciona após esvaziar
    exit();
}

// Configurações de paginação
$pedidos_por_pagina = 10; // Número de sobremesas por página
$pagina_atual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1; // Página atual
$offset = ($pagina_atual - 1) * $pedidos_por_pagina; // Offset para a consulta

// Consulta total de sobremesas
$total_sobremesas_query = "SELECT COUNT(*) AS total FROM pi_2024_pedidos_sobremesa";
$total_result = $mysqli->query($total_sobremesas_query);
$total_row = $total_result->fetch_assoc();
$total_sobremesas = $total_row['total']; // Total de sobremesas
$total_paginas = ceil($total_sobremesas / $pedidos_por_pagina); // Total de páginas

// Consulta para buscar as sobremesas com limite e offset
$consultar_banco = "SELECT * FROM pi_2024_pedidos_sobremesa LIMIT ?, ?";
$stmt = $mysqli->prepare($consultar_banco);
$stmt->bind_param("ii", $offset, $pedidos_por_pagina);
$stmt->execute();
$retorno_consulta = $stmt->get_result();
$qntd = $retorno_consulta->num_rows; // Retorna quantidade de linhas
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Senac-PR - Lista Sobremesas</title>
    <link rel="stylesheet" href="gabriell.css">
    <style>
         .img-thumbnail {
            width: 4rem;
            height: 4rem;
            object-fit: cover;
            border-radius: 50%;
        }

        @media (max-width: 576px) {
            .img-thumbnail {
                width: 3rem;
                height: 3rem;
            }

            .table td {
                font-size: 14px;
            }

            .table thead {
                font-size: 16px;
            }
        }

        .btn {
            margin-bottom: 5px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <?php include("menu.php") ?>
    <div class="container">
        <div class="especialidade">
            <h1 class="my-4 text-center">Lista - Consulta Sobremesa</h1>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark"> 
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ingredientes</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Foto</th>
                        <th>Alterar</th>
                        <th>Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($profissional = $retorno_consulta->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($profissional['id_sobremesa'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($profissional['nome']); ?></td>
                            <td><?php echo htmlspecialchars($profissional['ingrediente']); ?></td>
                            <td><?php echo 'R$ ' . number_format($profissional['preco'], 2, ',', '.'); ?></td>

                            <td><?php echo htmlspecialchars($profissional['quantidade']); ?></td>
                            <td>
                                <img src="<?php echo ($profissional['foto']); ?>" alt="Foto do profissional"
                                    class="img-thumbnail">
                            </td>

                            <td><a class="btn btn-primary"
                                    href="alterar_sobremesa.php?id_alterar=<?php echo $profissional['id_sobremesa']; ?>">Alterar</a>
                            </td>
                            <td><a class="btn btn-danger"
                                    href="deletar_sobremesa.php?id_sobremesa=<?php echo $profissional['id_sobremesa']; ?>">Deletar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <!-- Paginação -->
        <nav aria-label="Navegação de páginas" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($pagina_atual > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $pagina_atual - 1; ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?php echo ($i == $pagina_atual) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagina_atual < $total_paginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $pagina_atual + 1; ?>" aria-label="Próxima">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- Botão para esvaziar a tabela de lanches -->
        <form method="post" class="text-center"
            onsubmit="return confirm('Você tem certeza que deseja esvaziar a tabela de lanches?');">
            <button type="submit" name="truncate_sobremesa" class="btn btn-warning">Esvaziar Tabela Sobremesas</button>
        </form>

        <div class="back-button">
            <a class="btn btn-primary" href="area_funcionarios.php">Voltar</a>
        </div>
    </div>
    <?php include("rodape.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>