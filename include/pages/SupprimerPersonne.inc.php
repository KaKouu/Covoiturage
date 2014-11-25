<h1>Supprimer des personnes enregistrées</h1>
<?php
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être connecté pour pouvoir  supprimer les information de votre profils</p> 
    <a href="index.php?page=11">Connexion</a>
    <?php
} else {
    if (isset($_POST['supprimer'])) {
        ?>
        <p>Voulez vous vraiment supprimer vos données ? <br>
            <i>Attention cette action ne pourra etre reversible.</i></p>
        <form action="#" method="POST">
            <input type="submit" name="oui" id="oui" value="Oui">
            <input type="submit" name="non" id="non" value="Non">
        </form>
        <?php
    } else if (isset($_POST['oui'])) {
        $myPropositionManager = new ProposeManager($bdd);
        $myPersonneManager = new PersonneManager($bdd);
        //suppresion de tous les trajets ajoué par la personne
 
        if($myPersonneManager->isEtudiant($_SESSION['PersIdentifiee'])){
            $myEtudiantManager=new EtudiantManager($bdd);
            //Suppression des information au niveau de l'étudiant
        }else{
            $mySalarieManager = new SalarieManager($bdd);
            //supression les informations au niveau du salarie
        }
        //enfin suppression des information de personne
        
    } else if (isset($_POST['non'])) {
        header("location:index.php?page=0");
    } else {
        ?>
        <br>
        <form action="#" method="POST">
            <input type="submit" id="supprimer" name="supprimer" value="Supprimer toutes les informations">
        </form>
        <?php
    }
}