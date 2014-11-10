<?php
class EtudiantManager{
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($etudiant) {
        $myPersonneManager = new PersonneManager($this->db);
        $id = $myPersonneManager->add($etudiant);
         
        $req = $this->db->prepare('INSERT INTO etudiant (per_num,div_num, dep_num)'
                . 'VALUES(:per_num, :div_num,:dep_num)');
        $req->bindValue(':dep_num', $etudiant->getDep(), PDO::PARAM_INT);
        $req->bindValue(':div_num', $etudiant->getDiv(), PDO::PARAM_INT);
        $req->bindValue(':per_num', $id, PDO::PARAM_STR);
        $req->execute();
    }

    function getAllEtu() {
        $etudiant = array();
        $sql = 'SELECT * FROM etudiant';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        while ($etu = $req->fetch(PDO::FETCH_OBJ)) {
            $etudiant[] = new Etudiant($etu);
        }
        return $etudiant;
        $req->closeCursor();
    }
    
    function getEtuById($id) {
        $sql = 'SELECT * FROM etudiant e JOIN personne p ON e.per_num = p.per_num WHERE e.per_num ='.$id;
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $etudiant = new Etudiant($req->fetch(PDO::FETCH_OBJ));
        
        return $etudiant;
        
    }
	
}