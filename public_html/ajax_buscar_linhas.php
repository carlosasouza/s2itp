<?php
include('conexao.php');
$cidade = 1;
$sql = "SELECT * FROM line WHERE id_cidade = $cidade ORDER BY idLine";
$res = mysql_query($sql, $conexao);
$num = mysql_num_rows($res);
for ($i = 0; $i < $num; $i++) {
  $dados = mysql_fetch_array($res);
  $arrCidades[$dados['idLine']] = utf8_encode($dados['description']);
}
?>

<label>Linhas:</label>
<select name="linha" id="linha">
  <?php foreach($arrCidades as $value => $nome){
    echo "<option value='{$value}'>{$nome}</option>";
  }
?>
</select>