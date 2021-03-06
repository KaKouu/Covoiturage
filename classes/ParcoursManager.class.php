<?php

class ParcoursManager {

    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function add($parcours) {
        $req = $this->db->prepare('INSERT INTO parcours (par_num, par_km, vil_num1, vil_num2)'
                . 'VALUES(:par_num, :par_km, :vil_num1, :vil_num2)');
        $req->bindValue(':par_num', $parcours->getParNum(), PDO::PARAM_INT);
        $req->bindValue(':par_km', $parcours->getParKm(), PDO::PARAM_INT);
        $req->bindValue(':vil_num1', $parcours->getVilNum1(), PDO::PARAM_INT);
        $req->bindValue(':vil_num2', $parcours->getVilNum2(), PDO::PARAM_INT);
        $retour=$req->execute();
        $req->closeCursor();
        return $retour;
    }

    function getAllParcours() {
        $parcours = array();
        $sql = 'SELECT * FROM parcours';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        while ($par = $req->fetch(PDO::FETCH_OBJ)) {
            $parcours[] = new Parcours($par);
        }
        $req->closeCursor();
        return $parcours;
       
    }
    
    function getByVille($ville1, $ville2) {
        $parcours = array();
        $sql = 'SELECT * FROM parcours WHERE (vil_num1='.$ville1.' AND vil_num2='.$ville2.') OR (vil_num2='.$ville1.' AND vil_num1='.$ville2.')';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        $par = $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        return new Parcours($par);
       
    }
    function getAllVilleParcours(){
        $parcours = array();
        $sql = 'SELECT DISTINCT vil_num1 as vil_num, vil_nom 
                    FROM parcours p JOIN ville v ON p.vil_num1=v.vil_num 
                UNION 
                SELECT DISTINCT vil_num2 as vil_num, vil_nom  
                    FROM parcours p JOIN ville v ON p.vil_num2=v.vil_num';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        while ($par = $req->fetch(PDO::FETCH_ASSOC)) {
            $parcours[] = new Ville($par);
        }
        $req->closeCursor();
        return $parcours;
        
    }
    function getAllVilleInParcours($ville){
        $parcours = array();
        $sql = 'SELECT DISTINCT vil_num1 as vil_num ,vil_nom
                    FROM parcours p JOIN ville v ON p.vil_num1=v.vil_num 
                    WHERE vil_num1='.$ville.' OR vil_num2='.$ville.
                ' UNION SELECT DISTINCT vil_num2 as vil_num ,vil_nom 
                    FROM parcours  p 
                    JOIN ville v ON p.vil_num2=v.vil_num 
                    WHERE vil_num1='.$ville.' OR vil_num2='.$ville.'';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        while ($par = $req->fetch(PDO::FETCH_ASSOC)) {
            $parcours[] = new Ville($par);
        }
        $req->closeCursor();
        return $parcours;
    }
}
?>