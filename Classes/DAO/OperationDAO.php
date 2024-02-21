<?php
/**
 * Classe pour l'accès à la table PrevoirOperations
 */
class OperationDAO extends DAO {

//Les fonctions ci dessous ne sont pas fonctionnel. 

    /**
     * Récupération d'un objet PrevoirOperations dont on donne l'identifiant
     * @param string|int|array $ref identifiant du produit
     * @return Operation objet PrevoirOperations
     */
    public function getOne(string|int|array $ref): Operation {
        $stmt = $this->pdo->prepare("SELECT * FROM operation WHERE code_op=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Operation($row);
    }

    /**
     * Récupération de la liste des Operations
     * @return array $res liste des Operations
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM operation ORDER BY code_op");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Operation($row);
        return $res;
    }

    /**
     * Mise à jour d'un Operation
     * @param object $obj objet Operation
     * @return int $res résultat de la mise à jour
     */
    public function update(object $obj): int {
       $stmt = $this->pdo->prepare("UPDATE operation SET code_tarif=:code_tarif, duree_op=:duree_op, libelle_op=:libelle_op where code_op=:code_op");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Suppression d'un Operation
     * @param object $obj object PrevoirOperations
     * @return int $res résultat de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM operation WHERE code_op=?");
        $res = $stmt->execute(array($obj->code_op));
        return $res;
    }

    /**
     * Récupération d'un objet Operation dont on donne le libelle
     */
    public function getOneFromLibelle(string $libelle): Operation {
        $stmt = $this->pdo->prepare("SELECT * FROM operation WHERE libelle_op=?");
        $stmt->execute(array($libelle));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return new Operation($row);
    }

    

//Seule les fonction ci-dessous sont fonctionnel 

    /**
     * Retourne la liste des opération
     * @return array $res liste des opération
     */
    public function getAllInterventio(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM operation where num_dde ORDER BY code_Operation ");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Operation($row);
        return $res;
    }

    /**
     * Insertion d'un Operation dans une intervention
     * @param object $obj objet PrevoirOperations
     * @return int $res résultat de l'insertion
     */
    public function insert(object $obj): int {
       $stmt =  $this->pdo->prepare("INSERT INTO operation (code_op, libelle_op, duree_op, code_tarif) VALUES (:code_op, :libelle_op, :duree_op, :code_tarif) ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Retourne le dernier id de la table operation
     * @return int $id dernier id de la table operation
     */
    public function getNewId(): int{
        $stmt = $this->pdo->query("SELECT max(code_op) FROM operation");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }
}

