<?php
include("conexao.php");

if (isset($_GET["id_alterar"])) {
    $id_alterar = $_GET["id_alterar"];
    $stmt = $mysqli->prepare("SELECT * FROM pi_2024_pedidos_bebidas WHERE id = ?");
    $stmt->bind_param("i", $id_alterar);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (isset($_POST["nome"])) {
        $nome = $_POST["nome"];
        $tipo = $_POST["tipo"];
        $preco = $_POST["preco"];
        $quantidade = $_POST["quantidade"];
        $caminhoFinal = $row['foto']; // Mantém a foto existente por padrão

        // Verifica se uma nova imagem foi enviada
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            // Verifica se o arquivo é uma imagem válida
            if (getimagesize($_FILES["foto"]["tmp_name"]) === false) {
                $erro = "O arquivo enviado não é uma imagem válida.";
            } else {
                // Verifica a extensão do arquivo
                $extensoesPermitidas = ['jpeg', 'jpg', 'png', 'gif', 'jfif'];
                $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

                if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
                    $erro = "Tipo de arquivo não suportado. Apenas JPEG, JPG, PNG, GIF e JFIF são permitidos.";
                }

                // Verifica o tamanho do arquivo (limite de 5MB)
                if ($_FILES["foto"]["size"] > 5000000) {
                    $erro = "Arquivo muito grande! O tamanho máximo é de 5MB.";
                }

                if (!isset($erro)) {
                    // Define o local para salvar a imagem
                    $diretorioUpload = "receber/";
                    $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
                    $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

                    // Tenta mover o arquivo temporário para o diretório final
                    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                        $erro = "Ocorreu um erro ao fazer o upload da imagem.";
                    }
                }
            }
        }

        // Se não houver erros de upload ou outros
        if (!isset($erro)) {
            // Atualiza os dados no banco de dados
            $stmt = $mysqli->prepare("UPDATE pi_2024_pedidos_bebidas SET nome = ?, tipo = ?, preco = ?, quantidade = ?, foto = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $nome, $tipo, $preco, $quantidade, $caminhoFinal, $id_alterar);
            $stmt->execute();

            // Exibe mensagem de sucesso e redireciona após 2 segundos
            echo "<script>alert('Bebida atualizada com sucesso!');</script>";
            echo "<meta http-equiv='refresh' content='2;url=consultar_bebidas.php'>";
            exit();
        }
    }
} else {
    die("ID da bebida não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Bebida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php") ?>
    <h1 class="text-center" style="background-color: #FFA500; color: white;">Alterar Bebida</h1>

    <div class="container d-flex justify-content-center">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title"> Alterar Bebida</p>
            <?php if (isset($erro)) { ?>
                <div class="alert alert-danger">
                    <?php echo $erro; ?>
                </div>
            <?php } ?>

            <label>
                <input required type="text" name="nome" class="input"
                    value="<?php echo htmlspecialchars($row['nome']); ?>">
                <span>Nome:</span>
            </label>

            <label>
                <input required type="text" name="tipo" class="input"
                    value="<?php echo htmlspecialchars($row['tipo']); ?>">
                <span>Tipo:</span>
            </label>

            <label>
                <input required type="number" name="quantidade" class="input"
                    value="<?php echo htmlspecialchars($row['quantidade']); ?>">
                <span>Quantidade:</span>
            </label>

            <label>
                <input required type="text" name="preco" class="input"
                    value="<?php echo htmlspecialchars($row['preco']); ?>">
                <span>Preço:</span>
            </label>

            <label>
                <span>Foto:</span>
                <input type="file" class="form-control" name="foto">
                <small>Deixe em branco se não quiser alterar a imagem.</small>
            </label>

            <button type="submit" class="submit">Atualizar</button>
            <a class="btn btn-primary d-flex justify-content-center" href="consultar_bebidas.php">Voltar</a>
        </form>
        
    </div>
    <br><br><br><br><br><br><br>
    <?php include "rodape.php"; ?>
</body>

</html>