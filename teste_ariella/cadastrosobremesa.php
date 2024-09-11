<?php
    include("conexao.php");

    if(!isset($_SESSION)){
        session_start();
    }

    

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['bt_nome'] ?? '';
    $preco = $_POST['bt_preco'] ?? '';
    $quantidade = intval($_POST['bt_quantidade'] ?? 0);


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

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    header {
        background-color: #f7941d;
        color: #fff;
        padding: 10px 0;
        text-align: center;
    }
    h1 {
        margin: 0;
    }
    .product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .product {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 15px;
        flex: 1 1 calc(33.333% - 20px);
        box-sizing: border-box;
        text-align: center;
    }
    .product img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }
    .product h2 {
        margin: 10px 0;
        font-size: 1.5em;
    }
    .product p {
        font-size: 1em;
        color: #666;
    }
    .product .price {
        font-size: 1.2em;
        color: #333;
        margin-top: 10px;
    }
    footer {
        background-color: #3a6da1;
        color: #fff;
        text-align: center;
        padding: 10px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
    }
</style>    

<body>
    <header>
        <h1>Formulário de sobremesa</h1>
    </header>
   
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="bt_nome" required >

            <label for="preco">preço</label>
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