<?php
class Salarie extends Personne{
		
	private $num=null;
	private $telProf;
	private $numFonc;
		
	
	function __construct($salarie)
	{
		parent::__construct($salarie);
		$this->affecteSalarie($salarie);
	}
	
	function affecteSalarie($salarie)
	{
		foreach ($salarie as $col => $value) {
			switch ($col) {
				case 'sal_telprof':
					$this->setTelProf($value);
					break;
				case 'fon_num':
					$this->setNumFonc($value);
					break;
				case 'per_num':
					$this->setNum($value);
				default:	
				break;
			}
		}
	}
        public function getNum() {
            return $this->num;
        }

        public function getTelProf() {
            return $this->telProf;
        }

        public function getNumFonc() {
            return $this->numFonc;
        }

        public function setNum($num) {
            $this->num = $num;
        }

        public function setTelProf($telProf) {
            $this->telProf = $telProf;
        }

        public function setNumFonc($numFonc) {
            $this->numFonc = $numFonc;
        }


}