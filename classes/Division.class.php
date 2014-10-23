<?php
class Division{
	
	private $divNum;
	private $divNom;
	
	function __construct($ville)
	{
		if(!empty($division))
		{
			foreach ($division as $col => $value) 
			{
				switch ($col) 
				{
					case 'div_num':
						$this->setDivNum($value);				
						break;
					case 'div_nom':
						$this->setDivNom($value);
						break;
					default:
						break;
				}
			}	
		}
	}
        public function getDivNum() {
            return $this->divNum;
        }

        public function getDivNom() {
            return $this->divNom;
        }

        public function setDivNum($divNum) {
            $this->divNum = $divNum;
        }

        public function setDivNom($divNom) {
            $this->divNom = $divNom;
        }


	
}