<?php
include("conexao.php");
require("protecao.php");

if ($_SESSION['tipo_usuario'] == 'funcionario') {
    $voltar_url = "area_funcionarios.php";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $mysqli->real_escape_string($_POST["bt_nome"]);
    $ingredientes = $mysqli->real_escape_string($_POST["bt_ingredientes"]);
    $preco = $mysqli->real_escape_string($_POST["bt_preco"]);
    $quantidade = $mysqli->real_escape_string($_POST["bt_quantidade"]);

    if (empty($nome) || empty($ingredientes) || empty($preco)) {
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
                    $erro = "Arquivo muito grande!! Max: 5MB";
                } else {
                    $diretorioUpload = "Lanches/img/";
                    $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
                    $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                        $stmt = $mysqli->prepare("INSERT INTO lanches (nome, ingredientes, preco, foto, quantidade) VALUES (?, ?, ?,?, ?)");
                        $stmt->bind_param("sssss", $nome, $ingredientes, $preco, $caminhoFinal, $quantidade);
                        if ($stmt->execute()) {
                            $sucesso = "Lanche cadastrado com sucesso!";
                        } else {
                            $erro = "Erro ao cadastrar o lanche. Tente novamente.";
                        }
                        $stmt->close();
                    } else {
                        $erro = "Ocorreu um erro ao fazer o upload da imagem.";
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
    <title>Cadastro de Lanches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>

<body>
    <?php include("menu.php"); ?>
    <header>
        <h1>Cadastro de Lanches</h1>
    </header>

    <div class="mt-5 d-flex justify-content-center">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title">Lanches</p>

            <?php if (isset($erro)): ?>
                <div class="alert alert-danger"><?php echo $erro; ?></div>
            <?php elseif (isset($sucesso)): ?>
                <div class="alert alert-success"><?php echo $sucesso; ?></div>
            <?php endif; ?>

            <label>
                <input required type="text" class="input" name="bt_nome">
                <span>Nome do Lanche</span>
            </label>

            <label>
                <input required type="text" class="input" name="bt_ingredientes">
                <span>Ingredientes</span>
            </label>

            <label>
                <input required type="number" step="0.01" class="input" name="bt_preco">
                <span>Preço</span>
            </label>

            <label>
                <input required type="text" class="input" name="bt_quantidade">
                <span>Quantidade</span>
            </label>

            <label>
                <span>Foto: </span>
                <input required type="file" class="form-control" name="foto">

            </label>

            <img id="imagePreview" src="#" alt="Sua imagem" style="display:none; width: 200px;" />

            <button class="submit btn btn-primary mt-3">Cadastrar</button>
            <input class="btn btn-danger" type="reset" value="Redefinir">
            <div class="container text-center mb-5">
                <button class="btn btn-primary">
                    <a href="<?php echo isset($voltar_url) ? $voltar_url : 'login.php'; ?>"
                        style="text-decoration: none; color: white;">Voltar</a>
                </button>
            </div>
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

</body>

</html>