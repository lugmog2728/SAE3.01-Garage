<?php
    include "header.php";
    include "../Scripts/tableaux.php";

/**
 * Initialisation de tout les DAO nécessaire pour la page 
 */
    $interventionDAO = new InterventionDAO(MaBD::getInstance());
    $preArticleDAO = new PrevoirArticlesDAO(MaBD::getInstance());
    $preOpDAO = new PrevoirOperationsDAO(MaBD::getInstance());
    $operationsDAO = new OperationDAO(MaBD::getInstance());
    $articleDAO = new ArticleDAO(MaBD::getInstance());
    $clientsDAO =  new ClientDAO(MaBD::getInstance());
    $operateurDAO = new OperateurDAO(MaBD::getInstance());
    $tarifDAO = new TarifDAO(MaBD::getInstance());
    $realiserOpDAO = new RealiserOpDAO(MaBD::getInstance());
    $utiliserArtDAO = new UtiliserArticleDAO(MaBD::getInstance());
    $factureDAO = new FacturesDAO(MaBD::getInstance());
    $parametreDAO = new ParametresDAO(MaBD::getInstance());
    $vehiculeDAO = new VehiculeDAO(MaBD::getInstance());
/**
 * Fin de l'initialisation de tout les DAO nécessaire pour la page 
 */



 /**
 * Mise à jour de l'intervention après validation par l'utilisateur
 */
if (sizeof($_POST)!=0) {

    $preOperationDAO = new PrevoirOperationsDAO(MaBD::getInstance());
    $oldIntervention = $interventionDAO->getOne($_POST['num_dde']);
    $num_dde = $oldIntervention->num_dde;

    $newIntervention = [];
    $newIntervention['num_dde'] = $oldIntervention->num_dde;
    $newIntervention['date_rdv'] = $_POST['Date_RDV'];
    $newIntervention['heure_rdv'] = $_POST['Heure_RDV'];
    $newIntervention['descriptif_demande'] = $_POST['Descriptif_demande'];
    $newIntervention['km_actuel'] = $_POST['km_imat'];
    $newIntervention['devis_on'] = isset($_POST['devis_on']);
    $newIntervention['etat_demande'] = $_POST['etat'];
    $newIntervention['code_client'] = $oldIntervention->code_client;
    $newIntervention['no_immatriculation'] = $_POST['imat'];
    $newIntervention['id_operateur'] = getoperateurTab()[$_POST['operateur']]->id_operateur;
    $maj = new Intervention($newIntervention);
    
    $interventionDAO->update($maj);

    switch($_POST['etat']){

        case 'EN COURS':
            $lesOperations = getOperationTab();
            $lesArticles = getArticleTab();

            //prev operation
            $operationCount = 1;
            while (isset($_POST['opperation' . $operationCount])) {
                $operation = $lesOperations[$_POST['opperation' . $operationCount]];
                $idOperation = $operation->code_op;
                $dureeOp = $operation->duree_op;
                $coutOP_HT = $operation->code_tarif;
                $coutOP_HT = $tarifDAO->getprix($coutOP_HT);
                $prevOp = new Operation(
                    array(
                        "code_op" => $idOperation,
                        "num_dde" => $oldIntervention->num_dde,
                        "cout_horaire_ht" => $coutOP_HT,
                        "duree_prevue" => $dureeOp
                    ));
            

                // Check if operation exists and get it
                if ($preOperationDAO->getOnewith2param($prevOp->code_op, $prevOp->num_dde) == null) {
                    $preOperationDAO->insert($prevOp);
                }
                $operationCount++;
            }


            //prev article
            $articleCount = 1;
            while (isset($_POST['Article' . $articleCount])) {
                $tempArticle = $articleDAO->getOneFromLibelle($_POST['Article' . $articleCount]);
                $idArticle = $tempArticle->code_article;
                $article = $articleDAO->getOne($idArticle);
                $pu_ht = $article->prix_unit_actuel_ht;
                $prevArt = new Article(
                    array(
                        "num_dde" => $oldIntervention->num_dde,
                        "code_article" => $idArticle,
                        "pu_ht" => $pu_ht,
                        "qte_prevue" => $_POST['qteArticle' . $articleCount]
                    )
                    
                );
                $check = $preArticleDAO->getOneWith3param($prevArt->code_article, $prevArt->num_dde, $prevArt->qte_prevue);
                switch ($check) {
                    case null:
                        $preArticleDAO->insert($prevArt);
                        break;
                    case 'false':
                        $preArticleDAO->update($prevArt);
                        break;
                    default:
                        break;
                }
                $articleCount++;
            }

            header("Location: fiche_intervention.php?id=$num_dde");
            break;
/**
 * Fin de la mise à jour de l'intervention. 
 */



/**
 * Finalisation de l'intervention.
 * Création d'une facture 
 */
        case 'TERMINE': 
            $lesOperations = getOperationTab();
            $lesArticles = getArticleTab();

            $tempTVA = $parametreDAO->getOne(1);
            $TVA = $tempTVA->taux_tva_actuel;
            $facture = Facture::nouvelle_facture($_POST['num_dde']);

            //realiser op
            $operationCount = 1;
            while (isset($_POST['opperation' . $operationCount])) {
                $operation =  $lesOperations[$_POST['opperation' . $operationCount]];
                $idOperation = $operation->code_op;
                $dureeOp = $operation->duree_op;
                $coutOP_HT = $operation->code_tarif;
                $coutOP_HT = $tarifDAO->getprix($coutOP_HT);
                $currentOp = new Operation(
                    array(
                        "code_op" => $idOperation,
                        "num_dde" => $facture->no_facture,
                        "cout_horaire_ht" => $coutOP_HT,
                        "duree_prevue" => $dureeOp
                    )
                );
                $realiserOpDAO->insert($currentOp);
                $operationCount++; 
            }

            $articleCount = 1;
            while (isset($_POST['Article' . $articleCount])) {
                $article =  $lesArticles[$_POST['Article' . $articleCount]];
                $idArticle = $article->code_article;
                $pu_ht = $article->prix_unit_actuel_ht;
                $currentArt= new Article(
                    array(
                        "num_dde" => $facture->no_facture,
                        "code_article" => $idArticle,
                        "pu_ht" => $pu_ht,
                        "qte_prevue" => $_POST['qteArticle' . $articleCount]
                    )
                );
                $utiliserArtDAO->insert($currentArt);
                $articleCount++;
            }
            $tarif = $facture->tarifier();
            $facture->net_a_payer = $tarif;
            $factureDAO->update($facture);
            header("Location: accueil.php");
            break;

        case 'ANNULE':
            $num_dde = $_POST['num_dde'];
            $interventionDAO->annuler($num_dde);
            header("Location: afficher_intervention.php?id=$num_dde");
            break;
    }
    die();
} 
 /**
 * Fin de la mise à jour de l'intervention après validation par l'utilisateur
 */



/**
 * Récupération des information de l'intervention selectionner
 */
else {
    // auto complétion
    $intervention = $interventionDAO->getOne($_GET['id']);

    switch ($intervention->etat_demande) {
        case 'EN COURS':
            $etat = '<option value="EN COURS" selected> En cours </option>
                    <option value="ANNULE"> Annulé </option>
                    <option value="TERMINE"> Terminé </option>';
            break;
        case 'ANNULE':
            header("Location: fiche_intervention.php?id=$intervention->num_dde");
            break;
        case 'TERMINE':
            header("Location: fiche_intervention.php?id=$intervention->num_dde");
            break;
    }

    $articles = $preArticleDAO->getAllIntervention($intervention);
    $operations = $preOpDAO->getAllIntervention($intervention);
    $client = $clientsDAO->getOne($intervention->code_client);

    $devis_on = '';
    if ($intervention->devis_on == true) {
        $devis_on = 'checked';
    }

}
/**
 * Fin de la récupération des information de l'intervention selectionner
 */
?>

























<!-- Création de la page de l'intervention -->
<html>
    <head>
        <title>Completer RDV</title>
    </head>
    <link rel="stylesheet" href="./../Style/completer_RDV">
    <body>
        <main>
            <h3 class="h3-title">Compléter un RDV</h3>

            <form id="form" method="post">

                <article id="info">
                    <input type="text" id="num_dde" name='num_dde' <?php echo('value="'. $intervention->num_dde . '"') ;?>
                        Style="display:none;">
                    <article id="info_vehicule">
                        <h4 class="titre_block"> Information Véhicule </h4>

                        <?php
                            $imat = $interventionDAO->checkImat($intervention->num_dde);
                            if($imat != null){
                                echo ('<input type="text" list="immatricu" name="imat" placeholder="Numero d\'immatriculation" require="" value ="' . $imat . '">
                                    <input type="number" id="km_actu" name="km_imat" placeholder="Kilometrage actuelle" value ="' . $intervention->km_actuel . '" required>');
                            }else{
                                echo ('<input type="text" list="immatricu" name="imat" placeholder="Numero d\'immatriculation" required="">
                                    <input type="number" id="km_actu" name="km_imat" placeholder="Kilometrage actuelle" required"">');
                            }
                            
                        ?>

                        <button type="button" id="ajout_immat" onclick="window.open('UI/UI_vehicule.php', '_blank')">+</button>
                    </article>
                    <article id="info_RDV">
                        <h4 class="titre_block"> Information RDV </h4>
                        <article id="info_block">
                            <article class="inner_infoRDV">
                                <label value='Nom_client'> <?php echo ($client->nom . ' ' . $client->prenom);?></label>

                                <article class="devis">
                                    <p>Devis: </p>
                                    <input type="checkbox" name='Devis_on' id="input_devis" value=<?php echo($devis_on)?>>
                                </article>
                            </article>
                            <article class="inner_infoRDV">
                                <article id="block_date">
                                    <input type="date" name="Date_RDV" id="date_interv" required
                                        value=<?php echo($intervention->date_rdv)?>>
                                    <input type="time" name="Heure_RDV" id="heure_rdv" min="09:00" max="18:00" required
                                        value=<?php echo($intervention->heure_rdv)?>>
                                </article>
                                <article id="etat_block">
                                    <p>Etat demande: </p>
                                    <select id="etat" name="etat">
                                        <?php echo($etat) ?>
                                    </select>
                                </article>
                            </article>
                        </article>
                    </article>

                    <article id="info_interv">
                        <article id="block_descript_interv">
                            <h4 class="titre_block">Opérations</h4>
                            <?php 
                            $countinmput = 1;
                            foreach($operations as $onceOp){
                                $currentOp= $operationsDAO->getOne($onceOp->code_op);
                                echo ('<input class="operation" type="text" list="alloperation" name="opperation' . $countinmput . '" placeholder="Operation" 
                                required="" value="'. $currentOp->libelle_op.'">');
                                $countinmput += 1;
                            }
                            ?>
                        </article>
                        <button type="button" id="ajout_opperation">+</button>
                    </article>

                    <article id="info_article">
                        <article id="block_descript_article">
                            <h4 class="titre_block">Articles</h4>
                            <?php
                                $countinmput = 1;
                                foreach ($articles as $onceArticle) {
                                    $currentArt = $articleDAO->getOne($onceArticle->code_article);
                                    echo ('<article class="onceArticle">
                                    <input type="text" class="libelleArt" name="Article'. $countinmput .'" placeholder="Article" list="allArticle" 
                                    required="" value="' . $currentArt->libelle_article . '">
                                    <input type="number" class="qte" name="qteArticle'. $countinmput .'" placeholder="Qte" min="1" 
                                    required="" value="' . $onceArticle->qte_prevue . '">
                                    </article>');
                                    $countinmput++;
                                }
                            ?>
                        </article>
                        <button type="button" id="ajout_article">+</button>
                    </article>

                    <article id="info_operateur">
                        <article id="block_liste_operateur">
                            <h4 class="titre_block">Opérateurs</h4>
                            <?php
                            
                            $operateur = $interventionDAO->checkOperateur($intervention->num_dde);
                            if($operateur != null){
                                echo ('<input class="operateur" type="text" name="operateur" list="alloperateur" placeholder="Operateur" required="" value="' . $operateurDAO->getOne($operateur)->nom." ". $operateurDAO->getOne($operateur)->prenom . '">');
                            }else{
                                echo ('<input class="operateur" type="text" name="operateur" list="alloperateur" placeholder="Operateur" required="" >');
                            }

                            ?>
                            <button type="button" id="ajout_opperation" onclick="window.open('UI/UI_operateur.php', '_blank')">+</button>

                        </article>
                    </article>


                </article>

                <article id="zone_descript">
                    <h4 class="titre_block">Description de L'intervention </h4>
                    <textarea id="description-area" name='Descriptif_demande'
                        required> <?php echo($intervention->descriptif_demande); ?> </textarea>
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

                <datalist id="immatricu">
                    <?php
                        foreach ($vehiculeDAO->getAll() as $vehicule) {
                            echo($vehicule);
                            $vehicule->getOption();
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

            </form>
        </main>
    </body>
    
<script src="./../Scripts/add_input.js"></script>
<!--<script src="./../Scripts/update_completerRDV.js">-->
</html>