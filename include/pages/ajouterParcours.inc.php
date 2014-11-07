<?php
    //on recupère les villes
    $myVilleManager = new VilleManager($bdd);
    $villes = $myVilleManager->getAllVille();
?>

<h1>Ajouter un parcours</h1>
<?php
if(empty($_POST['km']) or empty($_POST['ajouter']) or empty($_POST['ville1']) or empty($_POST['ville2']))
{
 ?>
<form action="#" method="POST">
    <label for='ville1'>Ville de départ : </label>
    <select name="ville1" id="ville1">
        <option value="">Selectionner une ville de départ</option>
        <?php
        foreach ($villes as $values)
        {
          echo '<option value="'.$values->getVilNum().'">'.$values->getVilNom().'</option>'."\n";
        }
        ?>
    </select>
    <br>
    <label for='ville1'>Ville d'arrivé : </label>
    <select name="ville2"  id="ville2">
        <option value="">Selectionner une ville d'arrivé</option>
        <?php
        foreach ($villes as $values)
        {
          echo '<option  value="'.$values->getVilNum().'">'.$values->getVilNom().'</option>'."\n";
        }
        ?>
    </select>
    <br>
    <label for="km">Nombre de kilometre</label>
    <input type="number" id="km" name="km"/>
    <br>
    <input type="submit" id="ajouter" name="ajouter" value="Ajouter"/>
</form>
<?php
}
else
{
   if($_POST['ville1'] == $_POST['ville2'])
   {
       echo 'Vous devez entrez deux villes différentes.</br>';
       echo "<a href='index.php?page=5'>Retour</a>";
   }
   else
   {
    $parcours = array(
       'par_num'=>null,
       'par_km'=>$_POST['km'],
       'vil_num1'=>$_POST['ville1'],
       'vil_num2'=>$_POST['ville2']
    ); 
    $myParcoursManager = new ParcoursManager($bdd);
    $myParcours = new Parcours($parcours);
    if( empty($myParcoursManager->getByVille($_POST['ville1'], $_POST['ville2'])) and empty($myParcoursManager->getByVille($_POST['ville2'], $_POST['ville1'])))
    {
     $myParcoursManager->add($myParcours);
     echo 'Le parcours a été ajouté.';
    }
    else
        echo 'Le parcours existe déjà.';
   }
}