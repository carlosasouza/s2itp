<?php

include_once 'DataBase/dataBase.php';

class ServiceController {
    
    static function saveData($latitude, $longitude, $busId) {
        
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $stmt = $pdo->prepare("UPDATE `bus` SET `latitude`=?,`longitude`=? WHERE `idBus` = ?");
        $stmt->bindParam(1, $latitude, PDO::PARAM_STR);
        $stmt->bindParam(2, $longitude, PDO::PARAM_STR);
        $stmt->bindParam(3, $busId, PDO::PARAM_STR);
        $result = $stmt->execute();
        
        return "Foi!";
    }
   //em desenvolvimento 
    static function getData() {
        
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $stmt = $pdo->prepare("SELECT `latitude`,`longitude` FROM `bus` WHERE `idBus` = 1");
        //$stmt->bindParam(1, $latitude, PDO::PARAM_STR);
        //$stmt->bindParam(2, $longitude, PDO::PARAM_STR);
        //$stmt->bindParam(3, $busId, PDO::PARAM_STR);
        $result = $stmt->execute();
        
        return $result;
    }
}

?>
