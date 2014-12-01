<h1>Liste des villes</h1>
<?php
//on utilise le manager pour aller chercher les villes
$myVilleManager = new VilleManager($bdd);
//on récupère toutes les villes
$villes = $myVilleManager->getAllVille();
?>
<table>
    <tr><th>Numéro</th><th>Villes</th></tr>
    <?php
    $i = 1;
//on affiche toutes les villes
    foreach ($villes as $values) {
        echo '<tr><td>' . $values->getVilNum() . '</td>';
        echo '<td>' . $values->getVilNom() . '</td></tr>';
        $i++;
    }
    ?>
</table>
