<?php
$db_banco ="s2itp";
$db_user = "root";
$db_pass = "";
$host = 'localhost';

$conexao = @mysql_connect($host,$db_user,$db_pass);
if (!($conexao)){
    print("<script language=JavaScript>
          alert(\"Não foi poss�vel conectar ao Banco de Dados.\");
          </script>");
	echo $conexao;
    exit;
}

$db = mysql_select_db($db_banco,$conexao) or
    die("<script language=JavaScript>alert(\"Tabela inexistente!\");</script>"); 
?>