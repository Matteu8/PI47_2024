<?php
/*    (PEGAR DO BANCO DE DADOS)    */
$sql = "SELECT * FROM tabela_login WHERE email =  '$email'";

$sql_exec = $mysqli->query($sql) or die($mysqli->error);
$usuario = $sql_exec->fetch_assoc();
/*    FIM (PEGAR DO BANCO DE DADOS)    */


/*    (COLOCAR NO BANCO DE DADOS)    */
$mysqli->query("INSERT INTO tabela_login (nome, email, senha) values('$nome', '$email', '$senha')") or
       die($mysqlierrno);
/*    FIM (COLOCAR NO BANCO DE DADOS)    */

/*    (ALTERA O BANCO DE DADOS)    */
$sql_alterar = "UPDATE basico_tabela SET nome = '$nome', telefone = '$telefone', cargo = '$cargo', endereco = '$endereco', cpf = '$cpf', datanasc = '$datanasc', email = '$email', senha = '$senha', caminho_foto = '$caminho_banco' WHERE id_funcionario = '$id_funcionario'";
$mysqli_alterar = $mysqli->query($sql_alterar) or die($mysqli->error);
header("Location:consultar_funcionarios.php");
/*    FIM (ALTERA O BANCO DE DADOS)    */