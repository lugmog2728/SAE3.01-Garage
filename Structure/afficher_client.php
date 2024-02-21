<?php
include 'header.php';

if (isset($_GET['id'])) {
    $clientDao = new ClientDAO(MaBD::getInstance());
    $client = $clientDao->getOne($_GET['id']);
} else {
    header("Location: afficher_data.php?data=client");
}
?>
<html>
    <link rel="stylesheet" href="../Style/afficher_data_info.css">
    <body>
        <h1>Info client (n°<?php echo $_GET['id'];?>)</h1>
        <div id="container">

            <div id="nom" class="info-box">
                <h2>Nom</h2>
                <p><?php echo $client->nom; ?></p>
            </div>
            <div id="prenom" class="info-box">
                <h2>Prénom</h2>
                <p><?php echo $client->prenom; ?></p>
            </div>
            <div id="tel" class="info-box">
                <h2>Téléphone</h2>
                <p><?php echo $client->tel; ?></p>
            </div>
            <div id="mail" class="info-box">
                <h2>Email</h2>
                <p><?php echo $client->mail; ?></p>
            </div>
            <div id="adresse" class="info-box">
                <h2>Adresse</h2>
                <p><?php echo $client->adresse; ?></p>
            </div>
            <div id="ville" class="info-box">
                <h2>Ville</h2>
                <p><?php echo $client->ville; ?></p>
            </div>
            <div id="code_postal" class="info-box">
                <h2>Code postal</h2>
                <p><?php echo $client->codepostal; ?></p>
            </div>
        </div>
    </body>
    <!-- Same on all pages -->
    <?php
        require "footer.php";
        createFooter();
    ?>
</html>