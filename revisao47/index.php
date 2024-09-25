<?php
    include("conexao.php");

    $stmt = $mysqli->prepare("SELECT * FROM tabela_nome");        
    $stmt->execute();


      // Armazena os resultados
      $resultados = $stmt->get_result();


    $stmt->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre o seu nome</title>
</head>
<body>
    <h1>Sistema de cadastro de nome</h1>

    <h2>Lista de nomes já cadastrado:</h2>
    <ul>
        <?php
        // Verifica se há resultados e exibe cada linha
        if ($resultados->num_rows > 0) {
            while ($row = $resultados->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['nome']) . "</li>";
            }
        } else {
            echo "<li>Nenhum nome cadastrado.</li>";
        }
        ?>
    </ul>

    <p>Deseja cadastrar nomes ?<a href="cadastrar_nome.php"> Clique aqui.</a></p>
    

</body>
</html>