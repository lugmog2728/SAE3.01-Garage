<?php
/**
 * Renvoie un tableau contenant les opérations disponibles dans la BDD
 * @return array Operation
 */
function getOperationTab(){
        $res = array();
        $stmt = MaBD::getInstance()->query("SELECT * FROM operation");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[$row['libelle_op']] = new Operation($row);
        return $res;
    }
/**
 * Renvoie un tableau contenant les articles disponibles dans la BDD
 * @return array Article
 */
function getArticleTab(){
    $res = array();
    $stmt = MaBD::getInstance()->query("SELECT * FROM article");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        $res[$row['libelle_article']] = new Article($row);
    return $res;
}
/**
 * Renvoie un tableau contenant les opérateurs disponibles dans la BDD
 * @return array Operateur
 */
function getoperateurTab(){
    $res = array();
    $stmt = MaBD::getInstance()->query("SELECT * FROM operateur");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        $res[$row['nom']." ".$row['prenom']] = new Operateur($row);
    return $res;
}

/**
 * Renvoie un tableau contenant les clients disponibles dans la BDD
 * @return array Client
 */
function getclientTab(){
    $res = array();
    $stmt = MaBD::getInstance()->query("SELECT * FROM client");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        $res[$row['nom']." ".$row['prenom']] = new Operateur($row);
    return $res;
}

/**
 * Renvoie un tableau contenant les modes de règlement disponibles dans la BDD
 * @return array Mode_reglement
 */
function getmodeRegTab(){
    $res = array();
    $stmt = MaBD::getInstance()->query("SELECT * FROM mode_reglement");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        $res[$row['libelle_mode_regl']] = new Mode_reglement($row);
    return $res;
}