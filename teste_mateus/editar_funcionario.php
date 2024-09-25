<?php
include("conexao.php");

// Depois, se um ID foi passado via GET, busque os detalhes desse médico para exibição
if (isset($_GET['id_funcionarios'])) {
    $id_funcionarios = $_GET['id_funcionarios'];
    $sql_consultar = "SELECT * FROM funcionarios WHERE id_funcionarios= '$id_funcionarios'";
    $mysqli_consultar = $mysqli->query($sql_consultar) or die($mysqli->error);
    $consultar = $mysqli_consultar->fetch_assoc();
    
    // Primeiro, verifique se o formulário foi enviado e, em caso afirmativo, processe a submissão
    if (isset($_POST['id_funcionarios'])) {
        $id_funcionarios = $_POST['id_funcionarios'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Atualizando os dados no banco de dados
        $sql_alterar = "UPDATE funcionarios SET nome = '$nome', email = '$email', senha = '$senha' WHERE id_funcionarios = '$id_funcionarios'";
        $mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);
        header("");
    }
    
}
?>

<!DOCTYPE html> 
 <!-- Página provavelmente não vai ser usada  -->
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionario</title>

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
            <h1>Editar funcionarios</h1>
        </header>
    


        <div class="container mt-5 d-flex justify-content-center">
     

    

    <form class="form" method="post">
        <p class="title">Editar Funcionario</p>
            
            <label>
                <input required="" placeholder="" type="text" class="input" name="nome">
                <span>Nome</span>
            </label>
           
         
                
        <label>
            <input required="" placeholder="" type="email" class="input" name="email">
            <span>Email</span>
        </label> 
            
        <label>
            <input required="" placeholder="" type="password" class="input" name="senha">
            <span>Senha</span>
        </label>
        
        <button class="submit">Concluir e Editar</button>
        
    </form>

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
 
         
</body>

</body>
</html>