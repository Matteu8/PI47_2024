<?php 
    require("conexao.php");

    if(isset($_POST["bt_nome"])){
        $nome = $_POST["bt_nome"];
        $ingredientes = $_POST["bt_ingredientes"];
        $preco = $_POST["bt_preco"];
        $foto = $_POST["foto"];
        $mysqlierrno = "erro";
        
        $mysqli->query("INSERT INTO lanches (nome, ingredientes, preco, foto) values('$nome','$ingredientes', '$preco','$foto')") or
                    die($mysqlierrno);

        /* colocar o name * aqui está como foto */
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {

            // Verifique se o arquivo é uma imagem
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check === false) {
                die("O arquivo não é uma imagem.");
            }
    
            // Verifique a extensão do arquivo
            $extensoesPermitidas = array('jpeg', 'jpg', 'png', 'gif');
            $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
            if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
                die("Tipo de arquivo não suportado.");
            }
    
            // Verifique o tamanho do arquivo (por exemplo, limite de 5MB aqui)
            if ($_FILES["foto"]["size"] > 5000000) {
                die("Arquivo muito grande!! Max: 5MB");
            }
    
            // Defina o local para salvar a imagem
            $diretorioUpload = "PI47_2024/lanches/img/";
            $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
            $caminhoFinal = $diretorioUpload . $novoNomeArquivo;
    
       
    
            // Tente mover o arquivo temporário para o diretório final
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                die("Ocorreu um erro ao fazer o upload da imagem.");
            }
    
            // Atualize o caminho da imagem no banco de dados
            $stmt = $mysqli->prepare("UPDATE pi_2023_sus_pessoas SET camimg = ? WHERE id_pessoa = ?");
            $stmt->bind_param("ss", $caminhoFinal, $id);
            if (!$stmt->execute()) {
                die("Erro ao atualizar o caminho da imagem no banco de dados.");
            }
            if(isset($_FILES)){
                var_dump($_FILES);
            }
        }        
            
                    
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro de Lanches</title>
</head>
<body>
    <!-- ####################################################################################### -->
    <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
        <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
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
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Cadastro de Lanches</h1>
    </header>
    
    <div class="container">
        <form action="" method="post">

            <label for="">Nome do Lanche:</label>
            <input class="form-control"  type="text" name="bt_nome">
                <br>
                <br>
            <label for="">Ingredientes:</label>
            <input class="form-control" type="text" name="bt_ingredientes">
                <br>
                <br>
            <label for="">Preço:</label>
            <input class="form-control" type="text" name="bt_preco" >
                <br>
                <br>
            <label for="">Foto:</label>
            <input class="form-control" type="file" name="foto" >
                <br>
                <br>
            <input class="btn btn-success "  type="submit" value="Cadastrar">
            
            <input class="btn btn-danger " type="reset" value="Voltar">
            

        </form>
        <?php 
        
        ?>
</body>
</html>


