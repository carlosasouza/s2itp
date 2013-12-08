<?php

include_once './Controller/serviceController.php';

$serviceController = new ServiceController();

echo $process = $serviceController->getBusInfo();
echo $process = $serviceController->getPointers();

?>
