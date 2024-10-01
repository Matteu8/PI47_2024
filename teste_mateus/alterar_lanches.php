<?php
include("conexao.php");
require("protecao.php");

if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

if (isset($_GET["id_alterar"])) {
    $id_alterar = $_GET["id_alterar"];
    $stmt = $mysqli->prepare("SELECT * FROM bebidas WHERE id = ?");
    $stmt->bind_param("i", $id_alterar);

    if (!$stmt->execute()) {
        die("Erro ao executar consulta: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Nenhuma bebida encontrada com o ID: " . $id_alterar);
    }

    if (isset($_POST["nome"])) {
        $nome = $_POST["nome"];
        $tipo = $_POST["tipo"];
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

            $diretorioUpload = "receber/"; // Verifique se o diretório existe
            
            // Verifica se o diretório existe, caso contrário, cria-o
            if (!is_dir($diretorioUpload)) {
                mkdir($diretorioUpload, 0777, true);
            }

            $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
            $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                die("Ocorreu um erro ao fazer o upload da imagem: " . $_FILES["foto"]["error"]);
            }
        }

        // Atualiza os dados no banco de dados
        $stmt = $mysqli->prepare("UPDATE bebidas SET nome = ?, tipo = ?, preco = ?, quantidade = ?, foto = ? WHERE id = ?");
        $stmt->bind_param("sssisi", $nome, $tipo, $preco, $quantidade, $caminhoFinal, $id_alterar);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: consultar_bebidas.php");
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
    <title>Alterar Bebida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php"); ?>
    <header>
        <h1>Alterar Bebida</h1>
    </header>
    <div class="d-flex justify-content-center">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title">Alterar Bebida</p>

            <label>
                <input required hidden value="<?php echo $row['id']; ?>" name="id_alterar">
            </label>

            <label>
                <input required value="<?php echo htmlspecialchars($row['nome']); ?>" class="input" name="nome">
                <span>Nome:</span>
            </label>

            <label>
                <input required value="<?php echo htmlspecialchars($row['tipo']); ?>" class="input" name="tipo">
                <span>Tipo:</span>
            </label>

            <label>
                <input required value="<?php echo htmlspecialchars($row['preco']); ?>" class="input" name="preco">
                <span>Preço:</span>
            </label>

            <label>
                <input required value="<?php echo htmlspecialchars($row['quantidade']); ?>" class="input" name="quantidade"
                    type="number" min="0">
                <span>Quantidade:</span>
            </label>

            <label>
                <span>Foto:</span>
                <input type="file" class="form-control" name="foto">
                <small>Deixe em branco se não quiser alterar a imagem.</small>
            </label>
            <button class="submit">Alterar</button>
            <a class="btn btn-primary d-flex justify-content-center" href="consultar_bebidas.php">Voltar</a>
        </form>
    </div>
    <br><br><br><br><br><br><br>
    <?php include("rodape.php"); ?>
</body>

</html>
