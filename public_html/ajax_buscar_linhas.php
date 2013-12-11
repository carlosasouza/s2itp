<?php

include_once '../app/controller/serviceController.php';

$serviceController = new ServiceController();

$idCidade = $_REQUEST['idCidade'];

$linhas = $serviceController->recuperaLinhas($idCidade);

?>

<label>Linhas:</label>
<select name="linha" id="linha">
    <option value="...:::Selecione:::...">...:::Selecione:::...</option>
  <?php foreach($linhas as $linha){
    echo "<option value='".utf8_encode($linha['numeroLinha'])."'>".utf8_encode($linha['numeroLinha'])."</option>";
  }
?>
</select>