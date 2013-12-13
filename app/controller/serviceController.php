<?php

include_once 'DataBase/dataBase.php';

class ServiceController {

    function atualizaDadosOnibus($sentido, $statusDefeito, $statusParada, $qtdPassageiro, $latitude, $longitude, $circulacao, $id) {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("UPDATE `onibus` SET `qtdPassageiro` = ?, `statusParada` = ?, `statusDefeito` = ?, `sentido` = ?, `circulacao` = ? WHERE `id` = ?");
        $stmt->bindParam(1, $qtdPassageiro, PDO::PARAM_STR);
        $stmt->bindParam(2, $statusParada, PDO::PARAM_STR);
        $stmt->bindParam(3, $statusDefeito, PDO::PARAM_STR);
        $stmt->bindParam(4, $sentido, PDO::PARAM_STR);
        $stmt->bindParam(5, $circulacao, PDO::PARAM_STR);
        $stmt->bindParam(6, $id, PDO::PARAM_STR);
        $stmt->execute();
        
        $stmt = $pdo->prepare("INSERT INTO `posicao`(`latitude`, `longitude`) VALUES (?, ?)");
        $stmt->bindParam(1, $latitude, PDO::PARAM_STR);
        $stmt->bindParam(2, $longitude, PDO::PARAM_STR);
        $stmt->execute();
        
        $idPosicao = $pdo->lastInsertId();
        
        $onibusLinhaId = 1;
        
        $stmt = $pdo->prepare("INSERT INTO `onibus_posicao`(`onibus_id`, `onibus_linha_id`, `Posicao_idposicao`) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->bindParam(2, $onibusLinhaId, PDO::PARAM_STR);
        $stmt->bindParam(3, $idPosicao, PDO::PARAM_STR);
        
        $resultado = $stmt->execute();
        
        if($resultado)
            return true;
        else return false;
        
    }

    function recuperaOnibus($idLinha) {
        
        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT DISTINCT `onibus`.`id`, `posicao`.`latitude`, `posicao`.`longitude`, `linha`.`numeroLinha` FROM `onibus`, `linha`, `posicao`, `onibus_posicao` WHERE `onibus`.`id` = `onibus_posicao`.`onibus_id` AND `onibus_posicao`.`Posicao_idposicao` = `posicao`.`idposicao` AND `onibus`.`linha_id` = `linha`.`id` AND `onibus`.`circulacao` = 1 AND `linha`.`id` = ?");
        $stmt->bindParam(1, $idLinha, PDO::PARAM_STR);
        $stmt->execute();
        
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
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

        $distancia = $raioTerra * $valorExpresao2 * 1000;
        $velocidade = (60 * 1000 / 60);
                 
        $tempo = ($distancia/$velocidade);
         
        if($tempo < 1)
            return 'Menos de 1 minuto';
        else
            return round ($tempo)." minuto(s)";
         
    }
	
    function recuperaLinhas($idParada) {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT DISTINCT `linha`.`id`, `linha`.`numeroLinha`, `linha`.`origem`, `linha`.`destino` FROM `linha`, `linha_parada`, `parada` WHERE `linha_parada`.`linha_id` = `linha`.`id` AND `linha_parada`.`parada_id` = `parada`.`id` AND `parada`.`id` = ? ORDER BY `linha`.`numeroLinha`");
        $stmt->bindParam(1, $idParada, PDO::PARAM_STR);
        $result = $stmt->execute();
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
        else
            return false;
    }

    function recuperaParadas($idCidade) {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT DISTINCT `parada`.`id`, `parada`.`nome`, `parada`.`latitude`, `parada`.`longitude` FROM `parada`, `cidade`, `cidade_parada` WHERE `parada`.`id` = `cidade_parada`.`parada_id` AND `cidade_parada`.`cidade_id` = `cidade`.`id` AND `cidade`.`id` = ? ORDER BY `parada`.`nome`");
        $stmt->bindParam(1, $idCidade, PDO::PARAM_STR);
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
    
    function recuperaParada($idParada) {

        $pdo = Connection::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare("SELECT * FROM `parada` WHERE `parada`.`id` = ?");
        $stmt->bindParam(1, $idParada, PDO::PARAM_STR);
        $result = $stmt->execute();
        $array = $stmt->fetchAll();

        if (is_array($array))
            return $array;
        else
            return false;
        
    }
    
}

?>
