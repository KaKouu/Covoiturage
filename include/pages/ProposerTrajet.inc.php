<h1>Proposer un trajet</h1>
<?php
require 'include/functions.inc.php';
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être authentifié pour pouvoir proposer un trajet.</p> 
    <a class="btn btn-info" href="index.php?page=11">Connexion</a>
    <a class="btn btn-info" href="index.php?page=1">Inscrption</a>
    <?php
} else {

    $villesParcours = array();
    $myTrajetManager = new ParcoursManager($bdd);
    $myVilleManager = new VilleManager($bdd);

    if (isset($_POST['vil_depart'])) {
        //la ville de depart a été selectionnée
        if ($_POST['vil_depart'] != '') {
            ?>
            <p>Votre de ville de départ<b> 
                    <?php echo $myVilleManager->getVilleById($_POST['vil_depart'])->getVilNom(); ?></b></p>
            <form class="col-lg-6" action="#" method="POST" id="form_Tajet">
                <div class="form-group">
                    <label for='vil_arrive'>Ville d'arrivée</label>
                    <select class="form-control" name="vil_arrive" id="vil_arrive">
                        <option value="">Selectionner une ville d'arrivée</option>
                        <?php
                        $villesParcours = $myTrajetManager->getAllVilleInParcours($_POST['vil_depart']);
                        foreach ($villesParcours as $values) {
                            if ($values->getVilNum() != $_POST['vil_depart']) {
                                echo '<option value="' . $values->getVilNum() . '">' . $values->getVilNom() . ' </option>' . "\n";
                            }
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" id="ville_depart" name="ville_depart" value="<?php echo $_POST['vil_depart']; ?>">
                <div class="form-group">
                    <label for="date_depat">Date de départ</label>
                    <input class="form-control" type="text" id="date_depat" name="date_depart"  value="<?php echo date("d/m/Y"); ?> " required>
                </div>
                <div class="form-group">
                    <label for="heure_depart">Heure de départ</label>
                    <input class="form-control" type="text" id="heure_depart" name="heure_depart" value="<?php echo date("H:i:s"); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nb_place">Nombre de place</label>
                    <input class="form-control" type="number" id="nb_place" name="nb_place" value="0" required>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="ajouter_trajet" id ="ajouter_trajet" value="Ajouter" >
                </div>
            </form>
            <?php
        } else {
            header("location:index.php?page=9");
        }
    } elseif (isset($_POST['ajouter_trajet'])) {
        if (empty($_POST['ville_depart']) or empty($_POST['vil_arrive']) or empty($_POST['date_depart']) or empty($_POST['heure_depart']) or !isset($_POST['nb_place'])) {
            echo"Votre formulaire est mal rempli. ";
        } else {
            //formatage de la date
            $date_format = explode('/', $_POST['date_depart']);
            //verification du format
            if (count($date_format) > 2 and count($date_format) <= 3) {
                $date = getEnglishDate($_POST['date_depart']);
            }
            if ($_POST['nb_place'] <= 0) {
                echo '<p>Vous ne pouvez pas faire du covoiturage tout seul, acceptez au moins une personne.</p>';
            } else if (count($date_format) <= 2 or count($date_format) > 3) {
                echo "<p>Votre format de date est mauvais.</p>";
            } else if (strtotime($date) < strtotime(date("Y-m-d"))) {
                echo "<p>Vous ne pouvez pas covoiturer à une date antérieure à aujourd'hui</p>";
            } else {
                $parcours = $myTrajetManager->getByVille($_POST['ville_depart'], $_POST['vil_arrive']);
                if ($parcours->getVilNum1() == $_POST['ville_depart']) {
                    $sens = 0;
                } else {
                    $sens = 1;
                }
                $trajet = array(
                    'per_num' => $_SESSION['PersIdentifiee']->getNum(),
                    'pro_date' => date("Y-m-d", strtotime(str_replace("/", "-", $_POST['date_depart']))),
                    'pro_time' => $_POST['heure_depart'],
                    'pro_place' => $_POST['nb_place'],
                    'par_num' => $parcours->getParNum(),
                    'pro_sens' => $sens
                );

                $myPropositionManager = new ProposeManager($bdd);
                $myPropose = new Propose($trajet);

                $ajout = $myPropositionManager->add($myPropose);
                if ($ajout != 0)
                    echo "<p>Le trajet a bien été ajouté.</p>";
                else
                    echo "Erreur";
            }
        }
    } else {
        //formulaire de départ
        $villesParcours = $myTrajetManager->getAllVilleParcours();
        ?>
        <p>Sélectionner le trajet que vous souhaitez effectuer</p>
        <form class="col-lg-6" action="#" method="POST" id="form_Tajet">
            <div class="form-group">
                <label  for='vil_depart'>Ville de départ</label>
                <select class="form-control" name="vil_depart" id="vil_depart" onchange="document.forms['form_Tajet'].submit();">
                    <option value="">Sélectionner une ville de départ</option>
                    <?php
                    foreach ($villesParcours as $values) {
                        echo '<option value="' . $values->getVilNum() . '">' . $values->getVilNom() . ' </option>' . "\n";
                    }
                    ?>
                </select>
            </div>
        </form>
        <?php
    }
}
?>
    