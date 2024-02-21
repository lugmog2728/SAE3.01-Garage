<?php 
require_once __DIR__ . "</../autoload.php";
$dao= new InterventionDAO(MaBD::getInstance());

echo "Cloture du Rendez-Vous 3 (Non cloturé)\n";
$rdv = $dao->getOne(3)->clore();

echo "Cloture du Rendez-Vous 2 (Cloturé)\n";
$rdv = $dao->getOne(2)->clore();

echo "Cloture du Rendez-Vous 1 (Annulé) [Erreur attendu]\n";
$rdv = $dao->getOne(1)->clore();

?> 