<h1>Ajouter une ville</h1>
<?php 
    if(empty($_POST['nomVille']) and empty($_POST['ajouter']))
    {
?>
<form action="#" method="POST">
    <label for="nomVille">Nom de la ville :</label>
    <input type="text" id="nomVille" name="nomVille">
    <input type="submit" id="ajouter" value="Ajouter">
</form>
<?php
}
else
{
    $ville=array(
        'vil_num' => null,
        'vil_nom'=>$_POST['nomVille']
    );
    $maVille= new Ville($ville);
    $myVilleManager = new VilleManager($bdd);
    $myVilleManager->add($maVille);
}
?>