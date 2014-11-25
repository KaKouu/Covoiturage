<?php

class SalarieManager {

    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($salarie) {
        $myPersonneManager = new PersonneManager($this->db);
        $id = $myPersonneManager->add($salarie);
        $req = $this->db->prepare('INSERT INTO salarie (per_num, sal_telprof, fon_num)'
                . 'VALUES(:per_num,:sal_telprof, :fon_num)');
        $req->bindValue(':per_num', $id, PDO::PARAM_INT);
        $req->bindValue(':sal_telprof', $salarie->getTelProf(), PDO::PARAM_STR);
        $req->bindValue(':fon_num', $salarie->getNumFonc(), PDO::PARAM_INT);
        $req->execute();
    }

    function getAllSalarie() {
        $salarie = array();
        $sql = $this->db->prepare('SELECT * FROM salarie');
        $req = $this->db->query($sql);
        while ($sal = $req->fetch(PDO::FETCH_OBJ)) {
            $salarie[] = new Salarie($sal);
        }
        return $salarie;
        $req->closeCursor();
    }

    function getSalarieById($id) {
        $sql = 'SELECT * FROM salarie s JOIN personne p ON s.per_num=p.per_num WHERE s.per_num=' . $id;
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $salarie = new Salarie($req->fetch(PDO::FETCH_OBJ));
        $req->closeCursor();
        return $salarie;
    }
    function deleteSalarieById($id){
        $sql = 'DELETE FROM salarie WHERE per_num =' . $id;
        $req = $this->db->prepare($sql);
        $req->execute();
    }

}
