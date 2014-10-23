<?php
class EtudiantManager{
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($etudiant) {
        $req = $this->db->prepare('INSERT INTO etudiant (per_num,div_num, dep_num)'
                . 'VALUES(:per_num, :div_num,:dep_num)');
        $req->bindValue(':dep_num', $etudiant->getDep(), PDO::PARAM_INT);
        $req->bindValue(':div_num', $etudiant->getDiv(), PDO::PARAM_INT);
        $req->bindValue(':per_num', $etudiant->getNum(), PDO::PARAM_STR);
        $req->execute();
    }

    function getAllEtu() {
        $etudiant = array();
        $sql = $this->db->prepare('SELECT * FROM etudiant');
        $req = $this->db->query($sql);
        while ($etu = $req->fetch(PDO::FETCH_OBJ)) {
            $etudiant[] = new Etudiant($etu);
        }
        return $etudiant;
        $req->closeCursor();
    }
	
}