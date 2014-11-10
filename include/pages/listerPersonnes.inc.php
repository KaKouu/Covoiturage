
<h1>Liste des Personnes</h1>
<?php
$myPersonneManager = new PersonneManager($bdd);
if(isset($_GET['id']))
{
    if($myPersonneManager->isEtudiant($_GET['id']))
    {
        $myEtudiantManager = new EtudiantManager($bdd);
        
        $etudiant = $myEtudiantManager->getEtuById($_GET['id']);
        
        echo $etudiant->getPrenom()." ".$etudiant->getMail()." ".$etudiant->getTel()." ".$etudiant->getDep().'<br>';
    }
    else
    {
        $mySalarieManager = new SalarieManager($bdd);
        $salarie = $mySalarieManager->getSalarieById($_GET['id']);
        echo $salarie->getPrenom()." ".$salarie->getMail()." ".$salarie->getNum()."  ".$salarie->getNumFonc(). $salarie->getNumFonc().'<br>';
    }
}
else
{
    $personnes = $myPersonneManager->getAllPers();
    foreach ($personnes as $value) {
        echo '<a href=?page=2&id='.$value->getNum()."> ".$value->getNum()."</a> ".$value->getNom()." ".$value->getPrenom().'<br>';
    }

}