<?php

include_once 'DataBase/dataBase.php';

class ServiceController {
    
    static function saveData($latitude, $longitude, $idBus) {
        
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $stmt = $pdo->prepare("UPDATE `bus` SET `latitude`=?,`longitude`=? WHERE `idBus` = ?");
        $stmt->bindParam(1, $latitude, PDO::PARAM_STR);
        $stmt->bindParam(2, $longitude, PDO::PARAM_STR);
        $stmt->bindParam(3, $idBus, PDO::PARAM_STR);
        $result = $stmt->execute();
        
        return "Foi!";
    }
    
    
    function getBusInfo($idBus) {
  
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  
        $stmt = $pdo->prepare("SELECT `idBus`, `latitude`,`longitude` FROM `bus` WHERE `idBus` = ?");
        $stmt->bindParam(1, $idBus, PDO::PARAM_STR);
        $result = $stmt->execute();
        $ok = $stmt->fetchAll();
        
        if(is_array($ok))
            return $ok;
        
        else return false;
        /*foreach ($pdo->query($sql) as $row) {
        print "idBus:". $row['idBus'] . "\t";
        print "latitude:".$row['latitude'] . "\t";
        print "longitude:".$row['longitude'] . "\n";
        }
        return $pdo->query($sql);*/
        }
        
        function getCities() {
  
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  
        $stmt = $pdo->prepare("SELECT * FROM  `city`");
        $result = $stmt->execute();
        $ok = $stmt->fetchAll();
        
        if(is_array($ok))
            return $ok;
        
        else return false;
        }
        
        function getLines() {
  
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  
        $stmt = $pdo->prepare("SELECT * FROM  `line`,`city`,`pointer` WHERE `idCity` = ?");
        $stmt->bindValue(1, 1);
        $result = $stmt->execute();
        $ok = $stmt->fetchAll();
        
        if(is_array($ok))
            return $ok;
        
        else return false;
        }
        
        function getPointers() {
  
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  
        $stmt = $pdo->prepare("SELECT * FROM  `pointer`");
        $result = $stmt->execute();
        $ok = $stmt->fetchAll();
        
        if(is_array($ok))
            return $ok;
        
        else return false;
        }
}

?>
