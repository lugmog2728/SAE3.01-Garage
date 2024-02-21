<?php 
require "../autoload.php";
include "header.php";

$prevOperationDAO = new RealiserOpDAO(MaBD::getInstance());
$preArticleDAO = new UtiliserArticleDAO(MaBD::getInstance());
$articleDAO = new ArticleDAO(MaBD::getInstance());
$reglementDAO = new ReglementDAO(MaBD::getInstance());
$operationDAO = new OperationDAO(MaBD::getInstance());
$factureDAO = new FacturesDAO(MaBD::getInstance());

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $facture = $factureDAO->getOne($id);
    $operations = $prevOperationDAO->getAllIntervention($facture);
    $articles = $preArticleDAO->getAllIntervention($facture);
    $reglements = $reglementDAO->getAllFacture($id);
    
    $tva = Parametres::getTva();
}
else
?>
<head>
    <title>Imprimer Facture</title>
</head>

<body>
    <!-- Main (that's where the code is modified) -->
    <main>
        <?php
            $Sous_totalOP = 0;
            $Sous_totalArt = 0;
            
    echo '<div id="facture" class="card">
                <div class="card-header">
                    Facture: <strong>#' . $facture->no_facture; echo'</strong>
                    <div id="save-print">
                        <a class="btn btn-sm btn-secondary float-right mr-1 d-print-none" href="#" onclick="javascript:window.print();" data-abc="true">
                            <i class="fa fa-print"></i> Imprimer
                        </a>
                    </div>
                </div>
                <br>

                <div class="card-body">
                    <div class="flex-fact">
                        <div id="fourn">
                            Fournisseur: <strong>[NomEntreprise]</strong> <br>
                            Adresse: [Adresse] <br>
                            Email: [admin@gmail.com] <br>
                            Téléphone: +33 06 01 02 03 04
                        </div>
                        <div id="dest">
                            Destinataire: <strong>[NomClient]</strong> <br>
                            Adresse: [Adresse] <br>
                            Email: [client@gmail.com] <br>
                            Téléphone: +33 09 08 07 06 05
                        </div>
                    </div>
                </div>
                <br><br><br>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Libellé de l\'article</th>
                            <th>Prix à l\'unité</th>
                            <th>Quantité de l\'article</th>
                            <th>Sous-total du prix de l\'article</th>
                        </tr>
                    </thead>
                    <tbody>';
                    
                    foreach($articles as $art){
                        echo'<tr><td class="center">' . $articleDAO->getOne($art->code_article)->libelle_article; echo'</td>';
                        echo'<td class="center">' . $art->pu_ht; echo'</td>
                            <td class="center">' . $art->qte_fact; echo'</td>';
                            $Sous_totalArt +=$art->pu_ht*$art->qte_fact;
                            echo'<td class="center">$' . $art->pu_ht*$art->qte_fact; echo'</td>
                        </tr>';
                    }

                    echo'</tbody>
                </table><br><br>

                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Libellé de l\'opération</th>
                        <th>Coût horaire</th>
                        <th>Durée de l\'opération</th>
                        <th>Sous-total du prix de l\'opération</th>
                    </tr>
                </thead>
                <tbody>';
                
                foreach($operations as $op){
                    echo'<tr><td class="center">' . $operationDAO->getOne($op->code_op)->libelle_op; echo'</td>';
                    echo'<td class="center">' . $op->cout_horaire_ht; echo'</td>
                        <td class="center">' . $op->duree_reel; echo'</td>';
                        $Sous_totalOP +=$op->duree_reel*$op->cout_horaire_ht;
                        echo'<td class="center">$' . $op->duree_reel*$op->cout_horaire_ht; echo'</td>
                    </tr>';
                }

                echo'</tbody>
            </table><br><br>
                <div class="row" style="display: grid;">
                    <div id="divdetails" class="col-sm-4" style="position: absolute; left:20px;">
                        <h6 class="mb-3">Détails:</h6>
                        <div>
                            Date: [Date] <br>
                            VAT: FR12345678 <br>
                            Nom du compte Bancaire: [Compte] <br>
                            RIB: [RIB] <br>
                            IBAN: [IBAN]
                        </div>
                    </div>
                    <div id="payment" class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear" id="print-decal">
                            <tbody>
                                <tr class="payment-content">
                                    <td class="left">
                                    <strong>Sous-total des articles</strong>
                                    </td>
                                    <td class="right">$' . $Sous_totalArt; echo'</td>
                                </tr>
                                <tr class="payment-content">
                                    <td class="left">
                                    <strong>Sous-total des opérations</strong>
                                    </td>
                                    <td class="right">$' . $Sous_totalOP; echo'</td>
                                </tr>
                                <tr class="payment-content">
                                    <td class="left">
                                    <strong>TVA</strong>
                                    </td>
                                    <td class="right">' . $tva * 100; echo'%</td>
                                </tr>
                                <tr class="payment-content">
                                    <td class="left">
                                    <strong>Montant à payer (USD)</strong>
                                    </td>
                                    <td class="right">
                                    <strong>$' . $Sous_totalArt * (1 + $tva) + $Sous_totalOP * (1 + $tva); echo'</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>';
            ?>
        <button  id="reglement" onclick=<?php echo "document.location.href='ajout_reglement.php?id=".(int) $facture->no_facture?>'>Ajout Règlement</button>
        </div>
    </main>
</body>
<!-- Same on all pages -->
<?php
    require 'footer.php';
    createFooter();
?>
</html>
