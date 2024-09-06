<?php
include("conexao.php");

$consultar_banco = "SELECT * FROM basico_tabela";
$retorno_consulta = $mysqli->query($consultar_banco) or die($mysqli->error);
$qntd = $retorno_consulta->num_rows; // retornar quantidade de linhas
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/logo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lista - Profissionais</title>
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

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

        .table td, .table th {
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

<div class="container">
    <div class="especialidade">
        <h1>Lista - Profissionais</h1>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id do profissional</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Especialidade</th>
                <th>Endereço</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>E-mail</th>
                <th>Foto</th>
                <th>Alterar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($profissional = $retorno_consulta->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($profissional['id_funcionario']); ?></td>
                    <td><?php echo htmlspecialchars($profissional['nome']); ?></td>
                    <td><?php echo htmlspecialchars($profissional['telefone']); ?></td>
                    <td><?php echo htmlspecialchars($profissional['cargo']); ?></td>
                    <td><?php echo htmlspecialchars($profissional['endereco']); ?></td>
                    <td><?php echo htmlspecialchars($profissional['cpf']); ?></td>
                    
                    <td><?php echo htmlspecialchars($profissional['datanasc']); ?></td>
                    <td><?php echo htmlspecialchars($profissional['email']); ?></td>
                    <td>
                        <img src="<?php echo htmlspecialchars($profissional['caminho_foto']); ?>" alt="Foto do profissional" class="img-thumbnail">
                    </td>
                    
                    <td><a class="btn btn-primary" href="alterar_pro.php?id_funcionario=<?php echo $profissional['id_funcionario']; ?>">Alterar</a></td>
                    <td><a class="btn btn-danger" href="deletar_pro.php?id_funcionario=<?php echo $profissional['id_funcionario']; ?>">Deletar</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="back-button">
        <a class="btn btn-primary" href="cadastrar_funcionario.php">Voltar</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>