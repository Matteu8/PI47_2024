<?php
include("conexao.php");


// Depois, se um ID foi passado via GET, busque os detalhes desse médico para exibição
if (isset($_GET['id_alterar'])) {
    $id_sobremesa = $_GET['id_alterar'];
    $sql_consultar = "SELECT * FROM sobremesa WHERE id_sobremesa= '$id_sobremesa' ";
    $mysqli_consultar = $mysqli->query($sql_consultar) or die($mysqli->error);
    $consultar = $mysqli_consultar->fetch_assoc();

    // Primeiro, verifique se o formulário foi enviado e, em caso afirmativo, processe a submissão
    if (isset($_POST['id_sobremesa'])) {
        $id_sobremesa = $_POST['id_sobremesa'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'] ?? '';
        $quantidade = intval($_POST['quantidade'] ?? 0);
        $caminho_banco = $consultar['imagem']; // Preserva o caminho da foto antiga

        

        if (isset($_FILES['bt_imagem']) && $_FILES['bt_imagem']['error'] === 0) {
            $arquivo = $_FILES['bt_imagem'];
            
            // Limite de tamanho do arquivo
            if ($arquivo['size'] > 15000000) {
                die("Arquivo muito grande!! Max: 15MB");
            }

            $pasta = "recebidos.img/";
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
        if (isset($_GET['status']) && $_GET['status'] == 'success') {
            echo "<p>Sobremesa atualizada com sucesso!</p>";
        }
        
        // Atualizando os dados no banco de dados
        $sql_alterar = "UPDATE sobremesa SET nome = '$nome', preco = '$preco', quantidade = '$quantidade', imagem = '$caminho_banco' WHERE id_sobremesa = '$id_sobremesa'";
        $mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);
       
        header ("location:consulta_sobremesa.php");
    }
}else{
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
    <link rel="stylesheet" href="gabriell.css">
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
<div class="d-flex justify-content-center">
        <form class="form" method="post" enctype="multipart/form-data">
            <p class="title">Alterar Lanche</p>
            <label>
            <input type="hidden" name="id_sobremesa" value="<?php echo htmlspecialchars($consultar['id_sobremesa']); ?>">
            </label>

            <label>
            <input class="form-control" type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($consultar['nome']); ?>" required>
                <span>Nome:</span>
            </label>

            <label>
            <input class="form-control" type="text" id="preco" name="preco" value="<?php echo htmlspecialchars($consultar['preco']); ?>" required>
                <span>Ingredientes:</span>
            </label>

            <label>
            <input class="form-control" type="number" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($consultar['quantidade']); ?>" required>
                <span>Quantidade:</span>
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
    <div class="container mt-4">
        <form action="" method="post" enctype="multipart/form-data">
            <h1 class="text-center">Alterar - Sobremesa</h1>
            
            <input type="hidden" name="id_sobremesa" value="<?php echo htmlspecialchars($consultar['id_sobremesa']); ?>">
            
            <div class="mb-3">
                <label class="form-label" for="nome">Nome</label>
                <input class="form-control" type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($consultar['nome']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="preco">Preço</label>
                <input class="form-control" type="text" id="preco" name="preco" value="<?php echo htmlspecialchars($consultar['preco']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="quantidade">Quantidade</label>
                <input class="form-control" type="number" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($consultar['quantidade']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="bt_imagem">Foto</label>
                <input class="form-control" type="file" id="bt_imagem" name="bt_imagem">
            </div>

            <?php if (empty($consultar['imagem'])) : ?>
                <div class="mt-3 text-center">
                    <img src="<?php echo htmlspecialchars($consultar['imagem']); ?>" alt="imagem da sobremesa" class="img-thumbnail">
                </div>
            <?php endif; ?>

            <div class="mt-3 d-flex justify-content-between">
                <input class="btn btn-success" type="submit" value="Alterar">
                <a class="btn btn-primary" href="consulta_sobremesa.php">Voltar</a>
                
            </div>
        </form>
    </div>

    <!-- Inclua o JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
