<?php 

require("conexao.php");  

if (isset($_GET["id_alterar"])) {  
    $id_alterar = $_GET["id_alterar"];
    $stmt = $mysqli->prepare("SELECT * FROM lanches WHERE id_lanches = ?");
    $stmt->bind_param("i", $id_alterar);
    $stmt->execute();
    $result = $stmt->get_result(); // Obter o objeto de resultado
    $row = $result->fetch_assoc();  

    if (isset($_POST["nome"])) {  
        $nome = $_POST["nome"];
        $tipo = $_POST["tipo"];
        $preco = $_POST["preco"];
        $quantidade = $_POST["quantidade"];
        $foto = $_FILES["foto"];
        $caminhoFinal = null; // Variável para o caminho da foto

        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            // Verifique se o arquivo é uma imagem
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check === false) {
                die("O arquivo não é uma imagem.");
            }

            // Verifique a extensão do arquivo
            $extensoesPermitidas = ['jpeg', 'jpg', 'png', 'gif'];
            $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
            if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
                die("Tipo de arquivo não suportado.");
            }

            // Verifique o tamanho do arquivo (por exemplo, limite de 5MB aqui)
            if ($_FILES["foto"]["size"] > 5000000) {
                die("Arquivo muito grande!! Max: 5MB");
            }

            // Defina o local para salvar a imagem
            $diretorioUpload = "recebidos/";
            $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
            $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

            // Tente mover o arquivo temporário para o diretório final
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                die("Ocorreu um erro ao fazer o upload da imagem.");
            }
        } else {
            // Se não houve upload de nova imagem, mantém a foto existente
            $caminhoFinal = $row['foto'];
        }

        // Atualizando os dados no banco de dados
        $stmt = $mysqli->prepare("UPDATE lanches SET nome = ?, tipo = ?, preco = ?, quantidade = ?, foto = ? WHERE id_lanches = ?");
        $stmt->bind_param("ssdssi", $nome, $tipo, $preco, $quantidade, $caminhoFinal, $id_alterar);
        $stmt->execute();

        header("Location: lista_lanches.php");
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
    <title>Alterar Lanche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="ariella.css">
</head>

<body>
    <div class="row visible-md visible-lg" style="background-color:#3a6da1;">
        <div class="col-md-5" style="background-color:#3a6da1;">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
        </div>
    </div>
    
    <div class="container d-flex justify-content-center mt-5">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title">Alterar Lanche</p>
            <p class="message">Altere os dados dos lanches de acordo com o seu objetivo.</p>

            <label>
                <input required type="text" class="input" value="<?php echo htmlspecialchars($row['nome']); ?>" name="nome">
                <span>Nome:</span>
            </label>

            <label>
                <input required type="text" class="input" value="<?php echo htmlspecialchars($row['tipo']); ?>" name="tipo">
                <span>Tipo:</span>
            </label>

            <label>
                <input required type="number" class="input" value="<?php echo htmlspecialchars($row['quantidade']); ?>" name="quantidade">
                <span>Quantidade:</span>
            </label>

            <label>
                <input required type="text" class="input" value="<?php echo htmlspecialchars($row['preco']); ?>" name="preco">
                <span>Preço:</span>
            </label>

            <label>
                <input type="file" class="" name="foto">
                <span>Foto:</span>
            </label>

            <button class="submit">Salvar Alterações</button>
        </form>
    </div>

    <footer>
        <div class="social-icons">
            <a href="#">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
