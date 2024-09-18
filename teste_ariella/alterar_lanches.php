<?php 

  require ("conexao.php");  


  if(isset($_GET["id_alterar"])){  
    
    $id_alterar = $_GET["id_alterar"];
      $stmt = $mysqli->prepare("SELECT * FROM lanches WHERE id_lanches = ?");
      $stmt->bind_param("i", $id_alterar);
      $stmt->execute();
      $result = $stmt->get_result(); // Obter o objeto de resultado
      $row = $result->fetch_assoc();  
      

    if(isset($_POST["nome"])){  
      $nome = $_POST["nome"];
      $ingredientes = $_POST["ingredientes"];
      $preco = $_POST["preco"];
      $foto = $_FILES["foto"];

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
        $diretorioUpload = "recebidos/";
        $novoNomeArquivo = uniqid() . "." . $extensaoArquivo;
        $caminhoFinal = $diretorioUpload . $novoNomeArquivo;

        // Tente mover o arquivo temporário para o diretório final
        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoFinal)) {
            die("Ocorreu um erro ao fazer o upload da imagem.");
        
          
        
          }
      }

         // Atualizando os dados no banco de dados
         $sql_alterar = "UPDATE lanches SET nome = '$nome', ingredientes = '$ingredientes', preco = '$preco', foto = '$caminhoFinal'";
         $mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);
         
         header("Location:lista_lanches.php");
 

      
                    
       
    }

  }else{
    die("não tem id get");
  }

  //}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar lanche</title>
  <link rel="stylesheet" href="ariella.css">
</head>

<body>
  <!DOCTYPE html>
  <html lang="pt-br">

  <head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar lanches</title>

    <!-- Importando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
    <link rel="stylesheet" href="ariela.css">
 
  </head>
  <body>
  <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
            <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
                <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img-responsive"></a>
            </div>
        </div>
    
    <div class="conteiner d-flex justify-content ">
    
    <form class="form" method="post" enctype="multipart/form-data">
        <p class="title">Alterar Lanche</p>
        <p class="message">Altere os dados dos lanches de acordo com o seu objetivo .</p>

        <label>
          <input required="" placeholder="" type="text" class="input" value="<?php echo $row["nome"]?>" name="nome">
          <span>Nome:</span>
        </label>

        <label>
          <input required="" placeholder="" type="text" class="input" value="<?php echo $row["ingredientes"]?>" name="ingredientes">
          <span>Ingredientes:</span>
        </label>

        <label>
          <input required="" placeholder="" type="text" class="input"
            value="<?php echo $row["preco"]?>"
            name="preco">
          <span>Preço:</span>
        </label>

        <label>
          <input placeholder="" type="file" class="" value="<?php echo $row["preco"] ?>" name="foto">
          <span>Foto:</span>
        </label>
        <button class="submit">Entrar</button>
    </form>
    </div>

    <footer>
    <div class="footer-links">
        <a href="#sobre">Sobre Nós</a>
    </div>
    <div class="social-icons">
    </div>
    <p>&copy; 2024 Sua Empresa. Todos os direitos reservados.</p>
    </footer>

</body>
</html>