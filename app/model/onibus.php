<?php

/**
 * Description of onibus
 *
 * @author Carlos
 */
class Onibus {
    
    private $id;
    private $modelo;
    private $latitude;
    private $longitude;
    private $lotacao;
    private $qtdPassageiro;
    private $statusParada;
    private $statusDefeito;
    
    function __construct($id, $modelo, $latitude, $longitude, $lotacao, $qtdPassageiro, $statusParada, $statusDefeito) {
        $this->id = $id;
        $this->modelo = $modelo;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->lotacao = $lotacao;
        $this->qtdPassageiro = $qtdPassageiro;
        $this->statusParada = $statusParada;
        $this->statusDefeito = $statusDefeito;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getLotacao() {
        return $this->lotacao;
    }

    public function getQtdPassageiro() {
        return $this->qtdPassageiro;
    }

    public function getStatusParada() {
        return $this->statusParada;
    }

    public function getStatusDefeito() {
        return $this->statusDefeito;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function setLotacao($lotacao) {
        $this->lotacao = $lotacao;
    }

    public function setQtdPassageiro($qtdPassageiro) {
        $this->qtdPassageiro = $qtdPassageiro;
    }

    public function setStatusParada($statusParada) {
        $this->statusParada = $statusParada;
    }

    public function setStatusDefeito($statusDefeito) {
        $this->statusDefeito = $statusDefeito;
    }

}

?>
