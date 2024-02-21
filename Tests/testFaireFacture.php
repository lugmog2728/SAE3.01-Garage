<?php 
require_once __DIR__ . "</../autoload.php";
$daoF = new FacturesDAO(MaBD::getInstance());

echo "Création de la facture 1\n";
Facture::nouvelle_facture(1);

echo "Création de la facture 2 (Déjà existante)\n";
Facture::nouvelle_facture(2);

?>