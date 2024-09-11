<?php 

  require ("conexao.php");

    if(isset($_POST["nome"])){      
      $nome = $_POST["nome"];
      $ingredientes = $_POST["ingredientes"];
      $preco = $_POST["preco"];

      $sql_consultar = "SELECT * FROM lanches WHERE id_lanches= '$id_lanches'";
      $mysqli_consultar = $mysqli->query($sql_consultar) or die($mysqli->error);
      $consultar = $mysqli_consultar->fetch_assoc();
  

      if (isset($_FILES['foto']) && $_FILES['bt_foto']['error'] === 0) {
      $arquivo = $_FILES['foto'];
      
      // Limite de tamanho do arquivo
      if ($arquivo['size'] > 15000000) {
          die("Arquivo muito grande!! Max: 15MB");
      }

      $pasta = "recebidos/";
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
          // Atualizando os dados no banco de dados
        $sql_alterar = "UPDATE lanches SET nome = '$nome', ingredientes = '$ingredientes' preco = '$preco' foto = '$foto' WHERE id_lanches = '$id_lanches'";
        $mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);
        header("Location:");
    }  
  }


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delelar lanche</title>
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
        <input required="" placeholder="" type="email" class="input" name="nome">
        <span>Nome:</span>
      </label>

      <label>
        <input required="" placeholder="" type="email" class="input" name="ingredientes">
        <span>Ingredientes:</span>
      </label>
      
      <label>
        <input required="" placeholder="" type="email" class="input" name="preco">
        <span>Preço:</span>
      </label>

      <label>
        <input required="" placeholder="" type="file" class="" name="foto">
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