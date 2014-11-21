<h1>Proposer un trajet</h1>
<?php
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être authentifié pour pouvoir proposer un traget</p> 
    <a href="index.php?page=11">Connexion</a>
    <a href="index.php?page=1">Inscrption</a>
    <?php
} else {
    $villesParcours = array();
    $myTrajetManager = new ParcoursManager($bdd);
    $myVilleManager = new VilleManager($bdd);

    if (isset($_POST['vil_depart'])) {
        //la ville de depart à été selectionné
        $villesParcours = $myTrajetManager->getAllVilleInParcours($_POST['vil_depart']);
        ?>
    <p>Votre de ville de départ :<b> <?php echo $myVilleManager->getVilleById($_POST['vil_depart'])->getVilNom(); ?></b></p>
        <form>
            <label for='vil_arrive'>Ville d'arrivée : </label>
            <select name="vil_arrive" id="vil_arrive">
                <option value="">Selectionner une ville de départ</option>
                <?php
                foreach ($villesParcours as $values) {
                    if ($values != $_POST['vil_depart']) {
                        $ville = $myVilleManager->getVilleById($values);
                        echo '<option value="' . $values . '">' . $ville->getVilNom() . ' </option>' . "\n";
                    }
                }
                ?>
            </select>
            <br>
            <input type="hidden" id="vil_depart" name="vil_depart" value="">
            <label for="">Date de départ : </label>
            <input type="text" id="date_depat" name="date_depart"  value="<?php echo date("d/m/Y"); ?>">
            <br>
            <label for="">Heure de départ : </label>
            <input type="text" id="heure_depart" name="heure_depart" value="<?php echo date("H:i:s"); ?>">
            <br>
            <label for="">Nombre de place : </label>
            <input type="number" id="nb_place" name="nb_place" value="0">
            <br>
            <input type="submit" name="valider" id ="valider" value="Valider">
        </form>
        <?php
    } else {
        //formulaire de départ
        $villesParcours = $myTrajetManager->getAllVilleParcours();
        ?>
        <p>Selectionner le trajet que vous souhaité effectuer</p>
        <form action="#" method="POST" id="form_Tajet">
            <label for='vil_depart'>Ville de départ : </label>
            <select name="vil_depart" id="vil_depart" onchange="document.forms['form_Tajet'].submit();">
                <option value="">Selectionner une ville de départ</option>
                <?php
                foreach ($villesParcours as $values) {
                    $ville = $myVilleManager->getVilleById($values);
                    echo '<option value="' . $values . '">' . $ville->getVilNom() . ' </option>' . "\n";
                }
                ?>
            </select>
            <?php
        }
    }
    ?>
    