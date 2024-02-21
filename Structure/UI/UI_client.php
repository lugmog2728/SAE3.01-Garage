<?php
include "UI_header.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $clientDAO = new ClientDAO(MaBD::getInstance());
    $client = $clientDAO->getOne($id);

    if ($client) {
        $nomClient = $client->nom;
        $prenomClient = $client->prenom;
        $adresseClient = $client->adresse;
        $codePostalClient = $client->codepostal;
        $villeClient = $client->ville;
        $telClient = $client->tel;
        $mailClient = $client->mail;
    }
} else {
    $id = 0;
    $nomClient = '';
    $prenomClient = '';
    $adresseClient = '';
    $codePostalClient = '';
    $villeClient = '';
    $telClient = '';
    $mailClient = '';
}

if (isset($_POST['Nom_client'])) {
    $clientdao = new ClientDAO(MaBD::getInstance());
    $info = array(
        "code_client" => $clientdao->getNewId(),
        "nom" => $_POST['Nom_client'],
        "prenom" => $_POST['Prénom_client'],
        "adresse" => $_POST['Adresse_client'],
        "codepostal" => $_POST['Code_postal_client'],
        "ville" => $_POST['Ville_client'],
        "tel" => $_POST['Tel_client'],
        "mail" => $_POST['Mail_client'],
        "date_creation" => date("Y-m-d")
    );
    $client = new Client($info);
    $clientdao->insert($client);
    header("Location: ../afficher_data.php?data=client");
}
?>
<html>
    <form action="" method="post">
        <div class="form-group">
            <label for="Nom_client">Nom du client</label>
            <input type="text" class="form-control" id="Nom_client" name="Nom_client" value="<?= $nomClient ?>" placeholder="Nom du client">
        </div>
        <div class="form-group">
            <label for="Prénom_client">Prénom du client</label>
            <input type="text" class="form-control" id="Prénom_client" name="Prénom_client" value="<?= $prenomClient ?>" placeholder="Prénom du client">
        </div>
        <div class="form-group">
            <label for="Adresse_client">Adresse du client</label>
            <input type="text" class="form-control" id="Adresse_client" name="Adresse_client" value="<?= $adresseClient ?>" placeholder="Adresse du client">
        </div>
        <div class="form-group">
            <label for="Code_postal_client">Code postal du client</label>
            <input type="text" class="form-control" id="Code_postal_client" name="Code_postal_client" value="<?= $codePostalClient ?>" placeholder="Code postal du client">
        </div>
        <div class="form-group">
            <label for="Ville_client">Ville du client</label>
            <input type="text" class="form-control" id="Ville_client" name="Ville_client" value="<?= $villeClient ?>" placeholder="Ville du client">
        </div>
        <div class="form-group">
            <label for="Tel_client">Téléphone du client</label>
            <input type="tel" class="form-control" id="Tel_client" name="Tel_client" value="<?= $telClient ?>" placeholder="Téléphone du client">
        </div>
        <div class="form-group">
            <label for="Mail_client">Mail du client</label>
            <input type="text" class="form-control" id="Mail_client" name="Mail_client" value="<?= $mailClient ?>" placeholder="Mail du client">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</html>