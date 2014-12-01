
<h1>Ajouter une personne</h1>

<?php
if (isset($_POST['statut']) or isset($_POST['etudiant']) or isset($_POST['salarie'])) {
    if (isset($_POST['statut'])) {
        //verification si la personne n'existe pas déjà dans la base
        $personneControle = new PersonneManager($bdd);
        if ($personneControle->getPersByLogin($_POST['login'])->getNum() != NULL) {
            //par le login
            echo '<p>Le login existe déjà.</p>';
        } elseif ($personneControle->getPersByMail($_POST['mail'])->getNum() != NULL) {
            //par le mail
            echo '<p>Le mail est déjà utilisé.</p>';
        } elseif ($personneControle->getPersByName($_POST['nom'], $_POST['prenom'])->getNum() != NULL AND $personneControle->getPersByMail($_POST['mail'])->getNum() != NULL) {
            // par les nom, prenom et mail
            // on ne peut pas arreter le test au nom et au prenom de la personne 
            // du coup pour vérifier si elle est bien unique on vérifie aussi le mail
            echo '<p>Cette personne existe.</p>';
            echo'<p>Connectez-vous : <a href="?page=11">connexion</a></p>';
        } else {
            //la personne est bien unique
            $_SESSION['personne'] = array(
                'per_nom' => $_POST['nom'],
                'per_prenom' => $_POST['prenom'],
                'per_tel' => $_POST['tel'],
                'per_mail' => $_POST['mail'],
                'per_login' => $_POST['login'],
                'per_pwd' => $_POST['password']
            );
            if ($_POST['statut'] == 1) {
                //le statut est un statut etudiant
                $myDepartementManager = new DepartementManager($bdd);
                $departements = $myDepartementManager->getAllDep();
                $myDivisionManager = new DivisionManager($bdd);
                $division = $myDivisionManager->getAllDiv();
                ?>
                <form method="POST" action="#">
                    <select name="departement" id="departement">
                        <option value="">Selectionner un département</option>
                        <?php
                        foreach ($departements as $values) {
                            echo '<option value="' . $values->getDepNum() . '">' . $values->getDepNom() . '</option>' . "\n";
                        }
                        ?>
                    </select>
                    <select name="division" id="division">
                        <option value="">Selectionner votre classe</option>
                        <?php
                        foreach ($division as $values) {
                            echo '<option value="' . $values->getDivNum() . '">' . $values->getDivNom() . '</option>' . "\n";
                        }
                        ?>
                    </select>
                    <input type="submit" name="etudiant" value="Valider">
                </form>
                <?php
            } else {
                //le statut est salarié
                $myFonctionManager = new FonctionManager($bdd);
                $fonction = $myFonctionManager->getAllFonction();
                ?>
                <form method="POST" action="#">
                    <label for="sal_telprof">Téléphone professionnel :</label>
                    <input type="tel" name="sal_telprof" >
                    <br>
                    <label for="fonction">Votre fonction :</label>
                    <select name="fonction" id="fonction">
                        <?php
                        foreach ($fonction as $values) {
                            echo '<option value="' . $values->getNum() . '">' . $values->getLibelle() . '</option>' . "\n";
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" name="salarie" value="Valider">
                </form>
                <?php
            }
        }
    } elseif (isset($_POST['etudiant'])) {
        $personneControle = new PersonneManager($bdd);
        //on verifie si la personne n'existe pas de 2 façon
        if ($personneControle->getPersIdentification($_SESSION['personne']['per_login'], $_SESSION['personne']['per_pwd'])->getNum() == NULL and $personneControle->getPersByMail($_SESSION['personne']['per_mail'])->getNum() == NULL) {
            $myEtudiantManager = new EtudiantManager($bdd);
            $_SESSION['personne']['dep_num'] = $_POST['departement'];
            $_SESSION['personne']['div_num'] = $_POST['division'];
            $myEtudiant = new Etudiant($_SESSION['personne']);
            $retour = $myEtudiantManager->add($myEtudiant);
            if ($retour != 0) {
                echo'<p>Personne ajoutée.</p>';
                echo'<p>Vous pouvez maintenant vous connecter :<a href="?page=11">connexion</a>.</p>';
            } else {
                echo"<p>Erreur.</p>";
            }
        } else {
            echo '<p>Cette personne existe déjà</p>';
            echo'<p>Connectez-vous : <a href="?page=11">connexion</a></p>';
        }
    } else {
        $personneControle = new PersonneManager($bdd);
        //on verifie si la personne n'existe pas de 2 façons
        if ($personneControle->getPersIdentification($_SESSION['personne']['per_login'], $_SESSION['personne']['per_pwd'])->getNum() == NULL and $personneControle->getPersByMail($_SESSION['personne']['per_mail'])->getNum() == NULL) {
            $mySalarieManager = new SalarieManager($bdd);
            $_SESSION['personne']['sal_telprof'] = $_POST['sal_telprof'];
            $_SESSION['personne']['fon_num'] = $_POST['fonction'];
            $mySalarie = new Salarie($_SESSION['personne']);
            $retour = $mySalarieManager->add($mySalarie);
            if ($retour != 0) {
                echo'<p>Personne ajoutée.</p>';
                echo'<p>Vous pouvez maintenant vous connecter : <a href="?page=11">connexion</a>.</p>';
            } else {
                echo "<p>Erreur.</p>";
            }
        } else {
            echo '<p>Cette personne existe déjà.</p>';
            echo'<p>Connectez-vous : <a href="?page=11">connexion</a>.</p>';
        }
    }
} else {
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