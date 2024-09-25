<?php
include("conexao.php"); // Arquivo php referente ao banco de dados

    // Verifica se um ID foi passado via GET
    if (isset($_GET['id_sobremesa'])) {
        $id_sobremesa = $_GET['id_sobremesa'];
        
        // Consulta os detalhes do Funcionario selecionado
        $consultar_sobremesa = "SELECT * FROM sobremesa WHERE id_sobremesa = ?";
        $stmt = $mysqli->prepare($consultar_sobremesa);
        $stmt->bind_param('i', $id_sobremesa);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $sobremesa = $resultado->fetch_assoc();

        if (!$sobremesa) {
            echo "<script>alert('sobremesa não encontrado.'); window.location.href='consulta_sobremesa.php';</script>";
            exit;
        }
    }

        // Deletar o Funcionario se o botão de deletar for clicado
        if (isset($_POST['id_sobremesa'])) {
            $delete_id = $_POST['id_sobremesa'];
            $delete_query = "DELETE FROM sobremesa WHERE id_sobremesa = ?";
            $stmt = $mysqli->prepare($delete_query);
            $stmt->bind_param('i', $delete_id);

           

            if ($stmt->execute()) {
                echo "<script>alert('Sobremesa deletado com sucesso!'); window.location.href='consulta_sobremesa.php';</script>";
            } else {
                echo "<script>alert('Erro ao deletar a sobremesa.');</script>";
            }

            
        }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deletar Sobremesa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="sriella.css">
        <style>
                body {
        background-color: #f4f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
        font-weight: 700;
    }

    .alert {
        font-size: 1.1em;
        padding: 15px;
        border-radius: 5px;
        background-color: #ffefc4;
        color: #8a6d3b;
        border: 1px solid #f7d8a3;
        margin-bottom: 20px;
        text-align: center;
    }

    button[type="submit"], 
    a.btn-secondary {
        display: inline-block;
        width: 48%;
        padding: 12px;
        text-align: center;
        font-size: 1em;
        font-weight: 600;
        border-radius: 5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button[type="submit"] {
        background-color: #dc3545;
        color: #fff;
        border: none;
    }

    button[type="submit"]:hover {
        background-color: #c82333;
    }

    a.btn-secondary {
        background-color: #6c757d;
        color: #fff;
        text-decoration: none;
    }

    a.btn-secondary:hover {
        background-color: #5a6268;
    }

    @media (max-width: 480px) {
        button[type="submit"], 
        a.btn-secondary {
            width: 100%;
            margin-bottom: 10px;
        }
}

    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Deletar Sobremesa</h2>
        
        <?php if (isset($sobremesa)): ?>
            <div class="alert alert-warning" role="alert">
                Você tem certeza que deseja deletar esta sobremesa? <strong><?php echo htmlspecialchars($sobremesa['id_sobremesa']); ?></strong>?
            </div>

            <form action="deletar_sobremesa.php" method="post">
                <input type="hidden" name="id_sobremesa" value="<?php echo htmlspecialchars($sobremesa['id_sobremesa']); ?>">
                <input class="btn btn-danger" type="submit" value="Deletar">
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>