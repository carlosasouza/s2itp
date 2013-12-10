<?php

/**
 * Description of posicao
 *
 * @author Carlos
 */
class Posicao {
    
    private $id;
    private $latitude;
    private $longitude;
    
    function __construct($id, $latitude, $longitude) {
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }
    
}

?>
