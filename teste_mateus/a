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

