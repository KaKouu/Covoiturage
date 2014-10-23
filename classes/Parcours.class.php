<?php

class Parcours {

    private $parNum;
    private $parKm;
    private $vilNum1;
    private $vilNum2;

    function __construct($parcours) {
        if (!empty($parcours)) {
            $this->affecteParcours($parcours);
        }
    }

    function affecteParcours($parcours) {
        foreach ($parcours as $col => $value) {
            switch ($col) {
                case 'par_num':
                    $this->setParNum($values);
                    break;
                case 'par_km':
                    $this->setParKm($values);
                    break;
                case 'vil_num1':
                    $this->setVilNum1($values);
                    break;
                case 'vil_num2':
                    $this->setVilNum2($values);
                    break;
                default:
                    break;
            }
        }
    }

    public function getParNum() {
        return $this->parNum;
    }

    public function getParKm() {
        return $this->parKm;
    }

    public function getVilNum1() {
        return $this->vilNum1;
    }

    public function getVilNum2() {
        return $this->vilNum2;
    }

    public function setParNum($parNum) {
        if (is_int($parNum))
            $this->parNum = $parNum;
    }

    public function setParKm($parKm) {
        if (is_int($parKm))
            $this->parKm = $parKm;
    }

    public function setVilNum1($vilNum1) {
        if (is_int($vilNum1))
            $this->vilNum1 = $vilNum1;
    }

    public function setVilNum2($vilNum2) {
        if (is_int($vilNum2))
            $this->vilNum2 = $vilNum2;
    }

}