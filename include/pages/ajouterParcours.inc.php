<?php
//on recupère les villes
$myVilleManager = new VilleManager($bdd);
$villes = $myVilleManager->getAllVille();
?>
<h1>Ajouter un parcours</h1>
<?php
if (empty($_POST['km']) or empty($_POST['ajouter']) or empty($_POST['ville1']) or empty($_POST['ville2'])) {
    ?>
    <form action="#" method="POST">
        <label for='ville1'>Ville de départ : </label>
        <select name="ville1" id="ville1">
            <option value="">Sélectionner une ville de départ</option>
            <?php
            foreach ($villes as $values) {
                echo '<option value="' . $values->getVilNum() . '">' . $values->getVilNom() . '</option>' . "\n";
            }
            ?>
        </select>
        <br>
        <label for='ville1'>Ville d'arrivé : </label>
        <select name="ville2"  id="ville2">
            <option value="">Selectionner une ville d'arrivé</option>
            <?php
            foreach ($villes as $values) {
                echo '<option  value="' . $values->getVilNum() . '">' . $values->getVilNom() . '</option>' . "\n";
            }
            ?>
        </select>
        <br>
        <label for="km">Nombre de kilomètres</label>
        <input type="number" id="km" name="km"/>
        <br>
        <input type="submit" id="ajouter" name="ajouter" value="Ajouter"/>
    </form>
    <p>La ville que vous chercher n'est pas présente ?
        <br>
        <a href="index.php?page=7" >Ajouter une ville</a>
    </p>
    <?php
} else {
    if ($_POST['ville1'] == $_POST['ville2']) {
        echo 'Vous devez entrez deux villes différentes.</br>';
        echo "<a href='index.php?page=5'>Retour</a>";
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
            $myParcoursManager->add($myParcours);
            echo 'Le parcours a été ajouté.';
        } else
            echo 'Le parcours existe déjà.';

        echo '<p><a href="?page=5">Retour</a></p>';
    }
}
