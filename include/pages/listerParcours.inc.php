<h1>lister les parcours</h1>
<?php
//on recupère les villes
$myVilleManager = new VilleManager($bdd);
$villes = $myVilleManager->getAllVille();

$myParcoursManager = new ParcoursManager($bdd);
$parcours = $myParcoursManager->getAllParcours();
?>
<p>Actuellement <?php echo count($parcours); ?> parcours sont enrgistrés</p>
<table>
    <tr><th>Numéro</th><th>Nom ille</th><th>Nom Ville</th><th> Nombre de kilomètre </th></tr>
    <?php
    $i = 1;
    foreach ($parcours as $values) {
        $ville1 = $myVilleManager->getVilleById($values->getVilNum1());
        $ville2 = $myVilleManager->getVilleById($values->getVilNum2());
        echo '<tr><td>' . $i . '</td>' . "\n";
        echo '<td>' . $ville1->getVilNom() . '</td>' . "\n";
        echo '<td>' . $ville2->getVilNom() . '</td>' . "\n";
        echo '<td>' . $values->getParKm() . ' km</td></tr>' . "\n";
        $i++;
    }
    ?>
</table>

