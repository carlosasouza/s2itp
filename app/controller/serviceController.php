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
                $onibus->setId($row['idBus']);
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

    function recuperaCidades() {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT * FROM `cidade` ORDER BY `nome`");
        $result = $stmt->execute();
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
        else
            return false;
    }

    function distanciaParadas($latParadaAtual, $longParadaAtual, $latProximaParada, $longProximaParada) {

        $raioTerra = 6371.0;
        $latParadaAtual = $latParadaAtual * pi() / 180.0;
        $longParadaAtual = $longParadaAtual * pi() / 180.0;
        $latProximaParada = $latProximaParada * pi() / 180.0;
        $longProximaParada = $longProximaParada * pi() / 180.0;

        $distanciaLat = $latProximaParada - $latParadaAtual;
        $distanciaLong = $longProximaParada - $longParadaAtual;

        $valorExpresao1 = sin($distanciaLat / 2) * sin($distanciaLat / 2) + cos($latParadaAtual) * cos($latProximaParada) * sin($distanciaLong / 2) * sin($distanciaLong / 2);
        $valorExpresao2 = 2 * atan2(sqrt($valorExpresao1), sqrt(1 - $valorExpresao1));

        return round($raioTerra * $valorExpresao2 * 1000);
        
    }
    
    function recuperaLinhas($idCidade) {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT DISTINCT `id`, `numeroLinha`, `origem`, `destino` FROM `s2itp`.`cidade_linha`, `s2itp`.`linha`  WHERE `cidade_linha`.`linha_id` = `linha`.`id` AND `cidade_linha`.`cidade_id` = ?");
        $stmt->bindParam(1, $idCidade, PDO::PARAM_STR);
        $result = $stmt->execute();
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
        else
            return false;
    }

}

?>
