<?php
include "UI_header.php";

$modeleDAO = new ModeleDAO(MaBD::getInstance());
$marqueDAO = new MarqueDAO(MaBD::getInstance());

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $modele = $modeleDAO->getOne($_GET['id']);
    $marque = $marqueDAO->getOne($modele->num_marque);
    $nomMarque = $marque->marque;
    $nomModele = $modele->modele;
} else {
    $nomMarque = "";
    $nomModele = "";
}

if (sizeof($_POST) == 2) {
    $tempMarque = $marqueDAO->getOneByName($_POST['marque']);
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // update
        

        if ($tempMarque == null) {
            $marqueID = $marqueDAO->getID();
            $marque = new Marque(
                array(
                    "num_marque" => $marqueID,
                    "marque" => $_POST['marque']
                )
            );

            $marqueDAO->insert($marque);
        } else {
            $marqueID = $tempMarque->num_marque;
        }

        
        $modele->num_marque = $marqueID;
        $modele->modele = $_POST['modele'];
        $modeleDAO->update($modele);
        header("Location: ../afficher_data.php?data=modele");        
    } else {
        // insert
        if ($tempMarque == null) { 
            $marqueID = $marqueDAO->getID();
            $marque = new Marque(
                array(
                    "num_marque" => $marqueID,
                    "marque" => $_POST['marque']
                )
            );

            $marqueDAO->insert($marque);
        } else {
            $marqueID = $tempMarque->num_marque;
        }

        $modele = new Modele(
            array(
                "num_marque" => $marqueID,
                "num_modele" => $modeleDAO->getID(),
                "modele" => $_POST['modele']
            )
        );

        $modeleDAO->insert($modele);
        header("Location: ../afficher_data.php?data=modele");
    }
}
?>

<body>
    <main>
        <form action="" method="post">
            <div class="form-group">
                <label for="marque">Marque</label>
                <input type="text" class="form-control" list="allMarque" id="marque" name="marque" placeholder="Marque" value="<?php echo $nomMarque; ?>">
            </div>
            <div class="form-group">
                <label for="modele">Modele</label>
                <input type="text" class="form-control" id="modele" name="modele" placeholder="Nom du modele" value="<?php echo $nomModele; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>

            <datalist id="allMarque">
                <?php
                foreach ($marqueDAO->getAll() as $onceMarque) {
                    $onceMarque->getOption();
                }
                ?>
            </datalist>
        </form>
    </main>
</body>

</html>