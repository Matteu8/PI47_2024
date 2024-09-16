<?php 

  require ("conexao.php");

  if(isset($_SESSION["id_adm"])){
    if(isset($_GET["id_alterar"])){
      if(isset($_POST["nome"])){      
        $nome = $_POST["nome"];
        $ingredientes = $_POST["ingredientes"];
        $preco = $_POST["preco"];
        $foto = $_FILES["foto"];
        
        
        $sql_consultar = "SELECT * FROM lanches ";
        $mysqli_consultar = $mysqli->query($sql_consultar) or die($mysqli->error);
        $consultar = $mysqli_consultar->fetch_assoc();
  
        
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
          $sql_alterar = "UPDATE lanches SET nome = '$nome', ingredientes = '$ingredientes', preco = '$preco', foto = '$foto'";
          $mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);
          header("Location:");
  
          $mysqli->query("INSERT INTO lanches (nome, ingredientes, preco, foto) values('$nome','$ingredientes', '$preco','$caminhoFinal')") or
                      die($mysqlierrno);
      }

    }

  }else{
    die("Ação não permitida");
  }

 

    
  


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



  <link rel="stylesheet" href="ariella.css">
</head>

<body>
<div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
            <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
                <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
            </div>
        </div>
<div class="conteiner d-flex justify-content-center mt-5">
    <form class="form" method="post" enctype="multipart/form-data">
      <p class="title">Alterar Lanche</p>
      <p class="message">Altere os dados dos lanches de acordo com o seu objetivo .</p>
      
      <label>
        <input required="" placeholder="" type="text" class="input" value="<?php echo ($consultar['nome']); ?>" name="nome">
        <span>Nome:</span>                                                  
      </label>

      <label>
        <input required="" placeholder="" type="text" class="input"  value="<?php echo ($consultar['ingredientes']); ?>" name="ingredientes" >
        <span>Ingredientes:</span>
      </label>
  
      <label>                                                               
        <input required="" placeholder="" type="text" class="input" value="<?php echo ($consultar['preco']); ?>" name="preco">
        <span>Preço:</span>
      </label>

      <label>
        <input required="" placeholder="" type="file" class="" value="<?php echo ($consultar['foto']); ?>" name="foto">
        <span>Foto:</span>
      </label>

      <button class="submit">Entrar</button>
      
    </form>
  </div>
  <footer>
            
            </div>
            <div class="social-icons">
                <a href="Srobre Nós">Sobre Nós</a>
            </div>
            <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
        </footer>
</body>

</html>
</body>
</html>