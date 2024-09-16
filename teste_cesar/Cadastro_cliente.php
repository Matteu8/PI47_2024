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
            $extensoesPermitidas = array('jpeg', 'jpg', 'png', 'gif', 'jfif' );
            $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
            if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
                die("Tipo de arquivo não suportado.");
            }
    
            // Verifique o tamanho do arquivo (por exemplo, limite de 5MB aqui)
            if ($_FILES["foto"]["size"] > 5000000) {
                die("Arquivo muito grande!! Max: 5MB");
            }
    
            // Defina o local para salvar a imagem
            $diretorioUpload = "Bebidas/img/";
            $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
            $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

         
            
            // Tente mover o arquivo temporário para o diretório final
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                die("Ocorreu um erro ao fazer o upload da imagem.");
            }
            
            $mysqli->query("INSERT INTO bebidas (nome, ingredientes, preco, foto) values('$nome','$ingredientes', '$preco','$caminhoFinal')") or
                    die($mysqlierrno);
           
        } 
        
                    
    }

?>










<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="gabriell.css">

</head>
<body>
 <!-- ####################################################################################### -->
 <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
            <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
                <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
            </div>
        </div>
        
        <header>
            <h1>Cadastro de Cliente</h1>
        </header>
    

        <div class="container mt-5 d-flex justify-content-center">
     

   
        
    <form class="form" method="post" enctype="multipart/form-data">
        <p class="title">Cadastrar </p>
            <div class="flex">
            <label>
                <input required="" placeholder="" type="text" class="input"name="bt_nome">
                <span>Nome:</span>
            </label>
           
        </div>  
                
        <label>
            <input required="" placeholder="" type="text" class="input" name="bt_ingredientes">
            <span>Curso:</span>
        </label> 
            
        <label>
            <input required="" placeholder="" type="text" class="input" name="bt_preco">
            <span>Período:</span>
        </label>
        

    
          
        </label>
        <button class="submit">Cadastrar</button>
        
    </form>
</div>
    </div>
  </nav>
   <h1></h1> 
   <h1></h1> 
   <h1></h1> 
   <h1></h1> 
  <footer>
    <div class="footer-links">
        <a href="#sobre">Sobre Nós</a>
        
    </div>
    <div class="social-icons">
  
    </div>
    <p>&copy; 2024 Sua Empresa. Todos os direitos reservados.</p>
</footer>
<?php 
        
        ?>
</body>

</body>
</html>