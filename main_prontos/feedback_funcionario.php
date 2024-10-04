<?php
include("conexao.php");
require("protecao.php");

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $mysqli->prepare("DELETE FROM feedback WHERE id_feedback = ?");
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Feedback excluído com sucesso!'); window.location.href='feedback_funcionario.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir feedback.');</script>";
    }
    $stmt->close();
}

if (isset($_GET['truncate'])) {
    $stmt = $mysqli->prepare("TRUNCATE TABLE feedback");
    
    if ($stmt->execute()) {
        echo "<script>alert('Todos os feedbacks foram excluídos com sucesso!'); window.location.href='feedback_funcionario.php';</script>";
    } else {
        echo "<script>alert('Erro ao esvaziar a tabela.');</script>";
    }
    $stmt->close();
}

$resultado = $mysqli->query("SELECT * FROM feedback ORDER BY id_feedback ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback dos Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="gabriell.css">
</head>
<body>
    <div class="row" style="background-color:#3a6da1;">
        <div class="col-12">
            <a href="">
                <img src="img/topo_site_bl1_2018.png" class="img-fluid" alt="Logo">
            </a>
        </div>
    </div>
    <div class="text-center">
        <h1 class="text-white" style="background-color: orange;">Feedback dos Clientes</h1>
    </div>

    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Assunto</th>
                        <th>Mensagem</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_feedback']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['assunto']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['msg']) . "</td>";
                            echo "<td>
                                    <a href='?delete_id=" . htmlspecialchars($row['id_feedback']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir este feedback?\");'>Excluir</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Nenhum feedback encontrado.</td></tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="6" class="text-end"><strong>Envaziar a Tabela:</strong></td>
                        <td>
                            <a href="?truncate=true" class="btn btn-warning" onclick="return confirm('Tem certeza que deseja esvaziar todos os feedbacks?');">Esvaziar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a class="btn btn-link text-decoration-none" href="area_funcionarios.php">Voltar</a>
    </div>

    <footer class="text-center mt-4">
        <div class="social-icons">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
