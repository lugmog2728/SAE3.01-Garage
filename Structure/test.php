<?php
    include "header.php";

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




