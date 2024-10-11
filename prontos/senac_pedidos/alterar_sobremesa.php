<?php
include("conexao.php");


// Depois, se um ID foi passado via GET, busque os detalhes desse médico para exibição
if (isset($_GET['id_alterar'])) {
    $id_sobremesa = $_GET['id_alterar'];
    $sql_consultar = "SELECT * FROM pi_2024_pedidos_sobremesa WHERE id_sobremesa= '$id_sobremesa' ";
    $mysqli_consultar = $mysqli->query($sql_consultar) or die($mysqli->error);
    $consultar = $mysqli_consultar->fetch_assoc();

    // Primeiro, verifique se o formulário foi enviado e, em caso afirmativo, processe a submissão
    if (isset($_POST['id_sobremesa'])) {
        $id_sobremesa = $_POST['id_sobremesa'];
        $nome = $_POST['nome'];
        $ingrediente = $_POST['ingrediente'];
        $preco = $_POST['preco'] ?? '';
        $quantidade = intval($_POST['quantidade'] ?? 0);
        $caminho_banco = $consultar['foto']; // Preserva o caminho da foto antiga



        if (isset($_FILES['bt_foto']) && $_FILES['bt_foto']['error'] === 0) {
            $arquivo = $_FILES['bt_foto'];

            // Limite de tamanho do arquivo
            if ($arquivo['size'] > 15000000) {
                die("Arquivo muito grande!! Max: 15MB");
            }

            $pasta = "recebidos.img/";
            $nome_arquivo = $arquivo['name'];
            $novo_nome_arquivo = uniqid();
            $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
            $caminho_banco = $pasta . $novo_nome_arquivo . "." . $extensao;

            // Verifique se o diretório existe, caso contrário, crie-o
            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            // Movendo o arquivo para o diretório correto
            $deucerto = move_uploaded_file($arquivo["tmp_name"], $caminho_banco);

            if (!$deucerto) {
                die("Falha ao mover o arquivo para o diretório de destino.");
            }
        }
        if (isset($_GET['status']) && $_GET['status'] == 'success') {
            echo "<p>Sobremesa atualizada com sucesso!</p>";
        }

        // Atualizando os dados no banco de dados
        $sql_alterar = "UPDATE pi_2024_pedidos_sobremesa SET nome = '$nome', preco = '$preco', ingrediente = '$ingrediente', quantidade = '$quantidade', foto = '$caminho_banco' WHERE id_sobremesa = '$id_sobremesa'";
        $mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);

        header("location:consulta_sobremesa.php");
    }
} else {
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo2.png">
    <title>Alterar - Sobremesa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php") ?>
    <header>
        <h1>Alterar Sobremesa</h1>
    </header>
    <br><br>
    <div class="d-flex justify-content-center mb-3">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title">Alterar</p>
            <label>
                <input type="hidden" name="id_sobremesa"
                    value="<?php echo htmlspecialchars($consultar['id_sobremesa']); ?>">
            </label>

            <label>
                <span>Nome:</span>
                <input class="form-control" type="text" id="nome" name="nome"
                    value="<?php echo htmlspecialchars($consultar['nome']); ?>" required>

            </label>

            <label>
                <span>Ingredientes:</span>
                <input class="form-control" type="text" id="preco" name="preco"
                    value="<?php echo htmlspecialchars($consultar['preco']); ?>" required>

            </label>

            <label>
                <span>Quantidade:</span>
                <input class="form-control" type="number" id="quantidade" name="quantidade"
                    value="<?php echo htmlspecialchars($consultar['quantidade']); ?>" required>

            </label>

            <label>
                <span>Preço:</span>
                <input class="form-control" type="text" id="preco" name="ingrediente"
                    value="<?php echo htmlspecialchars($consultar['ingrediente']); ?>" required>

            </label>

            <label>
                <input type="file" class="form-control" name="foto">
                <span></span>
            </label>
            <?php if (empty($consultar['foto'])): ?>
                <div class="mt-3 text-center">
                    <img src="<?php echo htmlspecialchars($consultar['foto']); ?>" alt="foto da sobremesa"
                        class="img-thumbnail">
                </div>
            <?php endif; ?>

            <button class="submit">Atualizar</button>
            <a class="d-flex btn btn-primary justify-content-center" href="consulta_sobremesa.php">Voltar</a>
        </form>
    </div>
    <?php include("rodape.php") ?>
    <!-- Inclua o JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>