<?php
// delete_feedback.php

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'nome_do_banco';
$username = 'usuario';
$password = 'senha';

try {
    // Conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se o ID foi enviado pelo formulário
    if (isset($_POST['feedback_id']) && !empty($_POST['feedback_id'])) {
        $feedback_id = (int) $_POST['feedback_id'];

        // Preparar a query para deletar o feedback
        $stmt = $pdo->prepare('DELETE FROM feedback WHERE id = :id');
        $stmt->bindParam(':id', $feedback_id, PDO::PARAM_INT);

        // Executar a query
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo 'Feedback deletado com sucesso.';
        } else {
            echo 'Nenhum feedback encontrado com o ID fornecido.';
        }
    } else {
        echo 'ID do feedback não fornecido.';
    }
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
}
?>

<!-- delete_feedback.html -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Deletar Feedback</title>
</head>
<body>
    <h1>Deletar Feedback</h1>
    <form action="delete_feedback.php" method="post">
        <label for="feedback_id">ID do Feedback:</label>
        <input type="text" id="feedback_id" name="feedback_id" required>
        <input type="submit" value="Deletar">
    </form>
</body>
</html>
