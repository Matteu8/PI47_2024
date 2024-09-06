<?php
include("conexao.php");

// Depois, se um ID foi passado via GET, busque os detalhes desse médico para exibição
if (isset($_GET['id_funcionario'])) {
    $id_funcionario = $_GET['id_funcionario'];
    $sql_consultar = "SELECT * FROM basico_tabela WHERE id_funcionario= '$id_funcionario'";
    $mysqli_consultar = $mysqli->query($sql_consultar) or die($mysqli->error);
    $consultar = $mysqli_consultar->fetch_assoc();

    // Primeiro, verifique se o formulário foi enviado e, em caso afirmativo, processe a submissão
    if (isset($_POST['id_funcionario'])) {
        $id_funcionario = $_POST['id_funcionario'];
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $cargo = $_POST['cargo'];
        $endereco = $_POST['endereco'];
        $cpf = $_POST['cpf'];
       
        $datanasc = $_POST['datanasc'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $caminho_banco = $consultar['caminho']; // Preserva o caminho da foto antiga

        if (isset($_FILES['bt_foto']) && $_FILES['bt_foto']['error'] === 0) {
            $arquivo = $_FILES['bt_foto'];
            
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
        }

        // Atualizando os dados no banco de dados
        $sql_alterar = "UPDATE basico_tabela SET nome = '$nome', telefone = '$telefone', cargo = '$cargo', endereco = '$endereco', cpf = '$cpf', datanasc = '$datanasc', email = '$email', senha = '$senha', caminho_foto = '$caminho_banco' WHERE id_funcionario = '$id_funcionario'";
        $mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);
        header("Location:consultar_funcionarios.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo2.png">
    <title>Alterar - Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="meu.css">
</head>

<body>

    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <h1 class="text-center">Alterar - Médico</h1>
            <label class="form-label" for="nome">Nome</label>
            <input type="hidden" name="id_funcionario" value="<?php echo htmlspecialchars($consultar['id_funcionario']); ?>">
            <input class="form-control" type="text" name="nome" value="<?php echo htmlspecialchars($consultar['nome']); ?>">

            <label class="form-label" for="telefone">Telefone</label>
            <input class="form-control" type="text" name="telefone" value="<?php echo htmlspecialchars($consultar['telefone']); ?>">

            <label class="form-label" for="cargo">cargo</label>
            <input class="form-control" type="text" name="cargo" value="<?php echo htmlspecialchars($consultar['cargo']); ?>">

            <label class="form-label" for="endereco">Endereço</label>
            <input class="form-control" type="text" name="endereco" value="<?php echo htmlspecialchars($consultar['endereco']); ?>">

            <label class="form-label" for="cpf">CPF</label>
            <input class="form-control" type="text" name="cpf" value="<?php echo htmlspecialchars($consultar['cpf']); ?>">

            <label class="form-label" for="datanasc">Data de Nascimento</label>
            <input class="form-control" type="date" name="datanasc" value="<?php echo htmlspecialchars($consultar['datanasc']); ?>">

            <label class="form-label" for="email">E-mail</label>
            <input class="form-control" type="text" name="email" value="<?php echo htmlspecialchars($consultar['email']); ?>">

            <label class="form-label" for="senha">Senha</label>
            <input class="form-control" type="password" name="senha" value="<?php echo htmlspecialchars($consultar['senha']); ?>">

            <label class="form-label" for="bt_foto">Foto</label>
            <input class="form-control" type="file" name="bt_foto">

            <?php if ($consultar['caminho_foto']) : ?>
                <div class="mt-3 text-center"> <!-- Adiciona a classe text-center para centralizar o conteúdo -->
                    <img src="<?php echo htmlspecialchars($consultar['caminho_foto']); ?>" alt="Foto do médico" class="img-thumbnail">
                </div>
            <?php endif; ?>

            <input class="btn btn-success mt-3" type="submit" value="Alterar">
            <a class="btn btn-primary mt-3" href="consultar_funcionario.php">Voltar</a>
        </form>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</html>