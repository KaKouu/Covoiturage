<?php
class Ville{
	
	private $vilNum;
	private $vilNom;
	
	function __construct($ville)
	{
		if(!empty($ville))
		{
			foreach ($departement as $col => $value) 
			{
				switch ($col) 
				{
					case 'vil_num':
						$this->setVilNum($value);				
						break;
					case 'vil_nom':
						$this->setVilNom($value);
						break;
					default:
						break;
				}
			}	
		}
	}

        public function getVilNum() {
            return $this->vilNum;
        }

        public function getVilNom() {
            return $this->vilNom;
        }

        public function setVilNum($vilNum) {
            $this->vilNum = $vilNum;
        }

        public function setVilNom($vilNom) {
            $this->vilNom = $vilNom;
        }


}