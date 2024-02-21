<?php
require "../autoload.php";


$numMarque = $_GET['marque'];


$modeleDAO = new ModeleDAO(MaBD::getInstance());
$modeles = $modeleDAO->getByMarque($numMarque);


$html = "<option value=''> Sélectionnez un modèle </option>";

foreach ($modeles as $modele) {
  $html .= '<option value="' . $modele->num_modele . '">' . $modele->modele . '</option>';
}


echo $html;
