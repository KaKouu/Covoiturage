<h1>Liste des villes</h1>
<?php
$myVilleManager = new VilleManager($bdd);
$villes = $myVilleManager->getAllVille();
?>
<table>
    <tr><th>Numéro</th><th>Villes</th></tr>
<?php
$i=1;
foreach ($villes as $values)
{
  echo '<tr><td>'.$i.'</td>';
  echo '<td>'.$values->getVilNom().'</td></tr>';
  $i++;
}
?>
</table>
