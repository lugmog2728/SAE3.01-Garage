<?php
  // Chargement des classes nécessaires
  require "../autoload.php";

  // Récupération des paramètres de la requête
  $nom = $_GET['nom'];
  $prenom = $_GET['prenom'];

  try {
    // Connexion à la base de données et récupération du client
    $clientDAO = new ClientDAO(MaBD::getInstance());
    $client = $clientDAO->getOneByName($nom, $prenom);

    // Envoi de la réponse au client
    echo $client->code_client;
  } catch (Exception $e) {
    // Envoi d'une réponse d'erreur au client
    http_response_code(500);
    echo "Erreur lors de la récupération du code client : " . $e->getMessage();
  }
?>
