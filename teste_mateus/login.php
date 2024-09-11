<?php
include "conexao.php";

if(!isset($_SESSION)){
  session_start();
}
if(isset($_SESSION["nome"])){
  header("Location:test.php");
}

if (isset($_POST["senha"])) {
  $email = $_POST["email"];
  $senha = $_POST["senha"];

  $sql = "SELECT * FROM clientes WHERE email =  '$email'";

  $sql_exec = $mysqli->query($sql) or die($mysqli->error);
  $usuario = $sql_exec->fetch_assoc();

  if (password_verify($senha, $usuario['senha'])) {


    $_SESSION["id_cliente"] = $usuario['id_cliente'];
    $_SESSION["nome"] = $usuario['nome'];
    $_SESSION["curso"] = $usuario['curso'];
    $_SESSION["periodo"] = $usuario['periodo'];
    $_SESSION["telefone"] = $usuario['telefone'];
    $_SESSION["email"] = $usuario['email'];
    $_SESSION["senha"] = $usuario['senha'];


    header("Location:test.php");
  } else {
    echo ("<script> alert('Erro de senha')</script>");
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <!-- Importando Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>



  <link rel="stylesheet" href="ariella.css">
</head>

<body>
  <div class="row visible-md visible-lg" style="background-color:#3a6da1;">
    <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
      <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
    </div>
  </div>
  <div class="conteiner d-flex justify-content-center mt-5">
    <form class="form" method="post">
      <p class="title">Login </p>
      <p class="message">Faça o login agora e tenha acesso total ao nosso aplicativo. </p>
      <label>
        <input required="" placeholder="" type="email" class="input" name="email">
        <span>Email:</span>
      </label>

      <label>
        <input required="" placeholder="" type="password" class="input" name="senha">
        <span>Senha:</span>
      </label>

      <button class="submit" type="submit">Entrar</button>
      <p class="signin"> Não tem uma conta ? <a href="cadastro_cliente.php">Cadastre-se</p>
    </form>
  </div>
  <footer>

    </div>
    <div class="social-icons">
      <a href="Sobre Nós">Sobre Nós</a>
    </div>
    <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
  </footer>
</body>

</html>