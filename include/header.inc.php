<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <?php $title = "Bienvenue sur le site de covoiturage de l'IUT."; ?>
        <title>
            <?php echo $title ?>
        </title>

        <!--<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />-->
        <link href="css/bootstrap-theme.min.css" rel="stylesheet" />
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-static-top">   
            <div class="container">
                <div class="navbar-header">	
                    <a href="index.php?page=0">
                        <img src="image/logo.png" alt="Logo covoiturage IUT" style="width: 50px;" title="Logo covoiturage IUT Limousin" />
                    </a>
                </div>
                <div class="nav-collapse">
                    <div class="navbar-text">
                        <p>Covoiturage de l'IUT, partagez plus que votre véhicule !!!</p>
                    </div>
                    <div class=" navbar-text navbar-right" id="connect">
                        <?php
                        if (!isset($_SESSION['PersIdentifiee'])) {
                            ?>
                            <a href="index.php?page=11" class="btn btn-info btn-sm" >Connexion</a>
                            <?php
                        } else {
                            ?>
                            Utilisateur : <b><?php echo $_SESSION['PersIdentifiee']->getNom(); ?> </b>
                            <span ></span>
                            <a href="index.php?page=12" class="btn btn-danger btn-sm">Déconnexion</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="cops">

