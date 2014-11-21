
<h1>Liste des Personnes</h1>
<?php
$myPersonneManager = new PersonneManager($bdd);
if (isset($_GET['id'])) {
    if ($myPersonneManager->isEtudiant($_GET['id'])) {
        //si la personne est un étudiant
        $myEtudiantManager = new EtudiantManager($bdd);
        $myVilleManager = new VilleManager($bdd);
        $myDepartementManager = new DepartementManager($bdd);
        $etudiant = $myEtudiantManager->getEtuById($_GET['id']);
        $departement = $myDepartementManager->getDepById($etudiant->getDep());
        $ville = $myVilleManager->getVilleById($departement->getVilNum());
        ?>
        <table>
            <tr>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Téléphone</th>
                <th>Département</th>
                <th>Ville</th>
            </tr>
            <tr>
                <td><?php echo $etudiant->getPrenom(); ?></td>
                <td><?php echo $etudiant->getMail(); ?></td>
                <td><?php echo $etudiant->getTel(); ?></td>
                <td><?php echo $departement->getDepNom(); ?></td>
                <td><?php echo $ville->getVilNom(); ?></td>
            </tr>
        </table>

        <?php
    } else {
        //si la personne est un salarié
        $mySalarieManager = new SalarieManager($bdd);
        $myFonctionManager = new FonctionManager($bdd);
        $salarie = $mySalarieManager->getSalarieById($_GET['id']);
        $fonction = $myFonctionManager->getFonctionById($salarie->getNumFonc());
        ?>
        <table>
            <tr>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Téléphone</th>
                <th>Tel prof</th>
                <th>Fonction</th>
            </tr>
            <tr>
                <td><?php echo $salarie->getPrenom(); ?></td>
                <td><?php echo $salarie->getMail(); ?></td>
                <td><?php echo $salarie->getTel(); ?></td>
                <td><?php echo $salarie->getTelProf(); ?></td>
                <td><?php echo $fonction->getLibelle(); ?></td>
            </tr>
        </table>
        <?php
    }
    echo"<p><a href='index.php?page=2'>Retour</a></p>";
} else {
    ?>
    <table>
        <tr>
            <th>Numéro</th>
            <th>Nom</th>
            <th>Prénom</th>
        </tr>

    <?php
    $personnes = $myPersonneManager->getAllPers();
    foreach ($personnes as $value) {
        echo '<tr><td><b><a href=?page=2&id=' . $value->getNum() . "> " . $value->getNum() . "</a></b></td>";
        echo '<td> ' . $value->getNom() . '</td>';
        echo '<td>' . $value->getPrenom() . '</td></tr>';
    }
    ?>
    </table>
        <?php
    }