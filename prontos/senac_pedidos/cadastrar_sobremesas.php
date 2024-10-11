<?php
include("conexao.php");
require("protecao.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $mysqli->real_escape_string($_POST["nome"]);
    $tipo = $mysqli->real_escape_string($_POST["ingrediente"]);
    $preco = $mysqli->real_escape_string($_POST["preco"]);
    $quantidade = $mysqli->real_escape_string($_POST["quantidade"]);

    if (empty($nome) || empty($tipo) || empty($preco)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check === false) {
                $erro = "O arquivo não é uma imagem.";
            } else {
                $extensoesPermitidas = array('jpeg', 'jpg', 'png', 'gif', 'jfif');
                $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
                if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
                    $erro = "Tipo de arquivo não suportado.";
                } elseif ($_FILES["foto"]["size"] > 5000000) {
                    $erro = "Arquivo muito grande! Max: 5MB";
                } else {
                    $diretorioUpload = "recebidos.img";
                    $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
                    $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                        $stmt = $mysqli->prepare("INSERT INTO pi_2024_pedidos_sobremesa (nome, ingrediente, preco, foto, quantidade) VALUES (?, ?, ?, ?, ?)");
                        if ($stmt === false) {
                            // Exibir o erro, se necessário
                            $erro = "Erro na preparação da consulta: " . $mysqli->error;
                        } else {
                            $stmt->bind_param("sssss", $nome, $tipo, $preco, $caminhoFinal, $quantidade);
                            if ($stmt->execute()) {
                                $sucesso = "Bebida cadastrada com sucesso!";
                            } else {
                                $erro = "Erro ao cadastrar a bebida. Tente novamente.";
                            }
                            $stmt->close();
                        }

                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Sobremesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php"); ?>
    <header>
        <h1>Cadastrar Sobremesas</h1>
    </header>

    <div class="mt-3 d-flex justify-content-center">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title">Sobremesa</p>

            <?php if (isset($erro)): ?>
                <div class="alert alert-danger"><?php echo $erro; ?></div>
            <?php elseif (isset($sucesso)): ?>
                <div class="alert alert-success"><?php echo $sucesso; ?></div>
            <?php endif; ?>

            <label>
                <input required type="text" class="input" name="nome">
                <span>Nome da Sobremesa</span>
            </label>

            <label>
                <input required type="text" class="input" name="ingrediente">
                <span>ingrediente</span>
            </label>

            <label>
                <input required type="number" step="0.01" class="input" name="preco">
                <span>Preço</span>
            </label>

            <label>
                <input required type="number" class="input" name="quantidade">
                <span>Quantidade</span>
            </label>

            <label>
                <span>Foto: </span>
                <input required type="file" class="form-control" name="foto">
            </label>

            <img id="imagePreview" src="#" alt="Sua imagem" style="display:none; width: 200px;" />

            <button class="submit btn btn-primary">Cadastrar</button>
            <a class="btn btn-primary d-flex justify-content-center" href="area_funcionarios.php">Voltar</a>
        </form>
    </div>

    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <br><br><br><br><br><br><br>
    <?php include("rodape.php"); ?>
</body>

</html>