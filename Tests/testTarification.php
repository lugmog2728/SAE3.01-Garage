<?php
require_once __DIR__ . "</../autoload.php";
$dao = new FacturesDAO(MaBD::getInstance());
echo"Obtention de la tarification de toute les facture\n";
foreach ($dao->getAll() as $facture) {
    echo $facture->no_facture ." : ". $facture->tarifier()." €\n\n";
}
echo "";

echo "Obtention de la tarification de la facture 1\n";
$facture = $dao->getOne(1);
echo $facture->no_facture ." : ". $facture->tarifier()." €\n\n";

echo "Obtention de la tarification de la facture 2\n";
$facture = $dao->getOne(2);
echo $facture->no_facture ." : ". $facture->tarifier()." €\n\n";

echo "Obtention de la tarification de la facture 3\n";
$facture = $dao->getOne(3);
echo $facture->no_facture ." : ". $facture->tarifier()." €\n\n";
?>