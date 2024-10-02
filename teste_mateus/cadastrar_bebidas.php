<?php
include("conexao.php");
require("protecao.php");

if (isset($_POST['nome'])) {
    // Coletando os dados do formulário
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $foto = $_FILES["foto"];
    $caminhoFinal = '';

    // Converte os dados para UTF-8 antes de inserir no banco
    $nome = $mysqli->real_escape_string($nome);
    $tipo = $mysqli->real_escape_string($tipo);
    $preco = $mysqli->real_escape_string($preco);
    $quantidade = $mysqli->real_escape_string($quantidade);

    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
        // Verifique se o arquivo é uma imagem
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            die("O arquivo não é uma imagem.");
        }

        // Verifique a extensão do arquivo
        $extensoesPermitidas = array('jpeg', 'jpg', 'png', 'gif','jfif');
        $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
            die("Tipo de arquivo não suportado.");
        }

        // Verifique o tamanho do arquivo (limite de 5MB)
        if ($_FILES["foto"]["size"] > 5000000) {
            die("Arquivo muito grande! Max: 5MB");
        }

        // Defina o local para salvar a imagem
        $diretorioUpload = "Lanches/bebidas/";
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
        header("Location: consultar_bebidas.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php"); ?>
    <h1 class="text-center" style="background-color: #FFA500; color: white;">Cadastrar Bebidas</h1>
    <div class="container d-flex justify-content-center">
        <form class="form" method="post" enctype="multipart/form-data">

            <p class="title">Cadastre sua bebida</p>
            <p class="message">Preencha abaixo as informação da bebida</p>
            <label>
                <input required type="text" name="nome" class="input" id="nome" name="nome">
                <span>Nome:</span>
            </label>
            <label>
                <input required type="text" name="tipo" class="input" id="tipo" name="tipo">
                <span>Tipo:</span>
            </label>
            <label>
                <input required name="quantidade" class="input" type="number" id="quantidade">
                <span>Quantidade:</span>
            </label>
            <label>
                <input type="number" name="preco" class="input" id="preco" name="preco">
                <span>Preço:</span>
            </label>
            <label>
                <span>Foto: </span>
                <input type="file" class="form-control" name="foto">
            </label>
            <?php if (isset($mensagem)) {
                echo $mensagem;
            } ?>
            <button type="submit" class="submit">Atualizar</button>
            <a class="btn btn-primary d-flex justify-content-center" href="area_funcionarios.php">Voltar</a>
        </form>
    </div>

    <?php include("rodape.php"); ?>
</body>

</html>