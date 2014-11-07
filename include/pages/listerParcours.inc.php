<h1>lister les parcours</h1>
<?php

 //on recupère les villes
 $myVilleManager = new VilleManager($bdd);
 $villes = $myVilleManager->getAllVille();

$myParcoursManager = new ParcoursManager($bdd);
$parcours = $myParcoursManager->getAllParcours();
?>
<table>
    <tr><th> Ville Départ </th><th> --> </th><th> Ville Arrivé </th><th> Nombre de kilomètre </th></tr>
<?php
foreach ($parcours as $values)
{
  $ville1 = $myVilleManager->getVilleById($values->getVilNum1());
  $ville2 = $myVilleManager->getVilleById($values->getVilNum2());
  echo '<tr><td>'.$ville1->getVilNom().'</td>'."\n";
  echo '<td> --> </td>'."\n";
  echo '<td>'.$ville2->getVilNom().'</td>'."\n";
  echo '<td>'.$values->getParKm().' km</td></tr>'."\n";
}
?>
</table>