<?php

include_once './Controller/serviceController.php';

$serviceController = new ServiceController();

echo $serviceController->getLines($city); 

?>