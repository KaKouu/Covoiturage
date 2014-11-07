
<h1>Ajouter une personne</h1>
<?php
if(empty($_POST['nom'])
   or empty($_POST['prenom'])
   or empty($_POST['mail'])
   or empty($_POST['login'])
   or empty($_POST['password'])
   or empty($_POST['statut'])
   or empty($_POST['continuer'])     
)
{
?>
<form method="POST" action="#">
    <label for="nom">Nom : </label>
    <input type="text" name="nom" id="nom" required>
    <br>
    <label for="prenom">Prénom : </label>
    <input type="text" name="prenom" id="prenom" required>
    <br>
    <label for="tel">Téléphone : </label>
    <input type="tel" name="tel" id="tel">
    <br>
    <label for="mail">Email : </label>
    <input type="email" name="mail" id="mail" required>
    <br>
    <label for="login">Login : </label>
    <input type="text" name="login" id="login" required>
    <br>
    <label for="password">Password : </label>
    <input type="password" name="password" id="password" required>
    <br>
    <p>Votre Statut : </p>
    <label for="etudiant">Etudiant</label>
    <input type="radio" name="statut" id="etudiant" value="1" required>
    <label for="salarie">Salarié</label>
    <input type="radio" name="statut" id="salarie" value="2" required>
    <br>                                                     
    <input type="submit" name="continuer" value="Continuer" >
</form>                        
<?php
}
else
{
    
    if($_POST['statut']==1)
    {
      $_SESSION['personne']= array (
        'per_nom'=> $_POST['nom'],
        'per_prenom' => $_POST['prenom'],
        'per_tel' => $_POST['tel'],
        'per_mail' => $_POST['mail'],
        'per_login' => $_POST['login'],
        'per_pwd' => $_POST['password']
      );
      $myDepartementManager = new DepartementManager($bdd);
    $departements = $myDepartementManager->getAllDep();
      ?>
<form method="POST" action="#">
    <select name="departement" id="departement">
        <option value="">Selectionner un département</option>
        <?php
        foreach ($departements as $values)
        {
          echo '<option value="'.$values->getDepNum().'">'.$values->getDepNom().'</option>'."\n";
        }
        ?>
    </select>
</form>
      <?php
    }
    else
    {
        
    }
}