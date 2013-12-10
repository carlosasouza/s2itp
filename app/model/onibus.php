<?php

/**
 * Description of onibus
 *
 * @author Carlos
 */
class Onibus {
    
    private $id;
    private $modelo;
    private $lotacao;
    private $qtdPassageiro;
    private $statusParada;
    private $statusDefeito;
    private $sentido;
            
    function __construct($id, $modelo, $lotacao, $qtdPassageiro, $statusParada, $statusDefeito, $sentido) {
        $this->id = $id;
        $this->modelo = $modelo;
        $this->lotacao = $lotacao;
        $this->qtdPassageiro = $qtdPassageiro;
        $this->statusParada = $statusParada;
        $this->statusDefeito = $statusDefeito;
        $this->sentido = $sentido;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }
    
    public function getLotacao() {
        return $this->lotacao;
    }

    public function setLotacao($lotacao) {
        $this->lotacao = $lotacao;
    }

    public function getQtdPassageiro() {
        return $this->qtdPassageiro;
    }

    public function setQtdPassageiro($qtdPassageiro) {
        $this->qtdPassageiro = $qtdPassageiro;
    }

    public function getStatusParada() {
        return $this->statusParada;
    }

    public function setStatusParada($statusParada) {
        $this->statusParada = $statusParada;
    }

    public function getStatusDefeito() {
        return $this->statusDefeito;
    }

    public function setStatusDefeito($statusDefeito) {
        $this->statusDefeito = $statusDefeito;
    }

    public function getSentido() {
        return $this->sentido;
    }

    public function setSentido($sentido) {
        $this->sentido = $sentido;
    }
    
}

?>
