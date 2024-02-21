<?php
include 'header.php';

if (isset($_GET['immat'])) {
    $vehiculeDao = new VehiculeDAO(MaBD::getInstance());
    $vehicule = $vehiculeDao->getOne($_GET['immat']);

    $clientDao = new ClientDAO(MaBD::getInstance());
    $client = $clientDao->getOne($vehicule->code_client);

    $modeleDao = new ModeleDAO(MaBD::getInstance());
    $modele = $modeleDao->getOne($vehicule->num_modele);

    $marqueDao = new MarqueDAO(MaBD::getInstance());
    $marque = $marqueDao->getOne($modele->num_marque);
} else {
    header("Location: afficher_data.php?data=vehicule");
}
?>
<link rel="stylesheet" href="../Style/afficher_data_info.css">
<body>
    <h1>Info Vehicule</h1>
    <div id="container">

        <div id="imat" class="info-box">
            <h2>Immatriculation</h2>
            <p><?php echo $vehicule->no_immatriculation; ?></p>
        </div>
        <div id="serie" class="info-box">
            <h2>N° Série</h2>
            <p><?php echo $vehicule->no_serie; ?></p>
        </div>
        <div id="date-mec" class="info-box">
            <h2>Date de Mise en circulation</h2>
            <p><?php echo $vehicule->date_mise_en_circulation; ?></p>
        </div>
        <div id="nom-client" class="info-box">
            <h2>Nom Client</h2>
            <p><?php echo $client->nom; ?></p>
        </div>
        <div id="prenom-client" class="info-box">
            <h2>Prénom Client</h2>
            <p><?php echo $client->prenom; ?></p>
        </div>
        <div id="marque" class="info-box">
            <h2>Marque</h2>
            <p><?php echo $marque->marque; ?></p>
        </div>
        <div id="modele" class="info-box">
            <h2>Modèle</h2>
            <p><?php echo $modele->modele; ?></p>
        </div>
    </div>
</body>
</html>