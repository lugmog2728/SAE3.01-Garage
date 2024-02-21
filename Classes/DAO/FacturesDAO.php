<?php
/**
 * Classe pour l'accès à la table produit
 */
class FacturesDAO extends DAO {

    /**
     * Récupération de la dernière facture
     * @return int $id identifiant de la dernière facture
     */
    public function getID(){
        $stmt = $this->pdo->query("SELECT max(no_facture) FROM facture");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        echo $id;
        return $id+1;
    }

    /**
     * Récupération d'une facture dont on donne l'identifiant
     * @param string|int|array $ref Identifiant de la facture
     * @return Facture
     */
    public function getOne(string|int|array $ref): Facture {
        $stmt = $this->pdo->prepare("SELECT * FROM facture WHERE no_facture=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Facture($row);
    }

    /**
     * Récupération de toutes les factures
     * @return array $res liste des factures
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM facture ORDER BY no_facture");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Facture($row);
        return $res;
    }

    /**
     * Insertion d'une facture dans la base
     * @param object $obj Facture à insérer
     * @return int $res succès de l'insertion
     */
    public function insert(object $obj): int {
       $stmt =  $this->pdo->prepare("INSERT INTO facture (no_facture, date_facture, taux_tva, net_a_payer, etat_facture, num_dde) VALUES (:no_facture, :date_facture, :taux_tva, :net_a_payer, :etat_facture, :num_dde) ");
       str_replace(".",",",$obj->taux_tva);
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Mise à jour d'une facture dans la base
     * @param object $obj Facture à mettre à jour
     * @return int $res succès de la mise à jour
     */
    public function update(object $obj): int {
       $stmt = $this->pdo->prepare("UPDATE facture SET date_facture=:date_facture, taux_tva=:taux_tva, net_a_payer=:net_a_payer , etat_facture=:etat_facture, num_dde=:num_dde WHERE  no_facture=:no_facture ");
       str_replace(".",",",$obj->taux_tva);
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Suppression d'une facture dans la base
     * @param object $obj Facture à supprimer
     * @return int $res succès de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM facture WHERE no_facture=?");
        $res = $stmt->execute(array($obj->no_facture));
        return $res;
    }

}

