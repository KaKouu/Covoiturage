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
    function deletePropositionById($id){
        $sql = 'DELETE FROM propose WHERE per_num =' . $id;
        $req = $this->db->prepare($sql);
        $req->execute();
    }
    
    function getAllVilleDepart(){
        $villes= array();
        $sql="SELECT DISTINCT vil_num1 AS vil_num ,vil_nom
                FROM propose p 
                JOIN parcours par ON p.par_num = par.par_num 
                JOIN ville v ON par.vil_num1=v.vil_num 
                WHERE pro_sens = 0
            UNION
            SELECT DISTINCT vil_num2 AS vil_num ,vil_nom
                FROM propose p 
                JOIN parcours par ON p.par_num = par.par_num 
                JOIN ville v ON par.vil_num2=v.vil_num 
                WHERE pro_sens = 1";
        $req=$this->db->prepare($sql);
        $req = $this->db->query($sql);
         while ($ville = $req->fetch(PDO::FETCH_ASSOC)) {
            $villes[] = new Ville($ville);
        }
        return $villes;
    }
    
    function getVillesArrive($idVille){
        $villes= array();
        $sql="SELECT DISTINCT vil_num2 AS vil_num ,vil_nom
                FROM propose p 
                JOIN parcours par ON p.par_num = par.par_num 
                JOIN ville v ON par.vil_num2=v.vil_num 
                WHERE pro_sens = 0 AND vil_num1=".$idVille."
            UNION
            SELECT DISTINCT vil_num1 AS vil_num ,vil_nom
                FROM propose p 
                JOIN parcours par ON p.par_num = par.par_num 
                JOIN ville v ON par.vil_num1=v.vil_num 
                WHERE pro_sens = 1 AND vil_num2=".$idVille;
        $req=$this->db->prepare($sql);
        $req = $this->db->query($sql);
         while ($ville = $req->fetch(PDO::FETCH_ASSOC)) {
            $villes[] = new Ville($ville);
            print_r($ville);
        }
        return $villes;
    }
    function getPropositionByVille($vDepart,$vArrive,$heure,$intervale,$date){
        $trajets=array();
        $sql="SELECT p.par_num, per_num AS personne, vil_num1 AS depart, vil_num2 AS arrivee ,
            DATE_FORMAT(pro_date,'%d/%m/%Y') AS date, pro_time AS heure,pro_place AS place 
                FROM propose p 
                JOIN parcours par ON p.par_num = par.par_num 
                WHERE vil_num1 = ".$vDepart." AND vil_num2 =  ".$vArrive." AND pro_sens = 0
                    AND HOUR(pro_time)>=".$heure." 
                    AND pro_date BETWEEN '".$date."' AND DATE_ADD('".$date."', INTERVAL ".$intervale." DAY)
            UNION
            SELECT p.par_num, per_num AS personne, vil_num2 AS depart, vil_num1 AS arrivee , 
            DATE_FORMAT(pro_date,'%d/%m/%Y') AS date, pro_time AS heure,pro_place AS place
                FROM propose p 
                JOIN parcours par ON p.par_num = par.par_num 
                WHERE vil_num1 = ".$vArrive." AND vil_num2 =  ".$vDepart." AND pro_sens = 1
                    AND HOUR(pro_time)>=".$heure."
                    AND pro_date BETWEEN '".$date."' AND DATE_ADD('".$date."', INTERVAL ".$intervale." DAY)";
        $req=$this->db->prepare($sql);
        $req = $this->db->query($sql);
         while ($trajet = $req->fetch(PDO::FETCH_ASSOC)) {
            $trajets[] = $trajet;
        }
        return $trajets;
    }
	
    /*
     SELECT * FROM
(SELECT p.par_num, per_num AS personne, vil_num1 AS depart, vil_num2 AS arrive , pro_date AS date, pro_time AS heure FROM propose p 
	JOIN parcours par ON p.par_num = par.par_num 
    WHERE vil_num1 = 10 AND vil_num2 = 11 AND pro_sens = 0
UNION
SELECT p.par_num, per_num, vil_num1 AS depart, vil_num2 AS arrive , pro_date, pro_time FROM propose p 
	JOIN parcours par ON p.par_num = par.par_num 
    WHERE vil_num1 = 10 AND vil_num2 = 11 AND pro_sens = 1) t

JOIN personne p ON p.per_num = t.personne JOIN ville v1 ON v1.vil_num =t.depart JOIN ville v2 ON v2.vil_num =t.arrive 
     */
}