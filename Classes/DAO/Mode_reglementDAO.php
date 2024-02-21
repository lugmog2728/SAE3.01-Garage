<?php
/**
 * Classe Mode_reglementDAO
 */
class Mode_reglementDAO extends DAO{


    /**
     * Récupération d'une mode_reglement dont on donne l'identifiant
     * @param string|int|array $ref Identifiant de la mode_reglement
     * @return Mode_reglement
     */
    public function getOne(string|int|array $ref): Mode_reglement {
        $stmt = $this->pdo->prepare("SELECT * FROM mode_reglement WHERE no_mode_regl=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Mode_reglement($row);
    }


    /**
     * Récupération de toutes les Tarifs
     * @return array $res liste des Tarifs
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM mode_reglement ORDER BY no_mode_regl");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Mode_reglement($row);
        return $res;
    }

    /**
     * Insertion d'une mode_reglement dans la base
     * @param object $obj Mode_reglement à insérer
     * @return int $res succès de l'insertion
     */
    public function insert(object $obj): int {
       $stmt =  $this->pdo->prepare("INSERT INTO mode_reglement (no_mode_regl, libelle_mode_regl) VALUES (:no_mode_regl, :libelle_mode_regl) ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Mise à jour d'une mode_reglement dans la base
     * @param object $obj Mode_reglement à mettre à jour
     * @return int $res succès de la mise à jour
     */
    public function update(object $obj): int {
       $stmt = $this->pdo->prepare("UPDATE mode_reglement SET libelle_mode_regl=:libelle_mode_regl WHERE  no_mode_regl=:no_mode_regl ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Suppression d'une mode_reglement dans la base
     * @param object $obj Mode_reglement à supprimer
     * @return int $res succès de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM mode_reglement WHERE no_mode_regl=?");
        $res = $stmt->execute(array($obj->no_mode_regl));
        return $res;
    }

    /**
     * Récupération du prochain identifiant de mode_reglement
     * @return int $id prochain identifiant
     */
    public function getNewId(): int{
        $stmt = $this->pdo->query("SELECT max(no_mode_regl) FROM mode_reglement");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }

}