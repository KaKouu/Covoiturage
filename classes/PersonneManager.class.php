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
        $req->bindValue(':pwd', $personne->getPwd(), PDO::PARAM_STR);
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
    
    function isEtudiant($idPersonne)
    {
        $sql = 'SELECT * FROM etudiant WHERE per_num='.$idPersonne;
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $pers = $req->fetch(PDO::FETCH_OBJ);
        return !empty($pers);
    }
}
