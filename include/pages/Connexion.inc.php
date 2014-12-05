<h1>Pour vous connecter</h1>
<?php
$asdfmovie1 = array(
    'Everybody_do_the_flop' => 1,
    'I_like_train' => 2,
    'Hello' => 3,
    'He_got_a_noooooze' => 4,
    'Die_potato_die' => 5,
    'Fly_my_poney' => 6,
    'Desmond_the_moon_bear' => 7,
    'Do_you_want_to_eat_me' => 8,
    'I_am_a_Stegosaurus' => 9
);

$asdfmovie2 = array(
    1 => 'Everybody_do_the_flop',
    2 => 'I_like_train',
    3 => 'Hello',
    4 => 'He_got_a_noooooze',
    5 => 'Die_potato_die',
    6 => 'Fly_my_poney',
    7 => 'Desmond_the_moon_bear',
    8 => 'Do_you_want_to_eat_me',
    9 => 'I_am_a_Stegosaurus'
);
if (isset($_POST['valider'])) {
    if (!empty($_POST['login']) and !empty($_POST['passwd']) and !empty($_POST['reponse'])) {
        if ($_POST['reponse'] == ($asdfmovie1[$_POST['nb1']] + $asdfmovie1[$_POST['nb2']])) {

            $myPersonneManager = new PersonneManager($bdd);
            $personne = $myPersonneManager->getPersIdentification($_POST['login'], $_POST['passwd']);
            if ($personne->getNum() != NULL) {
                $_SESSION['PersIdentifiee'] = $personne;
                echo "Vous êtes connecté " . $_SESSION['PersIdentifiee']->getPrenom() . " " . $_SESSION['PersIdentifiee']->getNom();
            } else {
                echo '<p><img src="image/erreur.png" alt="erreur" > Erreur d\'authentification</p>';
            }
        } else {
            echo '<p><img src="image/erreur.png" alt="erreur" > L\'addition est fausse.</p>';
        }
    }
} else {
    ?>
    <form class="col-lg-6" action="#" method="POST">
        <div class="form-group">
            <label for="login">Nom d'utilisateur</label>
            <input class="form-control" type="text" name="login" id="login">
        </div>
        <div class="form-group">
            <label for='passwd'>Mot de passe</label>
            <input class="form-control" type='password' name='passwd' id='passwd'>
        </div>
    <?php
    $nombres = array_rand($asdfmovie2, 2);
    $nb1 = $asdfmovie2[$nombres[0]];
    $nb2 = $asdfmovie2[$nombres[1]];
    ?>
        <input type="hidden" id='nb1' name='nb1' value='<?php echo $nb1; ?>'>
        <input type="hidden" id='nb2' name='nb2' value='<?php echo $nb2; ?>'>
        <img src='image/nb/<?php echo $nb1; ?>.jpg'>
        <span>+</span>
        <img src='image/nb/<?php echo $nb2; ?>.jpg'>
        <span>=</span><br>
        <div class="form-group">
            <input class="form-control" type='number' name='reponse' id='reponse'>
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type='submit' name='valider' id='valider' value="Connexion">
        </div>
    </form>
    <?php
}

