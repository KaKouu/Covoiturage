<?php
class VilleManager{
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($ville) {
        $req = $this->db->prepare('INSERT INTO ville (vil_num, vil_nom)'
                . 'VALUES(:vil_num, :vil_nom)');
        $req->bindValue(':vil_num', $ville->getVilNum(), PDO::PARAM_INT);
        $req->bindValue(':vil_nom', $ville->getVilNom(), PDO::PARAM_STR);
        $req->execute();
    }

    function getAllVille() {
        $ville = array();
        $sql = $this->db->prepare('SELECT * FROM ville');
        $req = $this->db->query($sql);
        while ($vil = $req->fetch(PDO::FETCH_OBJ)) {
            $ville[] = new Ville($vil);
        }
        return $ville;
        $req->closeCursor();
    }	
}