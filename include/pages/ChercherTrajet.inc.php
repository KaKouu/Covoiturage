
<h1>Rechercher un trajet</h1>
<?php
require 'include/functions.inc.php';
$myVilleManager = new VilleManager($bdd);
$myTrajetManager = new ProposeManager($bdd);
if (isset($_POST['ville_de_depart'])) {
    if ($_POST['vil_depart'] != '') {
        ?>
        <p>Votre de ville de départ :<b> <?php echo $myVilleManager->getVilleById($_POST['vil_depart'])->getVilNom(); ?></b></p>
        <!--Formulaire pour le reste des information -->
        <form class="col-lg-6" action="#" method="POST" id="form_tajet">
            <div class="form-group">
                <label for='vil_arrive'>Ville d'arrivée</label>
                <select class="form-control" name="vil_arrive" id="vil_arrive">
                    <option value="">Selectionner une ville d'arrivée</option>
                    <?php
                    //Selection des villes qui ont une correspondance avec la ville de départ saisie
                    $villesParcours = $myTrajetManager->getVillesArrive($_POST['vil_depart']);
                    foreach ($villesParcours as $values) {
                        if ($values != $_POST['vil_depart']) {
                            echo '<option value="' . $values->getVilNum() . '">' . $values->getVilNom() . ' </option>' . "\n";
                        }
                    }
                    ?>
                </select>
            </div>
            <!--On stocke la ville de départ dans un champ caché-->
            <input type="hidden" id="vil_depart" name="vil_depart" value="<?php echo $_POST['vil_depart']; ?>">
            <div class="form-group">
                <label for="date_depat">Date de départ</label>
                <input class="form-control" type="text" id="date_depat" name="date_depart"  value="<?php echo date("d/m/Y"); ?>">
            </div>
            <div class="form-group">
                <label for="heure">A partir de</label>
                <select class="form-control" id="heure_depart" name="heure_depart">
                    <?php
                    // génération des heures dans le formulaire
                    for ($i = 0; $i < 25; $i++) {
                        echo '<option value="' . $i . '">' . sprintf('%02d', $i) . 'h</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="precision">Précision :</label>
                <select class="form-control" id="precision" name="precision">
                    <option value="0"> Ce jour</option>
                    <option value="1"> +/- 1 jour</option>
                    <option value="2"> +/- 2 jours</option>
                    <option value="3"> +/- 3 jours</option>
                </select>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="rechercher_trajet" id ="rechercher_trajet" value="Rechercher">
            </div>
        </form>
        <?php
    } else {
        //si la ville n'a pas été choisie
        header("location:index.php?page=10");
    }
} elseif (isset($_POST['rechercher_trajet'])) {
    //formatage de la date
    $date = getEnglishDate($_POST['date_depart']);
    $correspondance = $myTrajetManager->getPropositionByVille($_POST['vil_depart'], $_POST['vil_arrive'], $_POST['heure_depart'], $_POST['precision'], $date);
    if (!empty($correspondance)) {
        $myVilleManager = new VilleManager($bdd);
        $myPersonneManager = new PersonneManager($bdd);
        ?>
        <table class="table table table-bordered table-striped table-condensed">
            <tr>
                <th>Ville Départ</th>
                <th>Ville Arrivée</th>
                <th>Date Départ</th>
                <th>Heure Départ</th>
                <th>Nombre de place</th>
                <th>Nom du conducteur</th>
            </tr>
            <?php
            foreach ($correspondance as $trajet) {
                //on récupère la ville de départ
                $depart = $myVilleManager->getVilleById($trajet['depart']);
                //on récupère la ville d'arrive
                $arrive = $myVilleManager->getVilleById($trajet['arrivee']);
                //on récupère le nom du conducteur
                $conducteur = $myPersonneManager->getPersById($trajet['personne']);
                echo '<tr>';
                echo '<td>' . $depart->getVilNom() . '</td>';
                echo '<td>' . $arrive->getVilNom() . '</td>';
                echo '<td>' . $trajet['date'] . '</td>';
                echo '<td>' . $trajet['heure'] . '</td>';
                echo '<td>' . $trajet['place'] . '</td>';
                echo '<td>' . $conducteur->getNom() . '</td>';
                echo '</tr>';
            }
            ?>
        </table> 
        <?php
    } else {
        echo '<p>Désolé, pas de trajet disponible</p>';
    }
    echo '<p><a href="?page=10">Retour</a></p>';
} else {
    $villesParcours = $myTrajetManager->getAllVilleDepart();
    ?>
    <form  class="col-lg-6" action="#" method="POST">
        <div class="form-group">
            <label for="vil_depart">Votre ville de départ</label>
            <select class="form-control" name="vil_depart" id="vil_depart">
                <option value="">Choissisez une ville de départ</option>
                <?php
                foreach ($villesParcours as $values) {
                    echo '<option value="' . $values->getVilNum() . '">' . $values->getVilNom() . ' </option>' . "\n";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" id="ville_de_depart" name="ville_de_depart" value="Valider">
        </div>
    </form>
    <?php
}