<?php
include 'header.php';
include '../Scripts/title.php';

echo "<body>
      <main>";

$data = $_GET['data'];
echo "<button id='add-data' onclick='location.replace(\"./UI/UI_{$data}.php?id=0\")'>
        <img src='../img/plus.png' alt='plus'></button>";


switch ($data) {
  case 'article':
    articleTitle();
    $articleDao = new ArticleDAO(MaBD::getInstance());
    foreach ($articleDao->getAll() as $article) {
      $article->getTable();
    }
    break;


  case 'client':
    clientTitle();
    $clientDao = new ClientDAO(MaBD::getInstance());
    foreach ($clientDao->getAll() as $client) {
      $client->getTable();
    }
    break;


  case 'modele':
    modeleTitle();
    $modeleDao = new ModeleDAO(MaBD::getInstance());
    foreach ($modeleDao->getAll() as $modele) {
      $modele->getTable();
    }
    break;


  case 'modeReglement':
    reglementTitle();
    $modeReglementDao = new Mode_reglementDAO(MaBD::getInstance());
    foreach ($modeReglementDao->getAll() as $modeReglement) {
      $modeReglement->getTable();
    }
    break;


  case 'operateur':
    operateurTitle();
    $operateurDao = new OperateurDAO(MaBD::getInstance());
    foreach ($operateurDao->getAll() as $operateur) {
      $operateur->getTable();
    }
    break;


  case 'vehicule':
    vehiculeTitle();
    $vehiculeDao = new VehiculeDAO(MaBD::getInstance());


    foreach ($vehiculeDao->getAll() as $vehicule) {
      $vehicule->getTable();
    }
    break;


  case 'operation':
    operationTitle();
    $operationDao = new OperationDAO(MaBD::getInstance());
    foreach ($operationDao->getAll() as $operation) {
      $operation->getTable();
    }
    break;
}
echo "</body>";
?>

<script>
  $(document).ready(function() {
    // PHP code goes here
    <?php
      /* Same on all pages */
      require "footer.php";
      createFooter();
    ?>
  });
</script>
<script src="../Scripts/delete_data.js"></script>
