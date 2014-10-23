<?php
class ProposeManager{

    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($propose) {
        $req = $this->db->prepare('INSERT INTO propose (par_num, per_num, '
                . 'pro_date, pro_time, pro_place, pro_sens)'
                . 'VALUES(:par_num, :per_num,:pro_date, :pro_time, :pro_place, :pro_sens)');
        $req->bindValue(':par_num', $propose->getParNum(), PDO::PARAM_INT);
        $req->bindValue(':per_num', $propose->getPerNum(), PDO::PARAM_INT);
        $req->bindValue(':pro_date', $propose->getProDate(), PDO::PARAM_STR);
        $req->bindValue(':pro_time', $propose->getProTime(), PDO::PARAM_STR);
        $req->bindValue(':pro_place', $propose->getProPlace(), PDO::PARAM_INT);
        $req->bindValue(':pro_sens', $propose->getProSens(), PDO::PARAM_INT);
        $req->execute();
    }

    function getAllPropose() {
        $propose = array();
        $sql = $this->db->prepare('SELECT * FROM propose');
        $req = $this->db->query($sql);
        while ($pro = $req->fetch(PDO::FETCH_OBJ)) {
            $propose[] = new Propose($pro);
        }
        return $propose;
        $req->closeCursor();
    }
	

}