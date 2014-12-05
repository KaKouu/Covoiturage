
<h1>Ajouter une personne</h1>

<?php
if (isset($_POST['statut']) or isset($_POST['etudiant']) or isset($_POST['salarie'])) {
    if (isset($_POST['statut'])) {
        //verification si la personne n'existe pas déjà dans la base
        $personneControle = new PersonneManager($bdd);
        if ($personneControle->getPersByLogin($_POST['login'])->getNum() != NULL) {
            //par le login
            echo '<p><img src="image/erreur.png" alt="erreur" > Le login existe déjà.</p>';
        } elseif ($personneControle->getPersByMail($_POST['mail'])->getNum() != NULL) {
            //par le mail
            echo '<p><img src="image/erreur.png" alt="erreur" > Le mail est déjà utilisé.</p>';
        } elseif ($personneControle->getPersByName($_POST['nom'], $_POST['prenom'])->getNum() != NULL AND $personneControle->getPersByMail($_POST['mail'])->getNum() != NULL) {
            // par les nom, prenom et mail
            // on ne peut pas arreter le test au nom et au prenom de la personne 
            // du coup pour vérifier si elle est bien unique on vérifie aussi le mail
            echo '<p><img src="image/erreur.png" alt="erreur" > Cette personne existe.</p>';
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
                <form class="col-lg-6" method="POST" action="#">
                    <div class="form-group">
                        <label for="departement">Votre département</label>
                        <select class="form-control" name="departement" id="departement">
                            <?php
                            foreach ($departements as $values) {
                                echo '<option value="' . $values->getDepNum() . '">' . $values->getDepNom() . '</option>' . "\n";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="departement">Votre division</label>
                        <select class="form-control" name="division" id="division">
                            <?php
                            foreach ($division as $values) {
                                echo '<option value="' . $values->getDivNum() . '">' . $values->getDivNom() . '</option>' . "\n";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="etudiant" class="btn btn-primary" value="Valider">
                    </div>
                </form>
                <?php
            } else {
                //le statut est salarié
                $myFonctionManager = new FonctionManager($bdd);
                $fonction = $myFonctionManager->getAllFonction();
                ?>
                <form class="col-lg-6" method="POST" action="#">
                    <div class="form-group">
                        <label for="sal_telprof">Téléphone professionnel</label>
                        <input class="form-control" type="tel" name="sal_telprof" required>
                    </div>
                    <div class="form-group">
                        <label for="fonction">Votre fonction</label>
                        <select class="form-control" name="fonction" id="fonction">
                            <?php
                            foreach ($fonction as $values) {
                                echo '<option value="' . $values->getNum() . '">' . $values->getLibelle() . '</option>' . "\n";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="salarie" value="Valider">
                    </div>
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
                echo'<p><img src="image/valid.png" alt="valide" > Personne ajoutée.</p>';
                echo'<p>Vous pouvez maintenant vous connecter : <a href="?page=11">Connexion</a>.</p>';
            } else {
                echo'<p><img src="image/erreur.png" alt="erreur" > Erreur.</p>';
            }
        } else {
            echo '<p><img src="image/erreur.png" alt="erreur" > Cette personne existe déjà</p>';
            echo'<p>Connectez-vous : <a href="?page=11">Connexion</a></p>';
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
                echo'<p><img src="image/valid.png" alt="valide" > Personne ajoutée.</p>';
                echo'<p>Vous pouvez maintenant vous connecter : <a href="?page=11">Connexion</a>.</p>';
            } else {
                echo '<p><img src="image/erreur.png" alt="erreur" > Erreur.</p>';
            }
        } else {
            echo '<p><img src="image/erreur.png" alt="erreur" > Cette personne existe déjà.</p>';
            echo'<p>Connectez-vous : <a href="?page=11">Connexion</a>.</p>';
        }
    }
} else {
    ?>      
    <form class="col-lg-6"  method="POST" action="#">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input class="form-control" type="text" name="nom" id="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input class="form-control" type="text" name="prenom" id="prenom" required>
        </div>
        <div class="form-group">
            <label for="tel">Téléphone</label>
            <input class="form-control" type="tel" name="tel" id="tel">
        </div>
        <div class="form-group">
            <label for="mail">Email</label>
            <input class="form-control" type="email" name="mail" id="mail" required>
        </div>
        <div class="form-group">
            <label for="login">Login</label>
            <input class="form-control" type="text" name="login" id="login" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" required>
        </div>
        <p>Votre Statut : </p>
        <div class="form-group">
            <label for="etudiant">Etudiant</label>
            <input type="radio" name="statut" id="etudiant" value="1" checked>        
            <label for="salarie">Salarié</label>
            <input class="form-"type="radio" name="statut" id="salarie" value="2" >
        </div>     
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="continuer" value="Continuer" >
        </div>
    </form>
    <?php
}