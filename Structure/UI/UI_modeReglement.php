<?php
include "UI_header.php";

$modeReglementDAO = new Mode_reglementDAO(MaBD::getInstance());

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $modeReglement = $modeReglementDAO->getOne($_GET['id']);
    $libelle = $modeReglement->libelle_mode_regl;
} else {
    $libelle = "";
}

if (sizeof($_POST) == 1) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // update
        $modeReglement->libelle_mode_regl = $_POST['libelle_mode_regl'];
        $modeReglementDAO->update($modeReglement);
        header("Location: ../afficher_data.php?data=modeReglement");
    } else {
        // insert
        $modeReglement = new Mode_reglement(
            array(
                "no_mode_regl" => $modeReglementDAO->getNewId(),
                "libelle_mode_regl" => $_POST['libelle_mode_regl']
            )
        );
        $modeReglementDAO->insert($modeReglement);
        header("Location: ../afficher_data.php?data=modeReglement");
    }
}
?>

<body>
    <main>
        <form action="" method="post">
            <div class="form-group">
                <label for="libelle_mode_regl">libelle du mode de réglement</label>
                <input type="text" class="form-control" id="libelle_mode_regl" name="libelle_mode_regl" placeholder="libelle du mode réglement" value="<?php echo $libelle; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </main>
</body>

</html>