<h1>Supprimer des personnes enregistrées</h1>
<?php
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être connecté pour pouvoir  supprimer les information de votre profils</p> 
    <a href="index.php?page=11">Connexion</a>
    <?php
} else {
    ?>
    <p>Suppression des informations</p>
    <?php
}