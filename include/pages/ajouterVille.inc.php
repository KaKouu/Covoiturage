<h1>Ajouter une ville</h1>
<?php
if (empty($_POST['nomVille']) and empty($_POST['ajouter'])) {
    ?>
    <form action="#" method="POST" class="col-lg-6">
        <div class="form-group ">
            <label for="nomVille">Nom de la ville</label>
            <input type="text" id="nomVille" name="nomVille" class="form-control " required="">
        </div>
        <div class="form-group">
            <input type="submit" id="ajouter" value="Ajouter" class="btn btn-primary">
        </div>
    </form>
    <?php
} else {
    $ville = array(
        'vil_num' => null,
        'vil_nom' => $_POST['nomVille']
    );
    $maVille = new Ville($ville);
    $myVilleManager = new VilleManager($bdd);
    if ($myVilleManager->existeVille($_POST['nomVille'])) {
        echo'<p><img src="image/erreur.png" alt="erreur" > La ville existe déjà.</p>';
        ?>
        <form action="#" method="POST" class="col-lg-6">
            <div class="form-group" >
                <label for="nomVille">Nom de la ville</label>
                <input type="text" id="nomVille" name="nomVille" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="submit" id="ajouter" value="Ajouter" class="btn btn-primary">
            </div>
        </form>
        <?php
    } else {
        $retour = $myVilleManager->add($maVille);
        if ($retour != 0) {
            echo'<p><img src="image/valid.png" alt="valide" > La ville ' . $_POST['nomVille'] . ' est ajoutée.</p>';
        } else {
            echo'<p>Erreur</p>';
        }
    }
}
?>