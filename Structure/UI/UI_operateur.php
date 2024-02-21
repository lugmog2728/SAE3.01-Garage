<?php
include "UI_header.php";

$operateurDAO = new OperateurDAO(MaBD::getInstance());

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $operateur = $operateurDAO->getOne($_GET['id']);
    $nom = $operateur->nom;
    $prenom = $operateur->prenom;
} else {
    $nom = "";
    $prenom = "";
}

if (isset($_POST['Nom_operateur'])) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // update
        $operateur->nom = $_POST['Nom_operateur'];
        $operateur->prenom = $_POST['Prénom_operateur'];
        $operateurDAO->update($operateur);
        header("Location: ../afficher_data.php?data=operateur");

    } else {
        // insert
        $operateur = new Operateur(
            array(
                "id_operateur" => $operateurDAO->getNewId(),
                "nom" => $_POST['Nom_operateur'],
                "prenom" => $_POST['Prénom_operateur']
            )
        );
        $operateurDAO->insert($operateur);
        header("Location: ../afficher_data.php?data=operateur");
    }
}
?>

<body>
    <main>
        <form action="" method="post">
            <div class="form-group">
                <label for="Nom_operateur">Nom de l'opérateur</label>
                <input type="text" class="form-control" id="Nom_operateur" name="Nom_operateur" placeholder="Nom de l'opérateur" value="<?php echo $nom; ?>">
            </div>
            <div class="form-group">
                <label for="Prénom_operateur">Prénom de l'opérateur</label>
                <input type="text" class="form-control" id="Prénom_operateur" name="Prénom_operateur" placeholder="Prénom de l'opérateur" value="<?php echo $prenom; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </main>
</body>
</html>
