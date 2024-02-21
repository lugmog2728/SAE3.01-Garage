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
}
else
?>
<body>
    <br>
    <!-- Main (that's where the code is modified) -->
    <main>
        <table>
            <tbody>
        <?php
        $Sous_totalOP = 0;
            echo "<tr>";
            foreach($operations as $op){
                echo "<td>";
                echo $operationDAO->getOne($op->code_op)->libelle_op;
                echo "</td>";
                echo "<td>";
                echo $op->cout_horaire_ht;
                echo "</td>";
                echo "<td>";
                echo $op->duree_reel;
                echo "<td>";
                echo "<td>";
                $Sous_totalOP +=$op->duree_reel*$op->cout_horaire_ht;
                echo $op->duree_reel*$op->cout_horaire_ht;
                echo "<td>";
            }
            echo "</tr>";
            echo $Sous_totalOP;

            $Sous_totalArt = 0;
            echo "<tr>";
            foreach($articles as $art){
                echo "<td>";
                echo $articleDAO->getOne($art->code_article)->libelle_article;
                echo "</td>";
                echo "<td>";
                echo $art->pu_ht;
                echo "</td>";
                echo "<td>";
                echo $art->qte_fact;
                echo "<td>";
                echo "<td>";
                $Sous_totalArt +=$art->pu_ht*$art->qte_fact;
                echo $art->pu_ht*$art->qte_fact;
                echo "<td>";
            }
            echo "</tr>";
            echo $Sous_totalArt;
            
            echo "</br>";
            echo $Sous_totalOP * (1+ $facture->taux_tva) + $Sous_totalArt * (1+ $facture->taux_tva);
        ?>
        <button onclick='document.location.href="ajout_reglement.php?id='<?php echo $_GET['id']?>>Ajout Règlement</button>

</tbody>
</table>
    </main>
</body>
<!-- Same on all pages -->
<?php
    require 'footer.php';
    createFooter();
?>
</html>