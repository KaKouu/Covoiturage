<?php

class Departement {

    private $depNum;
    private $depNom;
    private $vilNum;

    function __construct($departement) {
        if (!empty($departement))
            $this->affecteDep($departement);
    }

    function affecteDep($departement) {
        foreach ($departement as $col => $value) {
            switch ($col) {
                case 'dep_num':
                    $this->setDepNum($value);
                    break;
                case 'dep_nom':
                    $this->setDepNom($value);
                    break;
                case 'vil_num':
                    $this->setVilNum($value);
                    break;
                default:
                    break;
            }
        }
    }

    public function getDepNum() {
        return $this->depNum;
    }

    public function getDepNom() {
        return $this->depNom;
    }

    public function getVilNum() {
        return $this->vilNum;
    }

    public function setDepNum($depNum) {
        //if(is_int($depNum))
            $this->depNum = $depNum;
    }

    public function setDepNom($depNom) {
        //if(is_string($depNom))
            $this->depNom = $depNom;
    }

    public function setVilNum($vilNum) {
        //if(is_int($vilNum))
            $this->vilNum = $vilNum;
    }

}
