<?php
include("conexao.php");
require("protecao.php"); // Proteção semelhante à página de lanches

$limite = 10; // Número de bebidas por página
$pagina = (isset($_GET['pagina'])) ? (int) $_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

// Consulta para obter bebidas com limite, incluindo quantidade
$consultar_banco = "SELECT id, nome, tipo, preco, foto, quantidade FROM bebidas LIMIT $inicio, $limite";
$retorno_consulta = $mysqli->query($consultar_banco) or die($mysqli->error);

// Contagem total de bebidas
$consulta_total = $mysqli->query("SELECT COUNT(*) as total FROM bebidas");
$total_bebidas = $consulta_total->fetch_assoc()['total'];
$total_paginas = ceil($total_bebidas / $limite);

// Lógica para truncar a tabela bebidas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['truncate_bebidas'])) {
    $mysqli->query("TRUNCATE TABLE bebidas") or die($mysqli->error);
    header("Location: " . $_SERVER['PHP_SELF']); // Redireciona após esvaziar
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/logo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Funcionário - Lista Bebidas</title>
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
    <?php include("menu.php"); ?>
    <div class="container">
        <h1 class="my-4 text-center">Lista de Bebidas</h1>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Preço</th>
                        <th>Quantidade</th> <!-- Adicionando a coluna de quantidade -->
                        <th>Foto</th>
                        <th>Alterar</th>
                        <th>Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($bebidas = $retorno_consulta->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($bebidas['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($bebidas['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($bebidas['tipo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo 'R$ ' . number_format($bebidas['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($bebidas['quantidade'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <!-- Mostrando a quantidade -->
                            <td>
                                <img src="<?php echo htmlspecialchars($bebidas['foto'], ENT_QUOTES, 'UTF-8'); ?>"
                                    class="img-thumbnail"
                                    alt="<?php echo htmlspecialchars($bebidas['nome'], ENT_QUOTES, 'UTF-8'); ?>">
                            </td>
                            <td>
                                <a class="btn btn-primary"
                                    href="editar_bebidas.php?id_alterar=<?php echo $bebidas['id']; ?>">Alterar</a>
                            </td>
                            <td>
                                <a class="btn btn-danger"
                                    href="deletar_bebidas.php?id_deletar=<?php echo $bebidas['id']; ?>">Deletar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <nav>
            <ul class="pagination mt-4 justify-content-center">
                <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                    <li class="page-item <?php if ($pagina == $i)
                        echo 'active'; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        <!-- Botão para esvaziar a tabela de bebidas -->
        <form method="post" class="text-center"
            onsubmit="return confirm('Você tem certeza que deseja esvaziar a tabela de bebidas?');">
            <button type="submit" name="truncate_bebidas" class="btn btn-warning">Esvaziar Tabela Bebidas</button>
        </form>

        <div class="back-button mt-3">
            <a class="btn btn-primary" href="area_funcionarios.php">Voltar</a>
        </div>
    </div>
    <?php include("rodape.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>