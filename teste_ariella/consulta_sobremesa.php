<?php
include("conexao.php");

$mysqli->set_charset("utf8mb4"); /* Acentuação */

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
    <link rel="icon" href="../../img/logo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ariella.css">
    <title>Lista - Profissionais</title>

   
</head>

<body>

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
                <th>Foto</th>
                <th>Alterar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($sobremesa = $retorno_consulta->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($sobremesa['nome']); ?></td>
                    <td><?php echo  htmlspecialchars($sobremesa["ingredientes"]); ?></td>
                    <td><?php echo htmlspecialchars($sobremesa['preco']); ?></td>
                    <td><img src="<?php echo($sobremesa['foto']); ?>" class="img-thumbnail"></td>
                    <td><a class="btn btn-primary" href="alterar_sobremesa.php?id_alterar=<?php echo $sobremesa['id_sobremesas']; ?>">Alterar</a></td>
                    <td><a class="btn btn-danger" href="deletar_sobremesa.php?id_deletar=<?php echo $sobremesa['id_sobremesas']; ?>">Deletar</a></td>
                </tr>
            <?php } ?>
        </tbody>    
    </table>

    <div class="back-button">
        <a class="btn btn-primary" href="cadastrosobremesa.php">Voltar</a>



    </div>


                

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>