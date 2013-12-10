<?php

include_once './app/controller/serviceController.php';

$serviceController = new ServiceController();

echo $serviceController->distanciaParadas(-15.9968, -48.05655, -15.9857, -48.042293);

?>
