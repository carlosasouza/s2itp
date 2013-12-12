<?php

include_once '../app/controller/serviceController.php';

$serviceController = new ServiceController();

$idCidade = $_REQUEST['idCidade'];

if(isset($_REQUEST['linha'])){
    $linhas = $serviceController->recuperaLinhas($idCidade);
    
    echo '<label>Linhas:</label>';
    echo '<select name="linha" id="linha" onchange="mostra_mapa()">';
    echo '<option value="...::Selecione a Linha:::...">...::Selecione a Linha:::...</option>';
        foreach($linhas as $linha){
            echo "<option value='".utf8_encode($linha['numeroLinha'])."'>".utf8_encode($linha['numeroLinha'])."</option>";
        }
    echo '</select>';
}

if(isset($_REQUEST['parada'])){
    $paradas = $serviceController->recuperaParadas($idCidade);
    
    echo '<label>Paradas:</label>';
    echo '<select name="parada" id="parada" onchange="buscar_linha()">';
    echo '<option value="...::Selecione a Parada:::...">...::Selecione a Parada:::...</option>';
        foreach($paradas as $parada){
            echo "<option value='".utf8_encode($parada['nome'])."'>".utf8_encode($parada['nome'])."</option>";
        }
    echo '</select>';    
}

?>
