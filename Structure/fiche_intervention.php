<?php
require "../autoload.php";
include "header.php";
 // auto complétion

$interventionDAO = new InterventionDAO(MaBD::getInstance());
$preArticleDAO = new PrevoirArticlesDAO(MaBD::getInstance());
$preOpDAO = new PrevoirOperationsDAO(MaBD::getInstance());
$operationsDAO = new OperationDAO(MaBD::getInstance());
$articleDAO = new ArticleDAO(MaBD::getInstance());
$clientsDAO =  new ClientDAO(MaBD::getInstance());
$operateurDAO = new OperateurDAO(MaBD::getInstance());

$intervention = $interventionDAO->getOne($_GET['id']);

$articles = $preArticleDAO->getAllIntervention($intervention);
$operations = $preOpDAO->getAllIntervention($intervention);
$client = $clientsDAO->getOne($intervention->code_client);

$devis_on ='';
if ($intervention->devis_on == true){
    $devis_on = 'checked';
}

if(isset($intervention->id_operateur)){
    $operateurC =  $operateurDAO->getOne($intervention->id_operateur);
    $curentOperateur = $operateurC->nom . ' ' . $operateurC->prenom;
}
?>


<html>
    <head>
        <title>Fiche Intervention</title>
    </head>
    <link rel="stylesheet" href="./../Style/completer_RDV">
    <body>
        <section>
                <article id="info">
                    
                    <article id="info_vehicule">
                        <p class="titre_block"> Information Véhicule </p>
                        
                        <label><?php echo("no immat " .$intervention->no_immatriculation);?></label>
                        </label><?php echo("km : " . $intervention->km_actuel);?></label>
                    </article>
                    
                    <article id="info_RDV">
                        <p class="titre_block"> Information RDV </p>
                        <article id="info_block">
                            <article class="inner_infoRDV">
                                <label value ='Nom_client'> <?php echo ($client->nom . ' ' . $client->prenom);?></label>
                                
                                <article class="devis">
                                    <p>Devis: </p>
                                    <label> <?php echo($devis_on)?> </label>
                                </article>
                            </article>
                            <article class="inner_infoRDV">
                                <article id="block_date">
                                    <label type="date" name="Date_RDV" id="date_interv" required value= <?php echo($intervention->date_rdv)?>>
                                    <label><?php echo($intervention->heure_rdv)?></label>
                                </article>
                                <article id="etat_block">
                                    <p>Etat demande: </p>
                                    <label>
                                        <?php echo($intervention->etat_demande) ?>
                                    </label>
                                </article>
                            </article>
                        </article>
                    </article>
                    
                    <article id="info_interv">
                        <article id="block_descript_interv">
                            <p class="titre_block">Operations</p>
                            <?php 
                            $countinmput = 1;
                            foreach($operations as $onceOp){
                                $currentOp= $operationsDAO->getOne($onceOp->code_op);
                                echo ("<label>". $currentOp->libelle_op.'</label>');
                            }
                            ?> 
                        </article>
                    </article>
                    
                    <article id="info_article">
                        <article id="block_descript_article">
                            <p class="titre_block">Articles</p>
                            <?php
                            $countinmput = 1;
                            foreach ($articles as $onceArticle) {
                                $currentArt = $articleDAO->getOne($onceArticle->code_article);
                                echo ('<article class="onceArticle">
                                <label>' . $currentArt->libelle_article . ' Qte =' . $onceArticle->qte_prevue . '</label>
                                </article>');
                            }
                            ?>
                        </article>
                    </article>
                    
                    <article id="info_operateur">
                        <article id="block_liste_operateur">
                            <p class="titre_block">Operateur</p>
                            <?php 
                            echo('<label>'. $curentOperateur.'<label>')

    ?>
                            
                            
                        </article>
                    </article>


                </article>

                <article id="zone_descript">
                    <p class="titre_block">Descrition de L'intervention </p>
                    <label> <?php echo($intervention->descriptif_demande); ?> </label>
                </article>



                <article id="button">
                    <input id="valide" type="submit" value="Valider">
                </article>

                <datalist id="alloperation">
                    <?php 
                    foreach ($operationsDAO->getAll() as $operations) {
                        $operations->getOption();
                    }
                    ?>
                </datalist>



                <datalist id="allArticle">
                    <?php
                    foreach ($articleDAO->getAll() as $articles) {
                        $articles->getOption();
                    }
                    ?>
                </datalist>

                <datalist id="alloperateur">
                    <?php 
                    foreach ($operateurDAO->getAll() as $operateur) {
                        $operateur->getOption();
                    }
                    ?>
                </datalist>

        </section>
    </body>

    <script src="./../Scripts/add_input.js"></script>

</html>