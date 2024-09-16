<?php
    include("conexao.php");

    if(!isset($_SESSION)){
        session_start();
    }

    

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['bt_nome'] ?? '';
    $preco = $_POST['bt_preco'] ?? '';
    $quantidade = intval(  $_POST['bt_quantidade'] ?? 0);


    if (isset($_FILES['bt_imagem'])) {
        $arquivo = $_FILES['bt_imagem'];
        if ($arquivo['size'] > 15000000) {
            die("Arquivo muito grande!! Max: 15MB");
        }
        if ($arquivo['error']) {
            die("Falha ao enviar arquivo");
        }

        $pasta = "recebidos.img/";
        $nome_arquivo = $arquivo['name'];
        $novo_nome_arquivo = uniqid();
        $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
        $caminho_banco = $pasta . $novo_nome_arquivo . "." . $extensao;

        $deucerto = move_uploaded_file($arquivo["tmp_name"], $caminho_banco);
    }

    // Preparar a instrução SQL
    $stmt = $mysqli->prepare("INSERT INTO sobremesa (nome, preco, quantidade, imagem) VALUES (?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Erro ao preparar a instrução SQL: " . $mysqli->error);
    }
    
    $stmt->bind_param("ssis", $nome, $preco, $quantidade, $caminho_banco);

    if ($stmt->execute()) {
        echo "<script>Swal.fire('Success', 'Cadastro realizado com sucesso!', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error', 'Erro ao cadastrar: " . $stmt->error . "', 'error');</script>";
    }

    $stmt->close();
}


?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de sobremesa</title>
    <nav class="navbar fixed-top bg-body-tertiary">
        <div class="container-fluid">
        <link rel="stylesheet" href="ariella.css">
        </div>
      </nav>
</head>
<body>
   <!-- ####################################################################################### -->
   <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
    <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
        <a href="/principal/"><img src="topo_site_bl1_2018.png" class="img img-responsive"></a>
    </div>
</div>

<body>
    <header>
        <h1>Formulário de sobremesa</h1>
    </header>
   
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="bt_nome" required >

            <label for="preco">Preço</label>
            <input type="preco" id="preco" name="bt_preco" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="bt_quantidade" min="1" required>

            <label class="form-label" for="bt_imagem">Imagem</label>
            <input class="form-control" type="file" name="bt_imagem">

            <button type="submit">Enviar</button>
        </form>
    </div>
<footer>
    <div class="footer-links">
        <a href="#sobre">Sobre Nós</a>
            
    </div>
    <div class="social-icons">
            
    </div>
    <p>© Direitos reservados - Turma de programação web t202400047 Senac PR 2024.</p>
</footer>
    


</body>
</html>