<?php
/**
 * Classe pour l'accès à la table produit
 */
class TarifDAO extends DAO {

    /**
     * Récupération de la dernière tarif
     * @return int $id identifiant de la dernière tarif
     */
    public function getID(){
        $stmt = $this->pdo->query("SELECT max(code_tarif) FROM tarif");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }

    /**
     * Récupération d'une tarif dont on donne le cout
     * @param string|int|array $ref cout horaire de Tarif
     * @return Tarif
     */
    public function getOneByCout(string|int|array $ref): ?Tarif {
        $stmt = $this->pdo->prepare("SELECT * FROM tarif WHERE cout_horaire_actuel_ht=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row==false){
            return null;
        }
        return new Tarif($row);
    }
    /**
     * Récupération d'une tarif dont on donne l'identifiant
     * @param string|int|array $ref Identifiant de la tarif
     * @return Tarif
     */
    public function getOne(string|int|array $ref): Tarif {
        $stmt = $this->pdo->prepare("SELECT * FROM tarif WHERE code_tarif=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Tarif($row);
    }

    /**
     * Récupération du cout d'une tarif dont on donne l'identifiant
     * @param string|int|array $ref Identifiant de la tarif
     * @return int cout horaire de Tarif
     */
    public function getprix(string|int|array $ref): int {
        $stmt = $this->pdo->prepare("SELECT * FROM tarif WHERE code_tarif=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["cout_horaire_actuel_ht"];
    }


    /**
     * Récupération de toutes les Tarifs
     * @return array $res liste des Tarifs
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM tarif ORDER BY code_tarif");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Tarif($row);
        return $res;
    }

    /**
     * Insertion d'une tarif dans la base
     * @param object $obj Tarif à insérer
     * @return int $res succès de l'insertion
     */
    public function insert(object $obj): int {
       $stmt =  $this->pdo->prepare("INSERT INTO tarif (code_tarif, cout_horaire_actuel_ht) VALUES (:code_tarif, :cout_horaire_actuel_ht) ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Mise à jour d'une tarif dans la base
     * @param object $obj Tarif à mettre à jour
     * @return int $res succès de la mise à jour
     */
    public function update(object $obj): int {
       $stmt = $this->pdo->prepare("UPDATE tarif SET cout_horaire_actuel_ht=:cout_horaire_actuel_ht WHERE  code_tarif=:code_tarif ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Suppression d'une tarif dans la base
     * @param object $obj Tarif à supprimer
     * @return int $res succès de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM tarif WHERE code_tarif=?");
        $res = $stmt->execute(array($obj->code_tarif));
        return $res;
    }

    public function getAllFacture($facture): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM reglement where no_facture = ".$facture);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Reglement($row);
        return $res;
    }

    
}