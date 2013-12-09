<?php

/**
 * Description of linha
 *
 * @author Carlos
 */
class Linha {
    
    private $id;
    private $numeroLinha;
    private $origem;
    private $destino;
    
    function __construct($id, $numeroLinha, $origem, $destino) {
        $this->id = $id;
        $this->numeroLinha = $numeroLinha;
        $this->origem = $origem;
        $this->destino = $destino;
    }

    public function getId() {
        return $this->id;
    }

    public function getNumeroLinha() {
        return $this->numeroLinha;
    }

    public function getOrigem() {
        return $this->origem;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNumeroLinha($numeroLinha) {
        $this->numeroLinha = $numeroLinha;
    }

    public function setOrigem($origem) {
        $this->origem = $origem;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }
    
}

?>
