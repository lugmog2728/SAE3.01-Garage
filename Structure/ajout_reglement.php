<?php
include "header.php";
include "../Scripts/tableaux.php";

$modeReglementDAO = new Mode_reglementDAO(MaBD::getInstance());
$reglementDAO = new ReglementDAO(MaBD::getInstance());
$lesReglement = getmodeRegTab();
$factureDAO = new FacturesDAO(MaBD::getInstance());

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: afficher_intervention.php");
}
if(isset($_POST['reg'])){
    $reglement = new Reglement(
        array(
            "no_reglement" => $reglementDAO->getID(),
            "date_reglement" => date("d-m-Y",time()),
            "montant_reglement" => $_POST['montant'],
            "no_mode_regl" => (string) $lesReglement[$_POST['reg']]->no_mode_regl,
            "no_facture" => $id
        )
        );
    $reglementDAO->insert($reglement);
    // Récupération des règlements de la facture
    $reglements = $reglementDAO->getallFacture($_GET['id']);
    $sommeFacture = ($factureDAO->getOne($_GET['id']))->net_a_payer;

    // Initialisation de la somme des règlements
    $totalReglements = 0;

    // Parcours des règlements
    foreach ($reglements as $reglement) {
    // Ajout de la valeur du règlement à la somme
    $totalReglements += $reglement->montant_reglement;
    }

    // Soustraction de la somme des règlements à la somme de la facture
    $resteAPayer = $sommeFacture - $totalReglements;
    if($resteAPayer == 0){
        $facture = $factureDAO->getOne($_GET['id']);

        $facture = new Facture(
            array(
                "no_facture" => $facture->no_facture,
                "date_facture" => $facture->date_facture,
                "taux_tva" => $facture->taux_tva,
                "net_a_payer" => $facture->net_a_payer,
                "etat_facture" => "PAYER",
                "num_dde" => $facture->num_dde
            )
        );
        $factureDAO->update($facture);
    }

    header("Location: fiche_facture.php?id=$id");
}


// Récupération des règlements de la facture
$reglements = $reglementDAO->getallFacture($_GET['id']);
$sommeFacture = ($factureDAO->getOne($_GET['id']))->net_a_payer;

// Initialisation de la somme des règlements
$totalReglements = 0;

// Parcours des règlements
foreach ($reglements as $reglement) {
    // Ajout de la valeur du règlement à la somme
    $totalReglements += $reglement->montant_reglement;
}

// Soustraction de la somme des règlements à la somme de la facture
$resteAPayer = $sommeFacture - $totalReglements;

?>


<body>
    <main>
        <?php echo("reste a payer: $resteAPayer") ?>
        <form action="" method="post">
            <div class="form-group">
            <label for="reglement">Mode de règlement</label>
            <input type="text" list="Reglement" class="form-control" id="reg" name="reg" placeholder="libelle du mode réglement"  required>
            </div>
            <div class="form-group">
                <label for="montant">montant</label>
                <input type="text" class="form-control" id="montant" max =<?php echo("'$resteAPayer'")?> name="montant" placeholder="montant du règlement" value="" required>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </main>

    <datalist id="Reglement">
                <?php
                    foreach ($modeReglementDAO->getAll() as $reg) {
                        $reg->getOption();}
                
                ?>
            </datalist>

</body>

</html>