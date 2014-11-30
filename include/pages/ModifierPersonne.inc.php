<h1>Modifier votre profil utilisateur</h1>
<?php
$personneControle = new PersonneManager($bdd);
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être connecté pour pouvoir modifier les informations de votre profil</p> 
    <a href="index.php?page=11">Connexion</a>
    <a href="index.php?page=1">Inscrption</a>
    <?php
} else {
    if (isset($_POST['identite']) or isset($_POST['authentification'])) {
        //si la personne souhaite modifier une information
        if (isset($_POST['identite'])) {
            $controle = true;
            //on vérifie si il y a eu un changement dans le formulaire
            if ($_POST['nom'] != $_SESSION['PersIdentifiee']->getNom() or
                    $_POST['prenom'] != $_SESSION['PersIdentifiee']->getPrenom() or
                    $_POST['mail'] != $_SESSION['PersIdentifiee']->getMail() or
                    $_POST['tel'] != $_SESSION['PersIdentifiee']->getTel()) {
                // la personne a modifié une info
                //la personne souhaite modifier un renseignement sur son identité
                if ($_POST['mail'] != $_SESSION['PersIdentifiee']->getMail()) {
                    // l'utilisateur souhaite modifier son mail
                    //on verifie si il est disponible
                    if ($personneControle->getPersByMail($_POST['mail'])->getNum()!= NULL) {
                        //le mail existe déja
                        $controle=false;
                        echo "<p>Le mail est déjà utilisé par une autre personne</p>";
                    } else {
                        //le mail est libre, on le modifie dans l'objet
                        $_SESSION['PersIdentifiee']->setMail($_POST['mail']);
                    }
                }
                //les tests sont finis
                //on verifie s'il n'y a pas eu d'erreur
                if ($controle) {
                    //on modifie les données
                    $_SESSION['PersIdentifiee']->setNom($_POST['nom']);
                    $_SESSION['PersIdentifiee']->setPrenom($_POST['prenom']);
                    $_SESSION['PersIdentifiee']->setTel($_POST['tel']);
                    //on update la bdd
                    $personneControle->setPersonneIdentite($_SESSION['PersIdentifiee'], $_SESSION['PersIdentifiee']->getNum());
                    //toutes les modifications ont été effectuées
                    echo '<p>Modification(s) effectuée(s).</p>';
                }
            }
        } else {
            $controle=true;
            //modification des infos de connexion : login et mdp
            if ($_POST['login'] != $_SESSION['PersIdentifiee']->getLogin() or $_POST['mdp'] != "De$0µl£") {
                //une information a été changée
                if ($_POST['login'] != $_SESSION['PersIdentifiee']->getLogin()) {
                    // le login a été modifié
                    //on verifie si il n'existe pas dans la bdd
                    if ($personneControle->getPersByLogin($_POST['login'])->getNum() != NULL) {
                        //le login est déja dans la base de données
                        $controle=false;
                        echo '<p>Le login existe déja.</p>';
                    } else {
                        //le login est libre
                        $_SESSION['PersIdentifiee']->setLogin($_POST['login']);
                    }
                }
                if (sha1(sha1($_POST['mdp'].SAL)) != $_SESSION['PersIdentifiee']->getPwd() ) {
                    //le mot de passe a été modifié
                    $_SESSION['PersIdentifiee']->setPwd($_POST['mdp']);
                }
                //update dans la bdd
                if ($controle) {                 
                    //on update la bdd
                    $personneControle->setPersonneConnexion($_SESSION['PersIdentifiee'], $_SESSION['PersIdentifiee']->getNum());
                    //toutes les modifications ont été effectuées
                    echo '<p>Modification(s) effectuée(s).</p>';
                }
            }
        }
    }
    ?>
    <h2>Modifier votre identité</h2>
    <form action="#" method="POST">
        <label for="" >Nom</label>
        <input type="text" name="nom" value="<?php echo $_SESSION['PersIdentifiee']->getNom(); ?>">
        <br>
        <label for="" >Prénom</label>
        <input type="text" name="prenom"  value="<?php echo $_SESSION['PersIdentifiee']->getPrenom(); ?>">
        <br>
        <label for="" >Mail</label>
        <input type="text" name="mail"  value="<?php echo $_SESSION['PersIdentifiee']->getMail(); ?>">
        <br>
        <label for="" >Téléphone</label>
        <input type="text" name="tel" value="<?php echo $_SESSION['PersIdentifiee']->getTel(); ?>">
        <br>
        <input type="submit" name="identite" value="Modifier">
    </form>
    <h2>Modifier vos informations de connexion</h2>
    <form action="#" method="POST">
        <label for="">Login</label>
        <input type="text" name="login" value="<?php echo $_SESSION['PersIdentifiee']->getLogin(); ?>">
        <br>
        <label for="">Mot de passe</label>
        <input type="password" name="mdp" value="De$0µl£">
        <br>
        <input type="submit" name="authentification" value="Modifier">
    </form>
    <?php
}
?>