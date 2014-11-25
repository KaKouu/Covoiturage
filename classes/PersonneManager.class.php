<?php

class PersonneManager {

    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($personne) {
        $req = $this->db->prepare('INSERT INTO personne (per_nom, per_prenom, '
                . 'per_tel, per_mail, per_login, per_pwd) '
                . 'VALUES( :nom, :prenom, :tel, :mail, :login, :pwd)');
        $req->bindValue(':nom', $personne->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $personne->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':tel', $personne->getTel(), PDO::PARAM_STR);
        $req->bindValue(':mail', $personne->getMail(), PDO::PARAM_STR);
        $req->bindValue(':login', $personne->getLogin(), PDO::PARAM_STR);
        $req->bindValue(':pwd',sha1(sha1($personne->getPwd()).SAL), PDO::PARAM_STR);
        $req->execute();
        return $this->db->lastInsertId();
    }
    function getAllPers() {
        $personne = array();
        $sql = 'SELECT * FROM personne';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        while ($pers = $req->fetch(PDO::FETCH_OBJ)) {
            $personne[] = new Personne($pers);
        }
        return $personne;
        $req->closeCursor();
    }
    
    function getPersIdentification($login, $mdp) {
        $sql = "SELECT * FROM personne WHERE per_login ='".$login."' AND per_pwd='".sha1(sha1($mdp).SAL)."'";
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $pers = $req->fetch(PDO::FETCH_OBJ);
        $personne = new Personne($pers);
        $req->closeCursor();
        return $personne;
        
    }
    function getPersByMail($mail) {
        $sql = "SELECT * FROM personne WHERE per_mail ='".$mail."'";
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $pers = $req->fetch(PDO::FETCH_OBJ);
        $personne = new Personne($pers);
        $req->closeCursor();
        return $personne; 
    }
    
    function getPersByLogin($login) {
        $sql = "SELECT * FROM personne WHERE per_login ='".$login."'";
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $pers = $req->fetch(PDO::FETCH_OBJ);
        $personne = new Personne($pers);
        $req->closeCursor();
        return $personne;   
    }
    function getPersByName($nom,$prenom) {
         $sql = "SELECT * FROM personne WHERE per_nom ='".$nom."' AND per_prenom='".$prenom."'";
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $pers = $req->fetch(PDO::FETCH_OBJ);
        $personne = new Personne($pers);
        $req->closeCursor();
        return $personne;
        
    }
    function isEtudiant($idPersonne)
    {
        $sql = 'SELECT * FROM etudiant WHERE per_num='.$idPersonne;
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $pers = $req->fetch(PDO::FETCH_OBJ);
        return !empty($pers);
    }
    
    function setPersonneIdentite($personne,$idPersonne)
    {
        $sql = 'UPDATE personne SET per_nom=:nom, per_prenom=:prenom , per_tel=:tel'
                . ',per_mail=:mail WHERE per_num='.$idPersonne;
        $req = $this->db->prepare($sql);
        $req->bindValue(':nom', $personne->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $personne->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':tel', $personne->getTel(), PDO::PARAM_STR);
        $req->bindValue(':mail', $personne->getMail(), PDO::PARAM_STR);
        $req->execute();
    }
    function setPersonneConnexion($personne,$idPersonne)
    {
        $sql = 'UPDATE personne SET per_login=:login, per_pwd=:pwd WHERE per_num='.$idPersonne;
        $req = $this->db->prepare($sql);
        $req->bindValue(':login', $personne->getLogin(), PDO::PARAM_STR);
        $req->bindValue(':pwd',sha1(sha1($personne->getPwd()).SAL), PDO::PARAM_STR);
        $req->execute();
    }
    function deletePersonne($id){
        $sql = 'DELETE FROM personne WHERE per_num =' . $id;
        $req = $this->db->prepare($sql);
        $req->execute();
    }
}
