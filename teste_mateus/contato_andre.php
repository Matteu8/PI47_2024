<?php 

require("conexao.php");

if(isset($_POST["bt_nome"])){
    $mysqlierrno = "erro";
    $nome = $_POST["bt_nome"];
    $email = $_POST["bt_email"];
    $telefone = $_POST["bt_telefone"];
    $assunto = $_POST["bt_assunto"];
    $mensagem = $_POST["bt_mensagem"];
    /*$imagem = $_POST["#"];  FALTA ENSINAR MANDAR IMAGENS E ARQUIVOS PARA O BANCO DE DADOS*/
    
    $mysqli->query("INSERT INTO contato (nome, email, telefone, assunto, mensagem ) values('$nome', '$email', '$telefone', '$assunto', '$mensagem')") or
                die($mysqlierrno);
    
    
    
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de contato</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
      body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
      }
      footer {
          background-color: #333;
          color: #fff;
          text-align: center;
          padding: 20px;
          position: relative;
          bottom: 0;
          width: 100%;
      }
      footer a {
          color: #fff;
          text-decoration: none;
      }
      footer a:hover {
          text-decoration: underline;
      }
      .footer-links {
          margin: 10px 0;
      }
      .footer-links a {
          margin: 0 10px;
      }
      .social-icons {
          margin: 10px 0;
      }
      .social-icons a {
          margin: 0 5px;
      }
  </style>
</head>
<body>
 <!-- ####################################################################################### -->
 <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
            <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
                <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
            </div>
        </div>

<div class="container text-center">
        <h1>Pagina de contato</h1>
    </div>
    <div class="container">
        <form action="" method="post">

            <label for="">Nome:</label>
            <input class="form-control" type="text" name="bt_nome">
            <div class="mb-3">
                <label for="">Email:</label>
                <input class="form-control" type="text" name="bt_email">

                <label for="">Telefone:</label>
                <input class="form-control" type="text" name="bt_telefone">
            </div>

            <div class="mb-3">
                <label for="">Assunto:</label>
                <select class="form-select" id="assunto" name="bt_assunto">
                    <option value="Elogio">Elogio</option>
                    <option value="Reclamação">Reclamaçao</option>
                    <option value="Dúvida">Duvida</option>
                    <option value="Mensagem">Mensagem</option>
                   
                    
                </select>
            </div>
           
            
            <form class="d-flex" role="search">
            <label for="">Mensagem</label>

            <textarea class="form-control me-2"name="bt_mensagem" id=""></textarea>
          
          <input class="btn btn-success" type="submit"></input>
          
        </form>
      
      </div>
    </div>
  </nav>
   <h1></h1> 
   <h1></h1> 
   <h1></h1> 
   <h1></h1> 
   <?php
    if(isset($_POST["bt_name"])){
        
        echo "<div class='alert alert-success' role='alert'>
            A simple success alert—check it out!
        </div>";

    }
    

    ?>    
  <footer>
    <div class="footer-links">
        <a href="#sobre">Sobre Nós</a>
        
    </div>
    <div class="social-icons">
        
    </div>
    <p>&copy; 2024 Sua Empresa. Todos os direitos reservados.</p>
</footer>
 
         

</body>

</body>
</html>