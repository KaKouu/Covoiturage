<?php

class SalarieManager {

    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($salarie) {
        $req = $this->db->prepare('INSERT INTO salarie (per_num, sal_telprof, fon_num)'
                . 'VALUES(:per_num,:sal_telprof, :fon_num)');
        $req->bindValue(':per_num', $salarie->getPerNum(), PDO::PARAM_INT);
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

}
