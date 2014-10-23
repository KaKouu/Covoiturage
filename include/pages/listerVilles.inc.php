<h1>Liste des villes</h1>
<?php
$myVilleManager = new VilleManager($bdd);
$villes = $myVilleManager->getAllVille();
?>
<table>
    <tr><th>Numéro</th><th>Villes</th></tr>
<?php
foreach ($villes as $values)
{
  echo '<tr><td>'.$values->getVilNum().'</td>';
  echo '<tr><td>'.$values->getVilNom().'</td></tr>';
}
?>
</table>
