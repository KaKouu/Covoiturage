
<h1>Ajouter une personne</h1>

<?php
if(isset($_POST['statut']) or isset($_POST['etudiant']) or isset($_POST['salarie']))
{
    if(isset($_POST['statut'])) 
    {
        $_SESSION['personne']= array (
            'per_nom'=> $_POST['nom'],
            'per_prenom' => $_POST['prenom'],
            'per_tel' => $_POST['tel'],
            'per_mail' => $_POST['mail'],
            'per_login' => $_POST['login'],
            'per_pwd' => $_POST['password']
          );
        if($_POST['statut']==1)
        {
          
        $myDepartementManager = new DepartementManager($bdd);
        $departements = $myDepartementManager->getAllDep();
        $myDivisionManager = new DivisionManager($bdd);
        $division = $myDivisionManager->getAllDiv();
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

                <select name="division" id="division">
                    <option value="">Selectionner votre classe</option>
                    <?php
                    foreach ($division as $values)
                    {
                      echo '<option value="'.$values->getDivNum().'">'.$values->getDivNom().'</option>'."\n";
                    }
                    ?>
                </select>

                <input type="submit" name="etudiant" value="Valider">
            </form>
          <?php
        }
        else
        {
            $myFonctionManager = new FonctionManager($bdd);
            $fonction = $myFonctionManager->getAllFonction();
            ?>
            <form method="POST" action="#">
                <input type="tel" name="sal_telprof" >
                <select name="fonction" id="fonction">
                    <option value="0">Selectionner votre fonction</option>
                    <?php
                    foreach ($fonction as $values)
                    {
                      echo '<option value="'.$values->getNum().'">'.$values->getLibelle().'</option>'."\n";
                    }
                    ?>
                </select>

                <input type="submit" name="salarie" value="Valider">
            </form>
            <?php
        }
    }
    else
    {
        
        if(isset($_POST['etudiant']))
        {
            $myEtudiantManager = new EtudiantManager($bdd);
            $_SESSION['personne']['dep_num']= $_POST['departement'];
            $_SESSION['personne']['div_num']= $_POST['division'];
            $myEtudiant = new Etudiant($_SESSION['personne']);
            $myEtudiantManager ->add($myEtudiant);
            
            
        }
        elseif(isset($_POST['salarie']))
        {
            $mySalarieManager = new SalarieManager($bdd);
            $_SESSION['personne']['sal_telprof'] = $_POST['sal_telprof'];
            $_SESSION['personne']['fon_num'] = $_POST['fonction'];
            $mySalarie  = new Salarie($_SESSION['personne']);
            $mySalarieManager->add($mySalarie);
        }
        else
        {
            
        }
    }
}
else
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