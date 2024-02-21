<?php
  include 'header.php';
?>

<html>
  <head>
      <title>Afficher Intervention</title>
  </head>
  <body>
    <!-- Main (that's where the code is modified) -->
    <main>
      <h3 class="h3-title">Interventions en cours</h3>

      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th scope="col" style='width:12%'>Num Intervention</th>
            <th scope="col" style='width:6%'>Date</th>
            <th scope="col" style='width:5%'>Heure</th>
            <th scope="col" style='width:8%'>Code Client</th>
            <th scope="col" style='width:6%'>Operateur</th>
            <th scope="col" style='width:40%'>Descriptif</th>
            <th scope="col" style='width:12%'>Etat Demande</th>
            <th scope="col" style='width:6%'>Actions</th>
            <th scope="col" style='width:2%'>Devis</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $interdao = new InterventionDAO(MaBD::getInstance());


            foreach($interdao->getAll() as $i){
              if($i->etat_demande == "EN COURS")
              {
                $i->getTable();
              }
            }
          ?>
        </tbody>
      </table>
    </main>
  </body>
  <!-- Same on all pages -->
  <?php
    require "footer.php";
    createFooter();
  ?>
  <script src="../Scripts/afficher_inter.js"></script>
</html>