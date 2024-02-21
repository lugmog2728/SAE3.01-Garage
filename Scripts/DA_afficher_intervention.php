
<?php
require "../autoload.php";

$sql = $_GET['sql'];
$num_dde = $_GET['num_dde'];

$interventionDAO = new InterventionDAO(MaBD::getInstance());
$preArticleDAO = new PrevoirArticlesDAO(MaBD::getInstance());
$preOpDAO = new PrevoirOperationsDAO(MaBD::getInstance());

$temp = $interventionDAO->getone($num_dde);

switch ($sql){
    case 'delete':
        $preArticleDAO->deleteAll($temp->num_dde);
        $preOpDAO->deleteAll($temp->num_dde);
        
        $interventionDAO->delete($temp);
        break;
    case 'annule':
        $temp->annulerIntervention();
        $interventionDAO->update($temp);
}
