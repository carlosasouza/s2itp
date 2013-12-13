<?php

include_once '../app/controller/serviceController.php';

$serviceController = new ServiceController();

@$idCidade = $_REQUEST['idCidade'];
@$idParada = $_REQUEST['idParada'];
@$idLinha = $_REQUEST['idLinha'];

if(isset($_REQUEST['parada'])){
    
    $paradas = $serviceController->recuperaParadas($idCidade);
    
    echo '<label>Paradas:</label>';
    echo '<select name="parada" id="parada" onchange="buscar_linha()">';
    echo '<option value="...::Selecione a Parada:::...">...::Selecione a Parada:::...</option>';
        foreach($paradas as $parada){
            echo "<option value='".utf8_encode($parada['id'])."'>".utf8_encode($parada['nome'])."</option>";
        }
    echo '</select>';    
}

if(isset($_REQUEST['linha'])){
    
    $linhas = $serviceController->recuperaLinhas($idParada);
        
    echo '<label>Linhas:</label>';
    echo '<select name="linha" id="linha" onchange="atualiza_mapa()">';
    echo '<option value="...::Selecione a Linha:::...">...::Selecione a Linha:::...</option>';
        foreach($linhas as $linha){
            echo "<option value='".utf8_encode($linha['id'])."'>".utf8_encode($linha['numeroLinha'])."</option>";
        }
    echo '</select>';
}

if(isset($_REQUEST['onibus'])){
    
    @$onibus = $serviceController->recuperaOnibus($idLinha);
    @$parada = $serviceController->recuperaParada($idParada);
    @$tempo = $serviceController->distanciaParadas($parada[0]['latitude'], $parada[0]['longitude'], $onibus[0]['latitude'], $onibus[0]['longitude']);
    
    $paradaIcon = '"images/paradaIcon.png"';
    $busIcon = '"images/busIcon.png"';
       
    echo"
    <script type='text/javascript'>
            var map;            
            $(document).ready(function() {
            
                var map = new GMaps({
                    el: '#map',
                    lat: ".@$parada[0]['latitude'].",
                    lng: ".@$parada[0]['longitude']."
                });
                map.addMarker({
                    lat: ".@$onibus[0]['latitude'].",
                    lng: ".@$onibus[0]['longitude'].",
                    icon: ".@$busIcon.",
                    title: 'Linha: ".@$onibus[0]['numeroLinha']."',
                    infoWindow: {
                        content: 'Tempo estimado de chegada: ".@$tempo."'
                    }
                });
                map.addMarker({
                    lat: ".@$parada[0]['latitude'].",
                    lng: ".@$parada[0]['longitude'].",
                    icon: ".@$paradaIcon.",
                    title: '".@$parada[0]['nome']."',
                    infoWindow: {
                        content: 'Parada: ".@$parada[0]['nome']."'
                    }
                });                

            });
            
        </script>";

}

?>
