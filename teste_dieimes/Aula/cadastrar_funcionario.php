<?php
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    
    $datanasc = $_POST['datanasc'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = password_hash($_POST['senha'] ?? '', PASSWORD_DEFAULT);

    if (isset($_FILES['bt_foto'])) {
        $arquivo = $_FILES['bt_foto'];
        if ($arquivo['size'] > 15000000) {
            die("Arquivo muito grande!! Max: 15MB");
        }
        if ($arquivo['error']) {
            die("Falha ao enviar arquivo");
        }

        $pasta = "recebidos/";
        $nome_arquivo = $arquivo['name'];
        $novo_nome_arquivo = uniqid();
        $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
        $caminho_banco = $pasta . $novo_nome_arquivo . "." . $extensao;

        $deucerto = move_uploaded_file($arquivo["tmp_name"], $caminho_banco);
    }

    // Preparar a instrução SQL
    $stmt = $mysqli->prepare("INSERT INTO basico_tabela (nome, telefone, cargo, endereco, cpf, datanasc, email, senha, caminho_foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Erro ao preparar a instrução SQL: " . $mysqli->error);
    }
    
    $stmt->bind_param("sssssssss", $nome, $telefone, $cargo, $endereco, $cpf, $datanasc, $email, $senha, $caminho_banco);

    if ($stmt->execute()) {
        echo "<script>Swal.fire('Success', 'Cadastro realizado com sucesso!', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error', 'Erro ao cadastrar: " . $stmt->error . "', 'error');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro - Profissionais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        #Login {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
        }
        .btn-secondary, .btn-info {
            width: 48%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="Login">Cadastro de Funcionários</div>
        <form id="cadastro" action="" method="post" enctype="multipart/form-data">
            <input class="form-control" type="text" name="nome" placeholder="Nome" required>
            <input class="form-control" id="telefoneInput" type="text" name="telefone" placeholder="Telefone" oninput="formatarTelefone()" maxlength="15" required>
            <input class="form-control" type="text" name="cargo" placeholder="Cargo" required>
            <input class="form-control" type="text" name="endereco" placeholder="Endereço" required>
            <input class="form-control" type="file" name="bt_foto" placeholder="Envie sua foto">
            <input class="form-control" id="cpfInput" type="text" name="cpf" placeholder="CPF" oninput="formatarCPF()" maxlength="14" required>            
            <input class="form-control" type="date" name="datanasc" placeholder="Data de nascimento" required>
            <input class="form-control" type="email" name="email" placeholder="Email" required>
            <input class="form-control" type="password" name="senha" placeholder="Senha" required>
            <input class="form-control" type="password" name="senha_confirm" placeholder="Repetir Senha" required>
            <button class="btn btn-primary" type="submit" onclick="return validateFields()">Cadastrar</button>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="history.back()">Voltar</button>
                <a href="consultar_funcionario.php" class="btn btn-info">Consultar Funcionarios</a>
            </div>
        </form>
    </div>

    <script>
        function validateFields() {
            const senha = document.querySelector('input[name="senha"]').value;
            const senhaConfirm = document.querySelector('input[name="senha_confirm"]').value;

            if (senha !== senhaConfirm) {
                alert('As senhas não coincidem!');
                return false;
            }
            return true;
        }

        function formatarTelefone() {
            const input = document.getElementById('telefoneInput');
            input.value = input.value.replace(/\D/g, '').replace(/^(\d{2})(\d)/, '($1) $2').replace(/(\d{4,5})(\d{4})$/, '$1-$2');
        }

        function formatarCPF() {
            const input = document.getElementById('cpfInput');
            input.value = input.value.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{2})$/, '$1-$2');
        }
    </script>
</body>
</html>