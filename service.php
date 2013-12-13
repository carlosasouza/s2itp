<?php

include_once './app/controller/serviceController.php';

$serviceController = new ServiceController();

@$latitude = $_REQUEST['lat'];
@$longitude = $_REQUEST['lng'];
@$busId = $_REQUEST['busId'];

$process = $serviceController->atualizaDadosOnibus(0, 0, 'null', 20, $latitude, $longitude, 1, $busId);

?>
