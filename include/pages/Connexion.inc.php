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
    1 => 'Everybody_do_the_flop' ,
    2 => 'I_like_train',
    3 => 'Hello',
    4 => 'He_got_a_noooooze',
    5 => 'Die_potato_die',
    6 => 'Fly_my_poney',
    7 => 'Desmond_the_moon_bear',
    8 => 'Do_you_want_to_eat_me',
    9 => 'I_am_a_Stegosaurus'
);
if (isset($_POST['valider']))
{
    if (!empty($_POST['login']) and !empty($_POST['passwd'])and !empty($_POST['reponse'])){
        if($_POST['reponse'] == ($asdfmovie1[$_POST['nb1']]+$asdfmovie1[$_POST['nb2']]))
        {
 
            $myPersonneManager = new PersonneManager($bdd);
             $personne = $myPersonneManager->getPersIdentification($_POST['login'], $_POST['passwd']);
             if ($personne != NULL){
                 $_SESSION['PersIdentifiee'] = $personne;
                 echo "Vous êtes connecté ".$_SESSION['PersIdentifiee']->getPrenom()." ".$_SESSION['PersIdentifiee']->getNom();
             }
        }
        else{
            echo "L'addition est fausse.";
        }
        
    }
}
else
{
    ?>
    <form action="#" method="POST">
        <label for="login">Nom d'utilisateur</label><br>
        <input type="text" name="login" id="login"><br>
        <label for='passwd'>Mote de passe</label><br>
        <input type='text' name='passwd' id='passwd'><br>
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
        <input type='number' name='reponse' id='reponse'><br>
        <input type='submit' name='valider' id='valider'><br>
    </form>
    <?php
}

