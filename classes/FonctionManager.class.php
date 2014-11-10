<?php
class FonctionManager{
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($fonction) {
        $req = $this->db->prepare('INSERT INTO fonction (fon_num,fon_libelle)'
                . 'VALUES(:fon_num, :fon_libelle)');
        $req->bindValue(':fon_num', $fonction->getNum(), PDO::PARAM_INT);
        $req->bindValue(':fon_libelle', $fonction->getLibelle(), PDO::PARAM_STR);
        $req->execute();
    }

    function getAllFonction() {
        $fonction = array();
        $sql='SELECT * FROM fonction';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        while ($fon = $req->fetch(PDO::FETCH_OBJ)) {
            $fonction[] = new Fonction($fon);
        }
        return $fonction;
        $req->closeCursor();
    }
}