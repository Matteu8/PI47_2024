<?php
include "conexao.php";

session_start();

if (isset($_SESSION["id_cliente"])) {
  header("Location: area_cliente.php");
  exit();
} elseif (isset($_SESSION["id_funcionario"])) {
  header("Location: area_funcionarios.php");
  exit();
}

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST["email"];
  $senha = $_POST["senha"];
  $tipo_usuario = $_POST["tipo_usuario"];

  if ($tipo_usuario == 'cliente') {
    $tabela = 'clientes';
  } elseif ($tipo_usuario == 'funcionario') {
    $tabela = 'funcionarios';
  } else {
    $erro = "Tipo de usuário inválido.";
  }

  if (empty($erro)) {
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

        header("Location: area_cliente.php");
        exit();

      } elseif ($tipo_usuario == 'funcionario') {
        $_SESSION["id_funcionario"] = $usuario['id_funcionario'];
        $_SESSION["nome"] = $usuario['nome'];
        $_SESSION["email"] = $usuario['email'];
        $_SESSION["senha"] = $usuario['senha'];

        header("Location: area_funcionarios.php");
        exit();
      }
    } else {
      $erro = "Email/Senha ou Tipo de Usuário incorreto.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="gabriell.css">
</head>

<body>
  <div class="row" style="background-color:#3a6da1;">
    <div class="col-md-12">
      <a href="">
        <img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Logo">
      </a>
    </div>
  </div>

  <div class="container d-flex justify-content-center mt-5">
    <form class="form" method="post">
      <p class="title">Login</p>
      <p class="message">Faça o login agora e tenha acesso total ao nosso aplicativo.</p>
      <label>
        <input required placeholder="" type="email" class="input form-control" name="email">
        <span>Email:</span>
      </label>
      <label>
        <input required placeholder="" type="password" class="input form-control" name="senha">
        <span>Senha:</span>
      </label>
      <?php if (!empty($erro)): ?>
        <div class='alert alert-danger mt-2' role='alert'><?php echo htmlspecialchars($erro); ?></div>
      <?php endif; ?>
      <select required class="form-select" name="tipo_usuario">
        <option value="" disabled selected>Entrar como</option>
        <option value="cliente">Cliente</option>
        <option value="funcionario">Funcionário</option>
      </select>
      <button class="btn btn-primary submit" type="submit">Entrar</button>
      <p class="signin">Não tem uma conta? <a href="cadastro_cliente.php">Cadastre-se</a></p>
    </form>
  </div>
  <br><br><br><br>
  <footer class="text-center mt-4 d-none d-md-block">
    <div class="footer-links">
      <a href="#sobre">Sobre Nós</a>
    </div>
    <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
  </footer>
</body>

</html>