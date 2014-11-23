<h1>Modifier votre profil utilisateur</h1>
<?php
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être connecté pour pouvoir vous modifier les information de votre profils</p> 
    <a href="index.php?page=11">Connexion</a>
    <a href="index.php?page=1">Inscrption</a>
    <?php
} else {
    ?>
    <h2>Modifier votre identité</h2>
    <form action="">
        <label for="" >Nom</label>
        <input type="text" name="nom" value="<?php echo $_SESSION['PersIdentifiee']->getNom(); ?>">
        <br>
        <label for="" >Prenom</label>
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
        <form action="">
            <label for="">Login</label>
            <input type="text" name="login" value="<?php echo $_SESSION['PersIdentifiee']->getLogin(); ?>">
            <br>
            <label for="">Mot de passe</label>
            <input type="password" name="mdp" value="De$0µl£">
            <br>
            <input type="submit" name="authetification" value="Mofifier">
        </form>
    <h2>Modifier votre statut</h2>
    <form>
        <label for="etudiant">Etudiant</label>
        <input type="radio" name="statut" id="etudiant" value="1" required>
        <label for="salarie">Salarié</label>
        <input type="radio" name="statut" id="salarie" value="2" required>
        <br>                                                     
        <input type="submit" name="status" value="Modifier" >
    </form>
    <?php
}
?>