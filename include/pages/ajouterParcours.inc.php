<?php
//on recupère les villes
$myVilleManager = new VilleManager($bdd);
$villes = $myVilleManager->getAllVille();
?>
<h1>Ajouter un parcours</h1>
<?php
if (empty($_POST['km']) or empty($_POST['ajouter']) or empty($_POST['ville1']) or empty($_POST['ville2'])) {
    ?>
    <form class="col-lg-6" action="#" method="POST">
        <div class="form-group">
            <label for='ville1'>Ville de départ</label>
            <select class="form-control" name="ville1" id="ville1">
                <option value="">Sélectionner une ville de départ</option>
                <?php
                foreach ($villes as $values) {
                    echo '<option value="' . $values->getVilNum() . '">' . $values->getVilNom() . '</option>' . "\n";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for='ville1'>Ville d'arrivé</label>
            <select class="form-control" name="ville2"  id="ville2">
                <option value="">Selectionner une ville d'arrivé</option>
                <?php
                foreach ($villes as $values) {
                    echo '<option  value="' . $values->getVilNum() . '">' . $values->getVilNom() . '</option>' . "\n";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="km">Nombre de kilomètres</label>
            <input class="form-control" type="number" id="km" name="km" required>
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" id="ajouter" name="ajouter" value="Ajouter"/>
        </div>
    </form>
<div class="col-lg-12">
    <p>La ville que vous chercher n'est pas présente ?
        <br>
        <a href="index.php?page=7" >Ajouter une ville</a>
    </p>
</div>
    <?php
} else {
    if ($_POST['ville1'] == $_POST['ville2']) {
        echo '<p><img src="image/erreur.png" alt="erreur" > Vous devez entrez deux villes différentes.</p>';
        echo "</p><a href='index.php?page=5'>Retour</a></p>";
    } else {
        $parcours = array(
            'par_num' => null,
            'par_km' => $_POST['km'],
            'vil_num1' => $_POST['ville1'],
            'vil_num2' => $_POST['ville2']
        );
        $myParcoursManager = new ParcoursManager($bdd);
        $myParcours = new Parcours($parcours);
        if ($myParcoursManager->getByVille($_POST['ville1'], $_POST['ville2'])->getParNum() == NULL) {
            $retour = $myParcoursManager->add($myParcours);
            if ($retour != 0) {
                echo '<p><img src="image/valid.png" alt="valide" > Le parcours a été ajouté.</p>';
            } else {
                echo '<p><img src="image/erreur.png" alt="erreur" > Erreur.</p>';
            }
        } else
            echo '<p><img src="image/erreur.png" alt="erreur" > Le parcours existe déjà.</p>';

        echo '<p><a href="?page=5">Retour</a></p>';
    }
}
