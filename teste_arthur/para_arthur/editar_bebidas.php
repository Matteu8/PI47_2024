<?php
require("conexao.php");

if (isset($_GET["id_alterar"])) {
    $id_alterar = $_GET["id_alterar"];
    $stmt = $mysqli->prepare("SELECT * FROM bebidas WHERE id = ?");
    $stmt->bind_param("i", $id_alterar);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (isset($_POST["nome"])) {
        $nome = $_POST["nome"];
        $tipo = $_POST["tipo"];
        $preco = $_POST["preco"];
        $quantidade = $_POST["quantidade"];
        $caminhoFinal = $row['foto']; // Mantém a foto existente

        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            // Verifica se o arquivo é uma imagem
            if (getimagesize($_FILES["foto"]["tmp_name"]) === false) {
                die("O arquivo não é uma imagem.");
            }

            // Verifica a extensão do arquivo
            $extensoesPermitidas = ['jpeg', 'jpg', 'png', 'gif'];
            $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
            if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
                die("Tipo de arquivo não suportado.");
            }

            // Verifica o tamanho do arquivo (limite de 5MB)
            if ($_FILES["foto"]["size"] > 5000000) {
                die("Arquivo muito grande! Max: 5MB");
            }

            // Define o local para salvar a imagem
            $diretorioUpload = "recebidos/";
            $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
            $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

            // Tenta mover o arquivo temporário para o diretório final
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                die("Ocorreu um erro ao fazer o upload da imagem.");
            }
        }

        // Atualiza os dados no banco de dados
        $stmt = $mysqli->prepare("UPDATE bebidas SET nome = ?, tipo = ?, preco = ?, quantidade = ?, foto = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nome, $tipo, $preco, $quantidade, $caminhoFinal, $id_alterar);
        $stmt->execute();

        header("Location: consultar_bebidas.php");
        exit();
    }
} else {
    die("ID não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Bebida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dieimes.css">
</head>

<body>
    <div class="row" style="background-color:#3a6da1;">
        <div class="col-md-5">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Topo do Site"></a>
        </div>
    </div>
    <h1 class="text-center" style="background-color: #FFA500; color: white;">Editar Bebida</h1>
    <div class="container d-flex justify-content-center mt-5">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title"> Edite aqui sua bebida </p>
            <p class="message">Edite os valores da sua bebida </p>
            <div class="flex">
                <label>
                    <input required type="text" name="nome" class="input" value="<?php echo htmlspecialchars($row['nome']); ?>">
                    <span>Nome:</span>
                </label>

                <label>
                    <input required type="text" name="tipo" class="input" value="<?php echo htmlspecialchars($row['tipo']); ?>">
                    <span>Tipo:</span>
                </label>
            </div>

            <label>
                <input required type="number" name="quantidade" class="input" value="<?php echo htmlspecialchars($row['quantidade']); ?>">
                <span>Quantidade:</span>
            </label>

            <label>
                <input required type="text" name="preco" class="input" value="<?php echo htmlspecialchars($row['preco']); ?>">
                <span>Preço:</span>
            </label>
            <label>
                <input type="file" class="form-control" name="foto">
                <span>Foto:</span>
            </label>

            <button type="submit" class="submit">Atualizar</button>
        </form>
    </div>

    <?php include "rodape.php"; ?>
</body>

</html>
