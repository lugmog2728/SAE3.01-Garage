<?php
include "UI_header.php";
include "../../Scripts/tableaux.php";
$clientDAO = new ClientDAO(MaBD::getInstance());
$modeleDAO = new ModeleDAO(MaBD::getInstance());
$marqueDAO = new MarqueDAO(MaBD::getInstance());
$vehiculeDAO = new VehiculeDAO(MaBD::getInstance());

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $vehicule = $vehiculeDAO->getOne($_GET['id']);
    $no_immatriculation = $vehicule->no_immatriculation;
    $no_serie = $vehicule->no_serie;
    $date_mise_en_circulation = date("Y-m-d", strtotime($vehicule->date_mise_en_circulation));
    $client = $clientDAO->getOne($vehicule->code_client);
    $code_client = $client->code_client;
    $nom_client = $client->nom;
    $prenom_client = $client->prenom;
    $modele = $modeleDAO->getOne($vehicule->num_modele);
    $code_marque = $marqueDAO->getOne($modele->num_marque);
    $code_modele = $modele->num_modele;
    $disabled = "disabled";
} else {
    $no_immatriculation = "";
    $no_serie = "";
    $date_mise_en_circulation = "";
    $nom_client = "";
    $prenom_client = "";
    $code_modele = "0";
    $code_marque = "0";
    $disabled = "";
    $code_client = "";
}


if (sizeof($_POST) == 5) {
    $date_mise_en_circulation = str_replace("/", "-", $_POST['date_mise_en_circulation']);
    $date_mise_en_circulation = date("Y-m-d", strtotime($date_mise_en_circulation));
    $lesClients = getclientTab();
    $client = $lesClients[$_POST['client']];
    $code_client = $client->code_client;  
    $vehicule = new Vehicule(
        array(
            "no_immatriculation" => $no_immatriculation,
            "no_serie" => $_POST['no_serie'],
            "date_mise_en_circulation" => $date_mise_en_circulation,
            "code_client" => $code_client,
            "num_modele" => $_POST["modele"]
        )
    );
    $vehiculeDAO->update($vehicule);
    header("Location: ../afficher_data.php?data=vehicule");
} elseif (sizeof($_POST) == 6) {
    $lesClients = getclientTab();
    $client = $lesClients[$_POST['client']];
    $code_client = $client->code_client; 
    $vehicule = new Vehicule(
        array(
            "no_immatriculation" => $_POST['no_immatriculation'],
            "no_serie" => $_POST['no_serie'],
            "date_mise_en_circulation" => $_POST["date_mise_en_circulation"],
            "code_client" => $code_client,
            "num_modele" => $_POST["modele"]
        )
    );
    $vehiculeDAO->insert($vehicule);
    header("Location: ../afficher_data.php?data=vehicule");
}

?>






















<body>
    <main>
        <form action="" method="post">
            <div class="form-group">
                <label for="no_immatriculation">Numéro d'immatriculation (AA-123-AA) </label>
                <input type="text" class="form-control" id="no_immatriculation" name="no_immatriculation" pattern="[A-Z]{2}-[\d]{3}-[A-Z]{2}" placeholder="numéro d'immatriculation" value="<?php echo $no_immatriculation ?>" <?php echo $disabled ?> required>

            </div>

            <div class="form-group">
                <label for="no_serie">Numéro de série</label>
                <input type="text" class="form-control" id="no_serie" name="no_serie" placeholder="numéro de série" value="<?php echo $no_serie; ?>" required>
            </div>

            <div class="form-group">
                <label for="date_mise_en_circulation">Date de mise en circulation</label>
                <input type="date" class="form-control" id="date_mise_en_circulation" name="date_mise_en_circulation" placeholder="date de mise en circulation" value="<?php echo $date_mise_en_circulation ?>" required>
            </div>


            <div class="form-group">
                <label for="nom_client">Nom du client</label>
                <input type="text" list="allClient" class="form-control" id="client" name="client" placeholder="Nom client" value="<?php echo $nom_client . " ". $prenom_client ?>" required>
            </div>

            <div class="form-group">
                <label for="marque">Marque</label>
                <select class="form-control" id="marque" name="marque" onchange="remplirListeModeles(this.value); validateForm()">
                    <option value="0" <?php echo ($code_marque == "0") ? "selected" : "" ?>>Sélectionnez une marque</option>
                    <?php
                    foreach ($marqueDAO->getAll() as $marque) {
                        echo '<option value="' . $marque->num_marque . '" ' . (($marque->num_marque == $code_marque) ? "selected" : "") . '>' . $marque->marque . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="modele">Modèle</label>
                <select class="form-control" id="modele" name="modele" onchange="validateForm()" <?php ($code_marque != "0") ? "disabled" : "" ?>>
                    <option value="0" <?php echo ($code_modele == "0") ? "selected" : "" ?>>Sélectionnez une moldèle</option>
                    <?php
                    foreach ($modeleDAO->getAll() as $modele) {
                        echo '<option value="' . $modele->num_modele . '" ' . (($modele->num_modele == $code_modele) ? "selected" : "") . '>' . $modele->modele . '</option>';
                    }
                    ?>
                </select>
            </div>

            <datalist id="allClient">
                    <?php $clientsDAO = new ClientDAO(MaBD::getInstance());
                    foreach ($clientsDAO->getAll() as $clients) {
                    $clients->getOption();
                    }
                    ?>
                </datalist> 

            <button type="submit" class="btn btn-primary" id="submit">Valider</button>
        </form>
    </main>
    <script src="./../../Scripts/get_codeClient.js"></script>
    <script src="./../../Scripts/remplirListeModele.js"></script>
    <script src="./../../Scripts/validateform.js"></script>
</body>

</html>