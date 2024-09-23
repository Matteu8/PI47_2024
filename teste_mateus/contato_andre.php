<?php
require("conexao.php");

$erro = ""; 
$sucesso = ""; 

if (isset($_POST["bt_nome"])) {
    $nome = $_POST["bt_nome"];
    $email = $_POST["bt_email"];
    $telefone = $_POST["bt_telefone"];
    $assunto = $_POST["bt_assunto"];
    $mensagem = $_POST["bt_mensagem"];

    $stmt = $mysqli->prepare("INSERT INTO feedback (nome, email, telefone, assunto, msg) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $email, $telefone, $assunto, $mensagem);

    if ($stmt->execute()) {
        $sucesso = "Feedback enviado com sucesso!";
    } else {
        $erro = "Erro ao enviar feedback: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Contato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
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
    <div class="text-center">
        <h1 class="text-white" style="background-color: orange;">Página de Contato</h1>
    </div>

    <div class="container">
        <form action="" method="post">
            <div class="mb-3">
                <label for="bt_nome" class="form-label">Nome:</label>
                <input class="form-control" type="text" name="bt_nome" id="bt_nome">
            </div>
            <div class="mb-3">
                <label for="bt_email" class="form-label">Email:</label>
                <input class="form-control" type="email" name="bt_email" id="bt_email" required>
            </div>
            <div class="mb-3">
                <label for="bt_telefone" class="form-label">Telefone:</label>
                <input class="form-control" type="number" min="1" name="bt_telefone" id="bt_telefone" required>
            </div>
            <div class="mb-3">
                <label for="bt_assunto" class="form-label">Assunto:</label>
                <select class="form-select" id="bt_assunto" name="bt_assunto" required>
                    <option value="Elogio">Elogio</option>
                    <option value="Reclamação">Reclamação</option>
                    <option value="Dúvida">Dúvida</option>
                    <option value="Mensagem">Mensagem</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="bt_mensagem" class="form-label">Mensagem:</label>
                <textarea class="form-control" name="bt_mensagem" id="bt_mensagem" rows="4" required></textarea>
            </div>

            <?php if ($sucesso): ?>
                <div class='alert alert-success' role='alert'><?php echo htmlspecialchars($sucesso); ?></div>
            <?php endif; ?>
            <?php if ($erro): ?>
                <div class='alert alert-danger mt-2' role='alert'><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>

            <div class="d-flex flex-column flex-sm-row justify-content-between">
                <input class="btn btn-success" type="submit" value="Enviar">
                <input class="btn btn-danger mt-2 mt-sm-0" type="reset" value="Redefinir">
                <a href="area_cliente.php" class="btn btn-link text-decoration-none">Voltar</a>
            </div>
        </form>
    </div>

    <footer class="text-center mt-4 d-none d-md-block">
        <div class="social-icons">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
