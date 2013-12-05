<?php

include_once './Controller/serviceController.php';

$serviceController = new ServiceController();

//@$latitude = $_REQUEST['lat'];
//@$longitude = $_REQUEST['lng'];
//@$busId = $_REQUEST['busId'];

//echo $process = $serviceController->saveData($latitude, $longitude, $busId);

echo $process = $serviceController->getBusInfo();
echo $process = $serviceController->getPointers();
?>
