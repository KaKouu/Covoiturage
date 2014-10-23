<?php
class Personne{
	
	private $num;
	private $nom;
	private $prenom;
	private $tel;
	private $mail;
	private $login;
	private $pwd;
	
	function __construct($personne = array())
	{
		if(!empty($personne))
			$this -> affectePersonne($personne);
	}
	
	function affectePersonne($personne)
	{
		foreach ($personne as $col => $value) {
			switch ($col) {
				case 'per_num':
					$this->setNum($value);
					break;
				case 'per_nom':
					$this->setNom($value);			
					break;
				case 'per_prenom':
					$this->setPrenom($value);
					break;
				case 'per_tel':
					$this->setTel($value);
					break;
				case 'per_mail':
					$this->setMail($value);
					break;
				case 'per_login':
					$this->setLogin($value);
					break;
				case 'per_pwd':
					$this->setPwd($value);
					break;
				default:
					break;
			}	
		}
		
	}
	public function getNum() {
            return $this->num;
        }

        public function getNom() {
            return $this->nom;
        }

        public function getPrenom() {
            return $this->prenom;
        }

        public function getTel() {
            return $this->tel;
        }

        public function getMail() {
            return $this->mail;
        }

        public function getLogin() {
            return $this->login;
        }

        public function getPwd() {
            return $this->pwd;
        }

        public function setNum($num) {
            $this->num = $num;
        }

        public function setNom($nom) {
            $this->nom = $nom;
        }

        public function setPrenom($prenom) {
            $this->prenom = $prenom;
        }

        public function setTel($tel) {
            $this->tel = $tel;
        }

        public function setMail($mail) {
            $this->mail = $mail;
        }

        public function setLogin($login) {
            $this->login = $login;
        }

        public function setPwd($pwd) {
            $this->pwd = $pwd;
        }


	
}