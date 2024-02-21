<?php
require 'header.php';
?>
<?php
    if(isset($_GET['id_interv'])) {
        $interventionDao = new InterventionDAO(MaBD::getInstance());
        $intervention = $interventionDao->getOne($_GET['id_interv']);

        if ($intervention->getOperateur() == null) {
            header("Location: completer_RDV.php?id=$intervention->num_dde");
        }

        $prevoirOpDao = new PrevoirOperationsDAO(MaBD::getInstance());
        $operationsPrevues = $prevoirOpDao->getAllIntervention($intervention);

        $prevoirArtDao = new PrevoirArticlesDAO(MaBD::getInstance());
        $articlesPrevues = $prevoirArtDao->getAllIntervention($intervention);

        $operations = array();
        foreach ($operationsPrevues as $operation) {
            $operationDao = new OperationDAO(MaBD::getInstance());
            $operations[] = $operationDao->getOne($operation->code_op);
        }

        $articles = array();
        foreach ($articlesPrevues as $article) {
            $articleDao = new ArticleDAO(MaBD::getInstance());
            $articles[] = $articleDao->getOne($article->code_article);
        }

        $clientDao = new ClientDAO(MaBD::getInstance());
        $client = $clientDao->getOne($intervention->code_client);

        $operateurDao = new OperateurDAO(MaBD::getInstance());
        $operateur = $operateurDao->getOne($intervention->id_operateur);
    } else {
        header('Location: afficher_intervention.php');
    }
?>
<link rel="stylesheet" href="../Style/ordre_intervention.css">
<body>
    <main>
        <h1>Ordre Intervention n°<?php echo $intervention->num_dde;?></h1>
        <h2>Informations</h2>
        <div class="info">
            <div class="info-box">
                <h3>Client</h3> 
                <p><?php echo $client->getFullName()?></p>
            </div>
            <div class="info-box">
                <h3>Opérateur</h3> 
                <p><?php echo $operateur->getFullName()?></p>
            </div>
            <div class="info-box">
                <h3>Date</h3> 
                <p><?php echo $intervention->date_rdv?></p>
            </div>
            <div class="info-box">
                <h3>Heure</h3> 
                <p><?php echo $intervention->heure_rdv?></p>
            </div>
            <div class="info-box">
                <h3>Vehicule</h3> 
                <p><?php echo $intervention->no_immatriculation?></p>
            </div>
        </div>
        <h2>Description</h2>
        <div class="description info">
            <p><?php echo $intervention->descriptif_demande?></p>
        </div>
        <h2>Opérations</h2>
        <div class="operations info">
            <table>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Temps</th>
                </tr>
                <?php
                    foreach ($operations as $operation) {
                        echo "<tr>";
                        echo "<td>";
                        echo $operation->code_op;
                        echo "</td>";
                        echo "<td>";
                        echo $operation->libelle_op;
                        echo "</td>";
                        echo "<td>";
                        echo $operation->duree_op;
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        <h2>Articles</h2>
        <div class="articles info">
            <table>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Quantité</th>
                </tr>
                <?php
                    foreach ($articles as $article) {
                        echo "<tr>";
                        echo "<td>";
                        echo $article->code_article;
                        echo "</td>";
                        echo "<td>";
                        echo $article->libelle_article;
                        echo "</td>";
                        echo "<td>";
                        echo $prevoirArtDao->getQte($intervention, $article);
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        <button class="no-print" onclick="window.print()">Imprimer</button>
    </main>
</body>