<?php
require("conexao.php");
// require("protecao");

if (isset($_POST['nome'])) {
    // Coletando os dados do formulário
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $foto = $_FILES["foto"];
    $caminhoFinal = '';

    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
        // Verifique se o arquivo é uma imagem
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            die("O arquivo não é uma imagem.");
        }

        // Verifique a extensão do arquivo
        $extensoesPermitidas = array('jpeg', 'jpg', 'png', 'gif');
        $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
            die("Tipo de arquivo não suportado.");
        }

        // Verifique o tamanho do arquivo (limite de 5MB)
        if ($_FILES["foto"]["size"] > 5000000) {
            die("Arquivo muito grande! Max: 5MB");
        }

        // Defina o local para salvar a imagem
        $diretorioUpload = "receber/";
        $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
        $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

        // Tente mover o arquivo temporário para o diretório final
        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
            die("Ocorreu um erro ao fazer o upload da imagem.");
        }
    }

    // Preparando a consulta SQL para inserir os dados
    $sql = "INSERT INTO bebidas (nome, tipo, preco, quantidade, foto) VALUES ('$nome', '$tipo', '$preco', '$quantidade', '$caminhoFinal')";

    // Executando a consulta
    if ($mysqli->query($sql) === TRUE) {
        $mensagem = "<div class='alert alert-success' role='alert'> Bebida cadastrada com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger' role='alert'> Erro ao cadastrar bebida " . $mysqli->error . "</div>";
    }

    // Fechando a conexão
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Bebidas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="dieimes.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <?php include("menu.php"); ?>

    <div class="container text-center">
        <h1 class="mt-3">Cadastrar Bebidas</h1>
        <form action="cadastrar_bebidas.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label" for="nome">Nome da Bebida:</label>
                <input class="form-control" type="text" id="nome" name="nome" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="tipo">Tipo de Bebida:</label>
                <input class="form-control" type="text" id="tipo" name="tipo" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="preco">Preço:</label>
                <input class="form-control" type="number" id="preco" name="preco" step="0.01" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="quantidade">Quantidade em Estoque:</label>
                <input class="form-control" type="number" id="quantidade" name="quantidade" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="foto">Foto:</label>
                <input class="form-control" type="file" id="foto" name="foto" required>
            </div>

            <?php if (isset($mensagem)) { echo $mensagem; } ?>
            <br>
            <input class="btn btn-success" type="submit" value="Cadastrar Bebida">
            <a class="btn btn-secondary" href="#">Cancelar</a>
        </form>
    </div>

    <?php include("rodape.php"); ?>
</body>
</html>
