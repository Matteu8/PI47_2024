<?php
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['truncate_bebidas'])) {
    $mysqli->query("TRUNCATE TABLE bebidas") or die($mysqli->error);
    header("Location: " . $_SERVER['PHP_SELF']); // Redireciona após esvaziar
    exit();
}

$consultar_banco = "SELECT * FROM bebidas";
$retorno_consulta = $mysqli->query($consultar_banco) or die($mysqli->error);
$qntd = $retorno_consulta->num_rows; // Retornar quantidade de linhas
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/logo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lista - Bebidas</title>
    <link rel="stylesheet" href="gabriell.css">
    <style>
        .container {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .especialidade h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .table {
            margin-top: 20px;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #343a40;
            color: #fff;
            text-align: center;
        }

        .table td,
        .table th {
            vertical-align: middle;
            padding: 12px;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn {
            border-radius: 5px;
            padding: 6px 12px;
            font-size: 14px;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .back-button {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .img-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
    <
</head>

<body>
    <?php include "menu.php"; ?>
    <div class="container">
        <div class="especialidade">
            <h1>Lista - Bebidas</h1>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Tipos</th>
                    <th>Preço</th>
                    <th>Foto</th>
                    <th>Alterar</th>
                    <th>Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($bebidas = $retorno_consulta->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($bebidas['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($bebidas["tipo"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($bebidas['preco'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><img src="<?php echo htmlspecialchars($bebidas['foto'], ENT_QUOTES, 'UTF-8'); ?>" class="img-thumbnail"></td>
                        <td><a class="btn btn-primary" href="editar_bebidas.php?id_alterar=<?php echo $bebidas['id']; ?>">Alterar</a></td>
                        <td><a class="btn btn-danger" href="deletar_bebidas.php?id_deletar=<?php echo $bebidas['id']; ?>">Deletar</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Botão para esvaziar a tabela de bebidas -->
        <form method="post" class="text-center mt-3"
              onsubmit="return confirm('Você tem certeza que deseja esvaziar a tabela de bebidas?');">
            <button type="submit" name="truncate_bebidas" class="btn btn-warning">Esvaziar Tabela Bebidas</button>
        </form>

        <div class="back-button">
            <a class="btn btn-primary" href="area_funcionarios.php">Voltar</a>
        </div>
    </div>
<?php include("rodape.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
