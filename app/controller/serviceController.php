<?php

include_once 'DataBase/dataBase.php';
include_once '../app/model/onibus.php';

class ServiceController {

    function atualizaDadosOnibus($sentido, $statusDefeito, $statusParada, $qtdPassageiro, $latitude, $longitude, $id) {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("UPDATE `onibus` SET `qtdPassageiro` = ?, `statusParada` = ?, `statusDefeito` = ?, `sentido` = ? WHERE `id` = ?");
        $stmt->bindParam(1, $qtdPassageiro, PDO::PARAM_STR);
        $stmt->bindParam(2, $statusParada, PDO::PARAM_STR);
        $stmt->bindParam(3, $statusDefeito, PDO::PARAM_STR);
        $stmt->bindParam(4, $sentido, PDO::PARAM_STR);
        $stmt->bindParam(5, $id, PDO::PARAM_STR);
        $stmt->execute();
        
        $idOnibus = $pdo->lastInsertId();
        
        $stmt = $pdo->prepare("INSERT INTO `posicao`(`latitude`, `longitude`) VALUES (?, ?)");
        $stmt->bindParam(1, $latitude, PDO::PARAM_STR);
        $stmt->bindParam(2, $longitude, PDO::PARAM_STR);
        $stmt->execute();
        
        $idPosicao = $pdo->lastInsertId();
        
        $stmt = $pdo->prepare("INSERT INTO `onibus_posicao`(`onibus_id`, `Posicao_idposicao`) VALUES (?, ?)");
        $stmt->bindParam(1, $idOnibus, PDO::PARAM_STR);
        $stmt->bindParam(2, $idPosicao, PDO::PARAM_STR);
        
        $resultado = $stmt->execute();
        
        if($resultado)
            return true;
        else return false;
        
    }

    function recuperaOnibus($id) {
        
        $onibus = new Onibus();
        
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT * FROM `onibus` WHERE `id` = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->execute();
        
        $array = $stmt->fetchAll();

        if (is_array($array)){
            foreach ($array as $row) {
                $onibus->setId($row['id']);
                $onibus->setModelo($row['modelo']);
                $onibus->setLotacao($row['lotacao']);
                $onibus->setQtdPassageiro($row['qtdPassageiro']);
                $onibus->setStatusParada($row['statusParada']);
                $onibus->setStatusDefeito($row['statusDefeito']);
                $onibus->setSentido($row['sentido']);
            }
          return $onibus;
        }
        
        else
            return false;
        
    }

    function recuperaCidades($id) {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT * FROM `cidade` WHERE 'id' = ? ");
        $stmt->execute();
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
        else
            return false;
    }

    function recuperaLinhas($id) {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT * FROM  `linha` WHERE `id` = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->execute();
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
        else
            return false;
    }

    function recuperaParadas() {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT * FROM `parada`");
        $result = $stmt->execute();
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
        else
            return false;
        
    }
    
    function recuperaPosicao($id){
        
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT DISTINCT `parada`.`nome` as `parada_nome`, `parada`.`latitude` as `parada_latitude`, `parada`.`longitude` as `parada_longitude`, `posicao`.`latitude` as `posicao_latitude`, `posicao`.`longitude` as `posicao_longitude` FROM `s2itp`.`posicao`, `s2itp`.`onibus_posicao`, `s2itp`.`parada`, `s2itp`.`linha_parada`  WHERE `parada`.`id` = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->execute();
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
        else
            return false;
        
    }

    function calculaDistancia($latParadaAtual, $longParadaAtual, $latProximaParada, $longProximaParada) {

        $raioTerra = 6371.0;
        $latParadaAtual = $latParadaAtual * pi() / 180.0;
        $longParadaAtual = $longParadaAtual * pi() / 180.0;
        $latProximaParada = $latProximaParada * pi() / 180.0;
        $longProximaParada = $longProximaParada * pi() / 180.0;

        $distanciaLat = $latProximaParada - $latParadaAtual;
        $distanciaLong = $longProximaParada - $longParadaAtual;

        $valorExpresao1 = sin($distanciaLat / 2) * sin($distanciaLat / 2) + cos($latParadaAtual) * cos($latProximaParada) * sin($distanciaLong / 2) * sin($distanciaLong / 2);
        $valorExpresao2 = 2 * atan2(sqrt($valorExpresao1), sqrt(1 - $valorExpresao1));

        $resultado = round($raioTerra * $valorExpresao2 * 1000);
        
        if($resultado < 1000){
            return true; 
        } else return false;
        
    }

}

?>