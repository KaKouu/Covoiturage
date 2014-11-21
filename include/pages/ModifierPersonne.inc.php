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
    <p>Modification des informations</p>
    <?php
}
?>