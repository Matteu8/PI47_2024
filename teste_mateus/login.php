<?php
include "conexao.php";

if (!isset($_SESSION)) {
  session_start();
}
if (isset($_SESSION["nome"])) {
  header("Location:area_cliente.php");
}

if (isset($_POST["senha"])) {
  $email = $_POST["email"];
  $senha = $_POST["senha"];
  $tipo_usuario = $_POST["tipo_usuario"];

  if ($tipo_usuario == 'cliente') {
    $tabela = 'clientes';
    
  } elseif ($tipo_usuario == 'funcionario') {
    $tabela = 'funcionarios';
   
  } else {
    echo ("<script> alert('Tipo de usuário inválido')</script>");
    exit;
  }

  $stmt = $mysqli->prepare("SELECT * FROM $tabela WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $usuario = $resultado->fetch_assoc();


  if ($usuario && password_verify($senha, $usuario['senha'])) {
   

    if ($tipo_usuario == 'cliente') {
      $_SESSION["id_cliente"] = $usuario['id_clientes'];
      $_SESSION["nome"] = $usuario['nome'];
      $_SESSION["curso"] = $usuario['curso'];
      $_SESSION["periodo"] = $usuario['periodo'];
      $_SESSION["telefone"] = $usuario['telefone'];
      $_SESSION["email"] = $usuario['email'];
      $_SESSION["senha"] = $usuario['senha'];
      
      header("Location:area_cliente.php");
    } elseif ($tipo_usuario == 'funcionario') {
      $_SESSION["id_cliente"] = $usuario['id_clientes'];
      $_SESSION["nome"] = $usuario['nome'];
      $_SESSION["curso"] = $usuario['curso'];
      $_SESSION["periodo"] = $usuario['periodo'];
      $_SESSION["telefone"] = $usuario['telefone'];
      $_SESSION["email"] = $usuario['email'];
      $_SESSION["senha"] = $usuario['senha'];
      header("Location:area_funcionarios.php"); 
    }
  } else {
    echo ("<script> alert('Erro de senha ou Tipo de Usuário')</script>");
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="ariella.css">
</head>

<body>
  <div class="row visible-md visible-lg" style="background-color:#3a6da1;">
    <div class="col-md-5" style="background-color:#3a6da1;">
      <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
    </div>
  </div>
  <div class="container d-flex justify-content-center mt-5">
    <form class="form" method="post">
      <p class="title">Login</p>
      <p class="message">Faça o login agora e tenha acesso total ao nosso aplicativo.</p>
      <label>
        <input required placeholder="" type="email" class="input" name="email">
        <span>Email:</span>
      </label>
      <label>
        <input required placeholder="" type="password" class="input" name="senha">
        <span>Senha:</span>
      </label>
      <select required class="form-select" name="tipo_usuario" aria-label="Default select example">
        <option selected>Entrar como</option>
        <option value="cliente">Cliente</option>
        <option value="funcionario">Funcionário</option>
      </select>
      <button class="submit" type="submit">Entrar</button>
      <p class="signin"> Não tem uma conta? <a href="cadastro_cliente.php">Cadastre-se</a></p>
    </form>
  </div>
  <footer>
    <div class="social-icons">
      <a href="Sobre Nós">Sobre Nós</a>
    </div>
    <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
  </footer>
</body>

</html>