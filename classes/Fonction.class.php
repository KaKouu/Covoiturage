<?php
class Fonction{
	
	private $num;
	private $libelle;
	
	function __construct($libelle)
	{
		if (!empty($libelle))
		foreach ($libelle as $col => $value) {
			switch ($col) {
				case 'fon_libelle':
					$this->setLibelle($value);
					break;
				case 'fon_num':
					$this->setNum($value);
				default:
					break;
			}
		}
	}
        public function getNum() {
            return $this->num;
        }

        public function getLibelle() {
            return $this->libelle;
        }

        public function setNum($num) {
            $this->num = $num;
        }

        public function setLibelle($libelle) {
            $this->libelle = $libelle;
        }


}