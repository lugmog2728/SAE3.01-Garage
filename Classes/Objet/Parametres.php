<?php
    /**
     * Classe pour l'accès à la table Parametre
     */
    class Parametres extends TableObject{
        /**
         * Retourne la valeur de la TVA en vigueur
         * @return float $tva valeur de la TVA
         */
        static function getTva(){
            $pdo = MaBD::getInstance();
            $stmn = $pdo->query("SELECT taux_tva_actuel from parametres order by id limit 1");
            return $stmn->fetch(PDO::FETCH_ASSOC)['taux_tva_actuel'];
        }
    }
?> 