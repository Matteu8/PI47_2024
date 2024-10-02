<?php
include("conexao.php");
require("protecao.php");

if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

if (isset($_GET["id_alterar"])) {
    $id_alterar = $_GET["id_alterar"];
    $stmt = $mysqli->prepare("SELECT * FROM lanches WHERE id_lanches = ?");
    $stmt->bind_param("i", $id_alterar);
    
    if (!$stmt->execute()) {
        die("Erro ao executar consulta: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Nenhum lanche encontrado com o ID: " . $id_alterar);
    }

    if (isset($_POST["nome"])) {
        $nome = $_POST["nome"];
        $ingredientes = $_POST["ingredientes"];
        $preco = floatval($_POST["preco"]);
        $quantidade = intval($_POST["quantidade"]); // Nova linha para quantidade
        $caminhoFinal = $row["foto"];

        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check === false) {
                die("O arquivo não é uma imagem.");
            }

            $extensoesPermitidas = ['jpeg', 'jpg', 'png', 'gif', 'jfif'];
            $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
            if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
                die("Tipo de arquivo não suportado.");
            }

            if ($_FILES["foto"]["size"] > 5000000) {
                die("Arquivo muito grande! Max: 5MB");
            }

            $diretorioUpload = "Lanches/img";
            $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
            $caminhoFinal = $diretorioUpload . "/" . $novoNomeArquivo;

            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                die("Ocorreu um erro ao fazer o upload da imagem: " . $_FILES["foto"]["error"]);
            }
        }

        // Atualiza também a quantidade na tabela
        $stmt = $mysqli->prepare("UPDATE lanches SET nome = ?, ingredientes = ?, preco = ?, quantidade = ?, foto = ? WHERE id_lanches = ?");
        $stmt->bind_param("sssisi", $nome, $ingredientes, $preco, $quantidade, $caminhoFinal, $id_alterar);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: lista_lanches.php");
            exit();
        } else {
            die("Erro ao atualizar: " . $stmt->error);
        }
    }
} else {
    die("ID não encontrado na URL.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar lanches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php") ?>
    <header>
        <h1>Alterar Lanches</h1>
    </header>
    <br><br>
    <div class="d-flex justify-content-center">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title">Alterar Lanche</p>
            <label>
                <input required="" hidden value="<?php echo $row["id_lanches"] ?>" name="id_alterar">
            </label>

            <label>
                <input required="" value="<?php echo $row["nome"] ?>" class="input" name="nome">
                <span>Nome:</span>
            </label>

            <label>
                <input required="" value="<?php echo $row["ingredientes"] ?>" class="input" name="ingredientes">
                <span>Ingredientes:</span>
            </label>

            <label>
                <input required="" value="<?php echo $row["preco"] ?>" class="input" name="preco">
                <span>Preço:</span>
            </label>
            
            <label>
                <input required="" value="<?php echo $row["quantidade"] ?>" class="input" name="quantidade" type="number" min="0">
                <span>Quantidade:</span>
            </label>

            <label>
                <input type="file" class="form-control" name="foto">
                <span></span>
            </label>
            <button class="submit">Atualizar</button>
            <a class="d-flex btn btn-primary justify-content-center" href="lista_lanches.php">Voltar</a>
        </form>
    </div>
    <?php include("rodape.php") ?>
</body>

</html>