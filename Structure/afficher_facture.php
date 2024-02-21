<?php 
include "header.php";
?>

<head>
    <title>Afficher Facture</title>
</head>

<body>
    <main>
        <h3 class="h3-title">Factures en cours</h3>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                <th scope="col" style='width:6%'>Date</th>
                <th scope="col" style='width:6%'>Client</th>
                <th scope="col" style='width:5%'>Status</th>
                <th scope="col" style='width:6%'>Prix HT</th>
                <th scope="col" style='width:6%'>Actions</th>
                </tr>
            </thead>
        
        <?php 
            $factureDAO = new FacturesDAO(MaBD::getInstance());
            foreach($factureDAO->getAll() as $facture){
                $facture->printFacture();
            }
            echo "</table>";
        
        ?>
        </form>
    </main>
    <script src="../Scripts/delete_data.js"></script>
</body>
<!-- Same on all pages -->
<?php
    require 'footer.php';
    createFooter();
?>
</html>