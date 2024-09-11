<?php
include("conexao.php");



// Depois, se um ID foi passado via GET, busque os detalhes desse médico para exibição
if (isset($_GET['id_sobremesa'])) {
    $id_funcionario = $_GET['id_sobremesa'];
    $sql_consultar = "SELECT * FROM altera_sobremesa WHERE id_funcionario= '$id_funcionario' ";
    $mysqli_consultar = $mysqli->query($sql_consultar) or die($mysqli->error);
    $consultar = $mysqli_consultar->fetch_assoc();

    // Primeiro, verifique se o formulário foi enviado e, em caso afirmativo, processe a submissão
    if (isset($_POST['id_funcionario'])) {
        $id_funcionario = $_POST['id_funcionario'];
        $nome = $_POST['bt_nome'];
        $preco = $_POST['bt_preco'] ?? '';
        $quantidade = intval($_POST['bt_quantidade'] ?? 0);

        $caminho_banco = $consultar['caminho']; // Preserva o caminho da foto antiga

        if (isset($_FILES['bt_foto']) && $_FILES['bt_foto']['error'] === 0) {
            $arquivo = $_FILES['bt_foto'];
            
            // Limite de tamanho do arquivo
            if ($arquivo['size'] > 15000000) {
                die("Arquivo muito grande!! Max: 15MB");
            }

            $pasta = "recebidos/";
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

        // Atualizando os dados no banco de dados
        $sql_alterar = "UPDATE alterar_sobremesa SET nome = '$nome', preco = '$preco', quantidade = '$quantidade', caminho_foto = '$caminho_banco' WHERE id_funcionario = '$id_funcionario'";
        $mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);
        header("Location:consultar_funcionarios.php");
    }
}else{
    die("Precisar voltar para página de consultar sobremesas, para depois selecionar a opção alterar.");
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
    <link rel="stylesheet" href="meu.css">
</head>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar - Sobremesa</title>
    <!-- Inclua o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <form action="" method="post" enctype="multipart/form-data">
            <h1 class="text-center">Alterar - Sobremesa</h1>
            
            <input type="hidden" name="id_sobremesa" value="<?php echo htmlspecialchars($consultar['id_sobremesa']); ?>">
            
            <div class="mb-3">
                <label class="form-label" for="nome">Nome</label>
                <input class="form-control" type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($consultar['bt_nome']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="preco">Preço</label>
                <input class="form-control" type="text" id="preco" name="preco" value="<?php echo htmlspecialchars($consultar['bt_preco']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="quantidade">Quantidade</label>
                <input class="form-control" type="number" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($consultar['bt_quantidade']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="bt_foto">Foto</label>
                <input class="form-control" type="file" id="bt_foto" name="bt_foto">
            </div>

            <?php if (!empty($consultar['caminho_foto'])) : ?>
                <div class="mt-3 text-center">
                    <img src="<?php echo htmlspecialchars($consultar['caminho_foto']); ?>" alt="Foto do médico" class="img-thumbnail">
                </div>
            <?php endif; ?>

            <div class="mt-3 d-flex justify-content-between">
                <input class="btn btn-success" type="submit" value="Alterar">
                <a class="btn btn-primary" href="consultar_funcionario.php">Voltar</a>
            </div>
        </form>
    </div>

    <!-- Inclua o JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
