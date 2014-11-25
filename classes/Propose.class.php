<?php

class Propose {

    private $parNum;
    private $perNum;
    private $proDate;
    private $proTime;
    private $proPlace;
    private $proSens;

    function __construct($propose) {
        if (!empty($propose)) {
            $this->affecte($propose);
        }
    }

    function affecte($propose) {
        foreach ($propose as $col => $value) {
            switch ($col) {
                case 'par_num':
                    $this->setParNum($value);
                    break;
                case 'per_num':
                    $this->setPerNum($value);
                    break;
                case 'pro_date':
                    $this->setProDate($value);
                    break;
                case 'pro_time':
                    $this->setProTime($value);
                    break;
                case 'pro_place':
                    $this->setProPlace($value);
                    break;
                case 'pro_sens':
                    $this->setProSens($value);
                    break;
                default:
                    break;
            }
        }
    }

    public function getParNum() {
        return $this->parNum;
    }

    public function getPerNum() {
        return $this->perNum;
    }

    public function getProDate() {
        return $this->proDate;
    }

    public function getProTime() {
        return $this->proTime;
    }

    public function getProPlace() {
        return $this->proPlace;
    }

    public function getProSens() {
        return $this->proSens;
    }

    public function setParNum($parNum) {
            $this->parNum = $parNum;
    }

    public function setPerNum($perNum) {
            $this->perNum = $perNum;
    }

    public function setProDate($proDate) {
            $this->proDate = $proDate;
    }

    public function setProTime($proTime) {
            $this->proTime = $proTime;
    }

    public function setProPlace($proPlace) {
            $this->proPlace = $proPlace;
    }

    public function setProSens($proSens) {
            $this->proSens = $proSens;
    }

}