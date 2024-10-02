<?php
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['truncate_sobremesa'])) {
    $mysqli->query("TRUNCATE TABLE sobremesa") or die($mysqli->error);
    header("Location: " . $_SERVER['PHP_SELF']); // Redireciona após esvaziar
    exit();
}

$consultar_banco = "SELECT * FROM sobremesa";
$retorno_consulta = $mysqli->query($consultar_banco) or die($mysqli->error);
$qntd = $retorno_consulta->num_rows; // retornar quantidade de linhas
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lista - Profissionais</title>
    <link rel="stylesheet" href="gabriell.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
</head>

<body>
    <?php include("menu.php") ?>
    <div class="container">
        <div class="especialidade">
            <h1>Lista - Consulta Sobremesa</h1>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
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

                        <td><?php echo htmlspecialchars($profissional['nome']); ?></td>
                        <td><?php echo htmlspecialchars($profissional['ingrediente']); ?></td>
                        <td><?php echo 'R$ ' . number_format($profissional['preco'], 2, ',', '.'); ?></td>
                        
                        <td><?php echo htmlspecialchars($profissional['quantidade']); ?></td>
                        <td>
                            <img src="<?php echo ($profissional['imagem']); ?>" alt="Foto do profissional"
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