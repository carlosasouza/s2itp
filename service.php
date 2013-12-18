<?php

include_once './app/controller/serviceController.php';

$serviceController = new ServiceController();

if(isset($_REQUEST['busId']) and isset($_REQUEST['lat']) and isset($_REQUEST['lng'])){
    $latitude = @split('S', $_REQUEST['lat']);
    $longitude = @split('W', $_REQUEST['lng']);
    
    $latitude = '-'.trim($latitude[0]/100);
    $longitude = '-'.trim($longitude[0]/100);
    
    $process = $serviceController->atualizaDadosOnibus(0, 0, 'null', 20, -16.041462,-48.078233, 1, $_REQUEST['busId']);
}

 else {
    echo 'Não foi possviel inicar o serviço!';    
}

?>
