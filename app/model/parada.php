<?php

/**
 * Description of parada
 *
 * @author Carlos
 */

class Parada {
    
    private $id;
    private $nome;
    private $latitude;
    private $longitude;
    
    function __construct($id, $nome, $latitude, $longitude) {
        $this->id = $id;
        $this->nome = $nome;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

}

?>
