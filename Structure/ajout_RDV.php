<?php
include "header.php";
include "../Scripts/tableaux.php";

if (isset($_POST['client'])) {
    /**
     * Création des différent DAO
     */
    $prevArtDAO = new PrevoirArticlesDAO(MaBD::getInstance());
    $prevOpDAO = new PrevoirOperationsDAO(MaBD::getInstance());
    $tarifDAO = new TarifDAO(MaBD::getInstance());
    $operationDAO = new OperationDAO(MaBD::getInstance());
    $articleDAO = new ArticleDAO(MaBD::getInstance());
    $interventionDAO = new InterventionDAO(MaBD::getInstance());


    /**
     * Création des différents tableaux de références
     */
    $lesArticles = getArticleTab();
    $lesClients = getclientTab();
    $lesOperation = getOperationTab();

    $articleCount = 1;
    $operationCount = 1;


    /**
     * Récupération du client
     */
    $client = $lesClients[$_POST['client']];
    $idClient = $client->code_client;


    $info = array(
        "date_rdv" => $_POST['Date_RDV'],
        "num_dde" => $interventionDAO->getNewId(),
        "heure_rdv" => $_POST['Heure_RDV'],
        "descriptif_demande" => $_POST['Descriptif_demande'],
        "km_actuel" => null,
        "devis_on" => isset($_POST['Devis_on']),
        "etat_demande" => "EN COURS",
        "code_client" => $idClient,
        "no_immatriculation" => null,
        "id_operateur" => null
    );
    /**
     * Création d'un nouvelle intervention
     */
    $intervention = new Intervention($info);
    $interventionDAO->insert($intervention);
    $idIntervention = $intervention->num_dde;
    /**
     * Création et ajout des opérations dans la base de donnée
     */
    while (isset($_POST['opperation' . $operationCount])) {
        $operation = $lesOperation[$_POST['opperation' . $operationCount]];
        $idOperation = $operation->code_op;
        $dureeOp = $operation->duree_op;
        $code_tarif = $operation->code_tarif;
        $coutOP_HT = $tarifDAO->getprix($code_tarif);

        $prevOp = new Operation(
            array(
                "code_op" => $idOperation,
                "num_dde" => $idIntervention,
                "cout_horaire_ht" => $coutOP_HT,
                "duree_prevue" => $dureeOp
            )
        );
        $prevOpDAO->insert($prevOp);
        $operationCount++;
    }

    /**
     * Création et ajout des articles dans la base de donnée
     */
    while (isset($_POST['Article' . $articleCount])) {

        $article = $lesArticles[$_POST['Article' . $articleCount]];
        $idArticle = $article->code_article;
        $pu_ht = $article->prix_unit_actuel_ht;

        $prevArt = new Article(
            array(
                "num_dde" => $idIntervention,
                "code_article" => $idArticle,
                "pu_ht" => $pu_ht,
                "qte_prevue" => $_POST['qteArticle' . $articleCount]
            )
        );
        $prevArtDAO->insert($prevArt);
        $articleCount++;
    }

    header("Location: ./completer_RDV.php?id=$idIntervention");
}
?>













































<html>
  <head>
      <title>Ajouter RDV</title>
  </head>
    <script src="../Scripts/add_input.js"></script>
    <link rel="stylesheet" href="./../Style/ajout_RDV.css">
    <body>
        <main>
            <h3 class="h3-title">Ajouter un RDV</h3>

            <form action="" id="form" method="post">
                <article id="info">

                    <article id="info_RDV">
                        <h4 class="titre_block">Informations RDV </h4>
                        <article id ='client_block'>
                        <input type="text" list="allClient" id="client" name="client" placeholder="Nom client">
                        <button type="button" id="ajout_opperation" onclick="window.open('UI/UI_client.php', '_blank')">Fournir des informations</button>
                    </article>

                    <article class="devis">
                        <h5 class="titre_block">Devis :</h5>
                        <input type="checkbox" name='Devis_on' id="input_devis">
                    </article>
                    <article id="block_date">
                        <input type="date" name="Date_RDV" id="date_interv" required>
                        <input type="time" name="Heure_RDV" id="heure_rdv" min="09:00" max="18:00" required>
                    </article>
                </article>

                <article id="info_interv">
                    <article id="block_descript_interv">
                        <h4 class="titre_block">Opérations</h4>

                    </article>
                    <button type="button" id="ajout_opperation" onclick="buttonClickedOperation()">Ajouter une opération</button>
                    <!--<button type="button" id="ajout_opperation"onclick="lessInputOp()">-</button> -->
                </article>


                <article id="info_article">
                    <article id="block_descript_article">
                        <h4 class="titre_block">Articles</h4>
                    </article>
                    <button type="button" id="ajout_article" onclick="buttonClickedArticle()">Ajouter un article</button>
                </article>


            </article>
            <article id="zone_descript">
                <h4 class="titre_block">Description de l'intervention </h4>
                <textarea id="description-area" name='Descriptif_demande' required> </textarea>
            </article>


            <article id="button">
                <input id="valide" type="submit" value="Valider">
            </article>

            <datalist id="alloperation">
                <?php $operationsDAO = new OperationDAO(MaBD::getInstance());
                foreach ($operationsDAO->getAll() as $operations) {
                    $operations->getOption();
                }
                ?>
            </datalist>

            <datalist id="allClient">
                <?php $clientsDAO = new ClientDAO(MaBD::getInstance());
                foreach ($clientsDAO->getAll() as $clients) {
                    $clients->getOption();
                }
                ?>
            </datalist>

            <datalist id="allArticle">
                <?php $articleDAO = new ArticleDAO(MaBD::getInstance());
                foreach ($articleDAO->getAll() as $articles) {
                    $articles->getOption();
                }
                ?>
            </datalist>
        </form>
    </section>
    <?php
    require "footer.php";
    createFooter();
    ?>
</body>

</html>
