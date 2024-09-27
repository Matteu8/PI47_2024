<?php
include("conexao.php");
require("protecao.php");

$mysqli->set_charset("utf8mb4"); // Acentuação

$limite = 10; // Número de lanches por página
$pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

$consultar_banco = "SELECT * FROM lanches LIMIT $inicio, $limite";
$retorno_consulta = $mysqli->query($consultar_banco) or die($mysqli->error);

$consulta_total = $mysqli->query("SELECT COUNT(*) as total FROM lanches");
$total_lanches = $consulta_total->fetch_assoc()['total'];
$total_paginas = ceil($total_lanches / $limite);

// Lógica para truncar a tabela lanches
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['truncate_lanches'])) {
    $mysqli->query("TRUNCATE TABLE lanches") or die($mysqli->error);
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
    <title>Funcionario - Lista Lanches</title>
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

    <div class="container">
        <h1 class="my-4 text-center">Lista de Lanches</h1>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Ingredientes</th>
                        <th>Preço</th>
                        <th>Foto</th>
                        <th>Alterar</th>
                        <th>Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($lanches = $retorno_consulta->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($lanches['nome']); ?></td>
                            <td><?php echo htmlspecialchars($lanches["ingredientes"]); ?></td>
                            <td>R$ <?php echo number_format($lanches['preco'], 2, ',', '.'); ?></td> <!-- Adicionando o símbolo R$ -->
                            <td><img src="<?php echo($lanches['foto']); ?>" class="img-thumbnail"></td>
                            <td>
                                <a class="btn btn-primary" href="alterar_lanches.php?id_alterar=<?php echo $lanches['id_lanches']; ?>">Alterar</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="deletar_lanches.php?id_deletar=<?php echo $lanches['id_lanches']; ?>">Deletar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                    <li class="page-item <?php if ($pagina == $i) echo 'active'; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        <!-- Botão para esvaziar a tabela de lanches -->
        <form method="post" class="text-center" onsubmit="return confirm('Você tem certeza que deseja esvaziar a tabela de lanches?');">
            <button type="submit" name="truncate_lanches" class="btn btn-warning">Esvaziar Tabela Lanches</button>
        </form>

        <div class="back-button mt-3">
            <a class="btn btn-primary" href="area_funcionarios.php">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
