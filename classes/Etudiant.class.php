<?php

class Etudiant extends Personne {

    private $dep;
    private $div;
    private $num;

    function __construct($etudiant) {
        if (!empty($etudiant)) {
            parent::__construct($etudiant);
            $this->affecteEtudiant($etudiant);
        }
    }

    function affecteEtudiant($etudiant) {
        foreach ($etudiant as $col => $value) {
            switch ($col) {
                case 'dep_num':
                    $this->setDep($value);
                    break;
                case 'div_num':
                    $this->setDiv($value);
                    break;
                case 'per_num':
                    $this->setNum($value);
                    break;
                default:
                    break;
            }
        }
    }

    public function getDep() {
        return $this->dep;
    }

    public function getDiv() {
        return $this->div;
    }
    
    public function getNum() {
        return $this->num;
    }

    public function setDep($dep) {
        if(is_int($dep))
            $this->dep = $dep;
    }

    public function setDiv($div) {
        if(is_int($div))
            $this->div = $div;
    }
    public function setNum($num) {
        if(is_int($num))
            $this->num = $num;
    }

}
