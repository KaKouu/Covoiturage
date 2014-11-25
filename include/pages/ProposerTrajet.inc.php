<h1>Proposer un trajet</h1>
<?php
if (!isset($_SESSION['PersIdentifiee'])) {
    ?>
    <p>Vous devez être authentifié pour pouvoir proposer un traget</p> 
    <a href="index.php?page=11">Connexion</a>
    <a href="index.php?page=1">Inscrption</a>
    <?php
} else {

    $villesParcours = array();
    $myTrajetManager = new ParcoursManager($bdd);
    $myVilleManager = new VilleManager($bdd);

    if (isset($_POST['vil_depart'])) {
        //la ville de depart à été selectionné
        if ($_POST['vil_depart'] != '') {
            $villesParcours = $myTrajetManager->getAllVilleInParcours($_POST['vil_depart']);
            ?>
            <p>Votre de ville de départ :<b> <?php echo $myVilleManager->getVilleById($_POST['vil_depart'])->getVilNom(); ?></b></p>
            <form action="#" method="POST" id="form_Tajet">
                <label for='vil_arrive'>Ville d'arrivée : </label>
                <select name="vil_arrive" id="vil_arrive">
                    <option value="">Selectionner une ville de départ</option>
                    <?php
                    foreach ($villesParcours as $values) {
                        if ($values != $_POST['vil_depart']) {
                            $ville = $myVilleManager->getVilleById($values);
                            echo '<option value="' . $values . '">' . $ville->getVilNom() . ' </option>' . "\n";
                        }
                    }
                    ?>
                </select>
                <br>
                <input type="hidden" id="ville_depart" name="ville_depart" value="<?php echo $_POST['vil_depart']; ?>">
                <label for="">Date de départ : </label>
                <input type="text" id="date_depat" name="date_depart"  value="<?php echo date("d/m/Y"); ?>">
                <br>
                <label for="">Heure de départ : </label>
                <input type="text" id="heure_depart" name="heure_depart" value="<?php echo date("H:i:s"); ?>">
                <br>
                <label for="">Nombre de place : </label>
                <input type="number" id="nb_place" name="nb_place" value="0">
                <br>
                <input type="submit" name="ajouter_trajet" id ="ajouter_trajet" value="Ajouter">
            </form>
            <?php
        }
        else{
            header("location:index.php?page=9");
        }
    } elseif (isset($_POST['ajouter_trajet'])) {
        if (empty($_POST['ville_depart']) or empty($_POST['vil_arrive']) or empty($_POST['date_depart']) or empty($_POST['heure_depart']) or !isset($_POST['nb_place'])) {
            echo"votre formulaire est mal rempli ";
        } else {
            $date_depart = $_POST['date_depart'];
            $date = explode('-', str_replace("/", "-", $date_depart));

            if ($_POST['nb_place'] <= 0) {
                echo '<p>Vous ne pouvez pas faire du covoiturage tout seul accepter au moins une personne</p>';
            }else if (count($date) < 2 or count($date) > 3) {
                echo "<p>Votre format de date est mauvaise</p>";
            }
            else if (date("d-m-Y", strtotime(str_replace("/", "-", $date_depart))) < date("d-m-Y")) {
                echo "<p>Vous ne pouvez pas covoiturer à une date antérieur à aujourd'hui</p>";
            }else{
                $parcours = $myTrajetManager->getByVille($_POST['ville_depart'], $_POST['vil_arrive']);
                var_dump($parcours);
                if($parcours->getVilNum1()== $_POST['ville_depart']){
                    $sens=0;
                }
                else{
                    $sens = 1;
                }
                $trajet = array(
                    'per_num' => $_SESSION['PersIdentifiee']->getNum(),
                    'pro_date' => date("Y-m-d", strtotime(str_replace("/", "-", $_POST['date_depart']))),
                    'pro_time'=>$_POST['heure_depart'],
                    'pro_place' =>$_POST['nb_place'],
                    'par_num'=>$parcours->getParNum(),
                    'pro_sens'=>$sens
                );
                
                $myPropositionManager= new ProposeManager($bdd);
                $myPropose = new Propose($trajet);
                
                $myPropositionManager ->add($myPropose);
                echo "<p>Le trajet à bien été ajouté</p>";
            }
             
        }
    } else {
        //formulaire de départ
        $villesParcours = $myTrajetManager->getAllVilleParcours();
        ?>
        <p>Selectionner le trajet que vous souhaité effectuer</p>
        <form action="#" method="POST" id="form_Tajet">
            <label for='vil_depart'>Ville de départ : </label>
            <select name="vil_depart" id="vil_depart" onchange="document.forms['form_Tajet'].submit();">
                <option value="">Selectionner une ville de départ</option>
                <?php
                foreach ($villesParcours as $values) {
                    $ville = $myVilleManager->getVilleById($values);
                    echo '<option value="' . $values . '">' . $ville->getVilNom() . ' </option>' . "\n";
                }
                ?>
            </select>
            <?php
        }
    }
    ?>
    