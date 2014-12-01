<?php

class VilleManager {

    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($ville) {
        $req = $this->db->prepare('INSERT INTO ville (vil_num, vil_nom)'
                . 'VALUES(:vil_num, :vil_nom)');
        $req->bindValue(':vil_num', $ville->getVilNum(), PDO::PARAM_INT);
        $req->bindValue(':vil_nom', $ville->getVilNom(), PDO::PARAM_STR);
        $retour=$req->execute();
        $req->closeCursor();
        return $retour;
    }

    function getAllVille() {
        $ville = array();
        $sql = 'SELECT * FROM ville ORDER BY vil_nom';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        while ($vil = $req->fetch(PDO::FETCH_OBJ)) {
            $ville[] = new Ville($vil);
        }
        $req->closeCursor();
        return $ville;
        
    }

    function getVilleById($id) {
        $sql = 'SELECT * FROM ville WHERE vil_num=' . $id;
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $vil = $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        return new Ville($vil);
        
    }

    function existeVille($name) {
        $sql = "SELECT * FROM ville WHERE vil_nom='" . $name . "'";
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        if ($req->fetch())
            return true;
        return false;
    }

    function getVilleByName($name) {
        $ville = array();
        $sql = "SELECT * FROM ville WHERE vil_nom='" . $name . "'";
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $vil = $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        return new Ville($vil);
        
    }

}
