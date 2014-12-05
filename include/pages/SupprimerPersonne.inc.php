<h1>Supprimer des personnes enregistrées</h1>
<?php
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être connecté pour pouvoir supprimer les informations de votre profil</p> 
    <a class="btn btn-info" href="index.php?page=11">Connexion</a>
    <?php
} else {
    if (isset($_POST['supprimer'])) {
        //on lui demande si il veut vraiment supprimer ses données
        ?>
        <p>Voulez vous vraiment supprimer vos données ? <br>
            <i>Attention cette action est irreversible.</i></p>
        <form action="#" method="POST">
            <input class="btn btn-success" type="submit" name="oui" id="oui" value="Oui">
            <a class="btn btn-warning" href="index.php">Non</a>
        </form>
        <?php
    } else if (isset($_POST['oui'])) {
        //l'utilisateur a confirmé la suppression , on enclenche la procédure !
        $myPropositionManager = new ProposeManager($bdd);
        $myPersonneManager = new PersonneManager($bdd);
        //suppression de tous les trajets ajoutés par la personne
        $myPropositionManager->deletePropositionById($_SESSION['PersIdentifiee']->getNum());
 
        //Vérification du statut
        if($myPersonneManager->isEtudiant($_SESSION['PersIdentifiee']->getNum())){
            $myEtudiantManager=new EtudiantManager($bdd);
            //Suppression des informations au niveau de l'étudiant
            $myEtudiantManager->deleteEtudiantById($_SESSION['PersIdentifiee']->getNum());
        }else{
            $mySalarieManager = new SalarieManager($bdd);
            //supression les informations au niveau du salarie
            $mySalarieManager->deleteSalarieById($_SESSION['PersIdentifiee']->getNum());
        }
        //enfin suppression des informations de la personne
        $myPersonneManager->deletePersonne($_SESSION['PersIdentifiee']->getNum());
        session_destroy();
        echo '<p><img src="image/valid.png" alt="valide" > Toutes vos informations viennent d\'être supprimées du site</p>';
        
    } else {
        ?>
        <br>
        <form action="#" method="POST">
            <input class="btn btn-danger" type="submit" id="supprimer" name="supprimer" value="Supprimer toutes les informations">
        </form>
        <?php
    }
}