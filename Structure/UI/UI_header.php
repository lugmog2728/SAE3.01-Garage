<?php
    require "../../autoload.php";
    //DEBUG DISPLAY
    
    // ini_set('display_errors', 'stderr');
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL); 

        echo '<!DOCTYPE html>
        <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" media="all">
              <link rel="stylesheet" type="text/css" href="../../Style/style.css" media="screen">
              <link rel="stylesheet" type="text/css" href="../../Style/print.css" media="print" />
              <!-- Fontawesome version : 6.2.0 -->
              <script src="https://kit.fontawesome.com/9f4e11af91.js" crossorigin="anonymous"></script>
          </head>
          <!-- Header/Nav (Same on all pages but not in connexion) -->
          <header class="no-print">
          <nav class="navbar navbar-light" >
        <form class="form-inline" id="nav-content">
            <a type="button" class="btn btn-success" href="../afficher_intervention.php">Afficher Intervention</a>
            <a type="button" class="btn btn-success" href="../afficher_facture.php">Afficher Facture</a>
            <a href="../accueil.php"><img src="../../img/marteau.png" width="50" height="50" alt=""></a>
            <a type="button" class="btn btn-success" href="../gestion_donnee.php">Gestion Données</a>
            <a type="button" class="btn btn-success" href="../ajout_RDV.php">Ajouter RDV</a>
            
        </form>
    </nav>
    </header>';
    
?>