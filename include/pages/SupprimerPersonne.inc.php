<h1>Supprimer des personnes enregistrées</h1>
<?php
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être connecté pour pouvoir supprimer les informations de votre profil</p> 
    <a href="index.php?page=11">Connexion</a>
    <?php
} else {
    if (isset($_POST['supprimer'])) {
        //on lui demande si il veut vraiment supprimer ses données
        ?>
        <p>Voulez vous vraiment supprimer vos données ? <br>
            <i>Attention cette action est irreversible.</i></p>
        <form action="#" method="POST">
            <input type="submit" name="oui" id="oui" value="Oui">
            <input type="submit" name="non" id="non" value="Non">
        </form>
        <?php
    } else if (isset($_POST['oui'])) {
        //l'utilisateur a confirmé la suppression , on enclenche la procédure !
        $myPropositionManager = new ProposeManager($bdd);
        $myPersonneManager = new PersonneManager($bdd);
        //suppression de tous les trajets ajoutés par la personne
 
        //Vérification du statut
        if($myPersonneManager->isEtudiant($_SESSION['PersIdentifiee']->getNum())){
            $myEtudiantManager=new EtudiantManager($bdd);
            //Suppression des informations au niveau de l'étudiant
        }else{
            $mySalarieManager = new SalarieManager($bdd);
            //supression les informations au niveau du salarie
        }
        //enfin suppression des informations de la personne
        
        
    } else if (isset($_POST['non'])) {
        //on redirige vers la page d'accueil'
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