<?php
class DepartementManager{
    private $db;
    
    function __construct($db){
        $this->db = $db; 
    }
    function add($departement){
        $req = $this->db->prepare('INSERT INTO departement (dep_num,dep_nom,vil_num)'
                . 'VALUES(:dep_num,:dep_nom,:vil_num)');
        $req->bindValue(':dep_num',$departement->getDepNum(), PDO::PARAM_INT);
        $req->bindValue(':dep_nom',$departement->getDepNom(), PDO::PARAM_STR);
        $req->bindValue(':vil_num',$departement->getVilNum(), PDO::PARAM_INT);
        $req -> execute();
    }
    function getAllDep(){
       $departement= array();
       $sql = 'SELECT * FROM departement';
        $req = $this->db->prepare($sql);
        $req = $this->db->query($sql);
        while($dep = $req ->fetch(PDO::FETCH_OBJ))
        {
            $departement[]= new Departement($dep);
        }
        return $departement;
        $req -> closeCursor();
        
    }
	
}