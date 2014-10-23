<?php

class DivisionManager {

    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($division) {
        $req = $this->db->prepare('INSERT INTO division (div_num,div_nom)'
                . 'VALUES(:div_num,:div_nom)');
        $req->bindValue(':div_num', $division->getDivNum(), PDO::PARAM_INT);
        $req->bindValue(':div_nom', $division->getDivNom(), PDO::PARAM_STR);
        $req->execute();
    }

    function getAllDiv() {
        $division = array();
        $req = $this->db->prepare('SELECT * FROM division');
        $req = $this->db->query($sql);
        while ($div = $req->fetch(PDO::FETCH_OBJ)) {
            $division[] = new Division($div);
        }
        return $division;
        $req->closeCursor();
    }

}
