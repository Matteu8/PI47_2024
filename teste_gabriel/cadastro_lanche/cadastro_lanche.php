<?php 
    require("conexao.php");

    if(isset($_POST["bt_nome"])){
        $nome = $_POST["bt_nome"];
        $ingredientes = $_POST["bt_ingredientes"];
        $preco = $_POST["bt_preco"];
       
        $mysqlierrno = "erro";
        
        
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
            $diretorioUpload = "Lanches/img/";
            $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
            $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

         
            
            // Tente mover o arquivo temporário para o diretório final
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                die("Ocorreu um erro ao fazer o upload da imagem.");
            }
            
            $mysqli->query("INSERT INTO lanches (nome, ingredientes, preco, foto) values('$nome','$ingredientes', '$preco','$caminhoFinal')") or
                    die($mysqlierrno);
           
        } 
        
                    
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro de Lanches</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="gabriell.css">

    
</head>

    <!-- ####################################################################################### -->
    <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
        <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
        </div>
    </div>
   
    

</head>
<body>
    <header>
        <h1>Cadastro de Lanches</h1>
    </header>
    
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data"> <!--para permitir o envio de arquivos. -->

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


