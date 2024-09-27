<?php 
require("conexao.php");  

if (isset($_GET["id_alterar"])) {  
    $id_alterar = $_GET["id_alterar"];
    
    // Busca os dados atuais
    $stmt = $mysqli->prepare("SELECT * FROM sobremesa WHERE id_sobremesas = ?");
    $stmt->bind_param("i", $id_alterar);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (isset($_POST["nome"])) {  
        $nome = $_POST["nome"];
        $ingredientes = $_POST["ingredientes"];
        $preco = $_POST["preco"];
        $caminhoFinal = $_FILES["foto"]; // Mantém o valor atual da foto

        if (isset($_FILES["imagem"]) && $_FILES["foto"]["error"] === 0) {
            // Verifica se o arquivo é uma imagem
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check === false) {
                die("O arquivo não é uma imagem.");
            }

            // Verifica a extensão do arquivo
            $extensoesPermitidas = ['jpeg', 'jpg', 'png', 'gif' , 'jfif'];
            $extensaoArquivo = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
            if (!in_array($extensaoArquivo, $extensoesPermitidas)) {
                die("Tipo de arquivo não suportado.");
            }

            // Verifica o tamanho do arquivo
            if ($_FILES["foto"]["size"] > 5000000) {
                die("Arquivo muito grande!! Max: 5MB");
            }

            // Define o local para salvar a imagem
            $diretorioUpload = "Lanches/img";
            $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
            $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

            // Move o arquivo temporário para o diretório final
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
                die("Ocorreu um erro ao fazer o upload da imagem.");
            }
        }

        // Atualiza os dados no banco de dados
        $stmt = $mysqli->prepare("UPDATE sobremesa SET nome = ?, ingredientes = ?, preco = ?, foto = ? WHERE id_sobremesas = ?");
        $stmt->bind_param("sssii", $nome,$ingredientes, $preco, $caminhoFinal, $id_alterar);
        
        if ($stmt->execute()) {
            header("Location: consulta_sobremesa.php");
            exit();
        } else {
            die("Erro ao atualizar: " . $stmt->error);
        }

        $stmt->close();
    }
} else {
    die("ID não encontrado na URL.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Bebidas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="ariella.css">

</head>
<body>
 <!-- ####################################################################################### -->
 <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
            <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
                <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
            </div>
        </div>
        
        <header>
            <h1>Alterar Sobrimesas</h1>
        </header>
    

        <div class=" mt-5 d-flex justify-content-center">
     

   
        
    <form class="form" method="post" enctype="multipart/form-data">
        <p class="title">Alterar Sobrimesas </p>
            <div class="flex">
            <label>
                <input required="" placeholder="" type="text" class="input"name="bt_nome">
                <span>Nome </span>
            </label>
           
        </div>  
                
        <label>
            <input required="" placeholder="" type="text" class="input" name="bt_ingredientes">
            <span>Ingredientes</span>
        </label> 
        
        <label>
            <input required="" placeholder="" type="text" class="input" name="bt_ingredientes">
            <span>Quantidades</span>
        </label> 
       
        <label>
            <input required="" placeholder="" type="text" class="input" name="bt_preco">
            <span>Preço</span>
        </label>
        <label>
            <input required="" placeholder="" type="file"  name="foto">
            <span>Foto</span>
        </label>

       <!-- <label for="">Foto:</label>
        <input class="form-control" type="file" name="foto" ><!-->
        <label>
          
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