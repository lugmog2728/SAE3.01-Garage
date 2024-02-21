<?php 
require "../autoload.php";
$info = array(
        'table' => $_GET['table'],
        'col' => $_GET['col'],
        'val' => $_GET['value']
      );

var_dump($info);
getOneRandomClass($info);

/**
 * Supprime une ligne de la table
 * @param array $ref
 */
function getOneRandomClass($ref)
{

    $sql = "DELETE FROM " . $ref['table'] . " WHERE " . $ref['col'] . " = " . $ref['val'];
    echo ($sql);
    $stmt = MaBD::getInstance()->prepare("$sql");
 
    
    // Exécuter la requête
    $stmt->execute();


}