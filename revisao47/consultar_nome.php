<?php
    //require("protecao.php");
    require("conexao.php");

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
    <title>Consultar nomes</title>
</head>
<body>
    <h1>Lista de nomes cadastrados</h1>

    <table border="1">
        <tr>
            <th>Id do nome</th>
            <th>Nome</th>
            <th>Alterar</th>
            <th>Deletar</th>
        </tr>
        
        <?php
         
            if ($resultados->num_rows > 0) {
      
            
            while ($row = $resultados->fetch_assoc()) {
        ?>
                <tr>
        <?php
                    echo "<td>".$row['id_nome']."</td>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td>"."<a href='editar_nome.php". $row['id_nome'] . "'>Alterar</a>" ."</td>";
                    echo "<td>"."<a href='deletar_nome.php". $row['id_nome'] . "'>Deletar</a>" ."</td>";
        ?>
                </tr>
        <?php
            }
        } else {
            echo "<li>Nenhum nome cadastrado.</li>";
        }
        ?>   
           
              
    </table>
    <a href="index.php">Voltar</a>
    <a href="cadastrar_nome.php">Cadastrar nome</a>
    <a href="editar_nome.php">Editar nome</a>
    <a href="deletar_nome.php">Deletar nome</a>
    
</body>
</html>