<?php
include "header.php";
?>
<html>
    <head>
        <title>Gestion des Données</title>
    </head>
    <body>
        <main>
            <h3 class="h3-title">Gestion des différents types de données</h3>
            <div id="gestion-btn-holder">
                <div class="gestion-holder">
                    <h3 class="center">Client:</h3>
                    <button class="gestionbtn" type="button" onclick="location.replace('afficher_data.php?data=client')">Afficher Clients</button>
                    <button class="gestionbtn" type="button" onclick="location.replace('afficher_data.php?data=vehicule')">Afficher Véhicules</button>
                </div>

                <div class="gestion-holder">
                    <h3 class="center">Administration:</h3>
                    <button class="gestionbtn" type="button" onclick="location.replace('updateTVA.php')">Modifier TVA</button>
                    <button class="gestionbtn" type="button" onclick="location.replace('afficher_data.php?data=modeReglement')">Afficher Modes de Règlement</button>
                    <button class="gestionbtn" type="button" onclick="location.replace('afficher_data.php?data=modele')">Afficher Modèles et Marques</button>
                </div>
                
                <div class="gestion-holder">
                    <h3 class="center">Intervention:</h3>
                    <button class="gestionbtn" type="button" onclick="location.replace('afficher_data.php?data=article')">Afficher Articles</button>                    
                    <button class="gestionbtn" type="button" onclick="location.replace('afficher_data.php?data=operateur')">Afficher Opérateurs</button>
                    <button class="gestionbtn" type="button" onclick="location.replace('afficher_data.php?data=operation')">Afficher Opérations</button>
                </div>
            </div>
        </main>
    </body>
    <!-- Same on all pages -->
    <?php
        require "footer.php";
        createFooter();
    ?>
</html>