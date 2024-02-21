<?php
include "header.php";
?>

<html>
  <head>
      <title>Accueil</title>
  </head>
  <body>
    <main>
      <h3 class="h3-title">Interventions du jour</h3>

      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th scope="col">Num Intervention</th>
            <th scope="col">Date</th>
            <th scope="col">Heure</th>
            <th scope="col">Code Client</th>
            <th scope="col">Opérateur</th>
            <th scope="col">Descriptif</th>
            <th scope="col">Etat Demande</th>
            <th scope="col">Actions</th>
            <th scope="col">Devis</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          // Récupération de toute les intervention d'aujourd'hui
            $interdao = new InterventionDAO(MaBD::getInstance());
            foreach($interdao->getToday() as $inter){
              $inter->getTable();
            }
          ?>
        </tbody>
      </table>
    </main>
  </body>
  <?php
    require "footer.php";
    createFooter();
  ?>
  <!-- Script de gestion des boutons -->
  <script src="../Scripts/afficher_inter.js"></script>
</html>