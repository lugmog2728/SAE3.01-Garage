<?php
/**
 * Classe pour l'accès à la table PrevoirOperations
 */
class PrevoirOperationsDAO extends DAO {

//Les fonctions ci dessous ne sont pas fonctionnel. 

    /**
     * Récupération d'un objet PrevoirOperations dont on donne l'identifiant
     * @param string|int|array $ref identifiant du produit
     * @return Operation objet Operation
     */
    public function getOne(string|int|array $ref): Operation {
        $stmt = $this->pdo->prepare("SELECT * FROM prevoir_op WHERE code_op=? and num_dde=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Operation($row);
    }
 
    public function getOneWith2param(string|int|array $codeOp, string|int|array $numdde): ?Operation {
        $stmt = $this->pdo->prepare("SELECT * FROM prevoir_op WHERE code_op=? and num_dde=?");
        $stmt->execute(array($codeOp, $numdde));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row == false){
            return null;
        }
        return new Operation($row);
    }

    /**
     * Récupération de la liste des Operations
     * @return array $res liste des Operations
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM prevoir_op ORDER BY num_dde,code_op");
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
       $stmt = $this->pdo->prepare("UPDATE prevoir_op SET cout_horaire_ht=:cout_horaire_ht, duree_reel=:duree_reel where code_op=:code_op and num_dde=:num_dde");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Suppression d'un Operation
     * @param object $obj object PrevoirOperations
     * @return int $res résultat de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM prevoir_op WHERE num_dde=? and code_op=?");
        $res = $stmt->execute(array($obj->num_dde,$obj->code_op));
        return $res;
    }

    public function deleteAll ( $num_dde){
        $stmt = $this->pdo->prepare("DELETE FROM prevoir_op WHERE num_dde=?");
        $res = $stmt->execute(array( $num_dde));
        return $res;
    }


//Seule les fonction ci-dessous sont fonctionnel 

    /**
     * Retourne la liste des opération
     * @return array $res liste des opération
     */
    public function getAllIntervention($obj): array {
        $res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM prevoir_op where num_dde=? ORDER BY code_op ");
        $stmt->execute(array($obj->num_dde));
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $res[] = new Operation($row);
        }
        return $res;
    }

    /**
     * Insertion d'un Operation dans une intervention
     * @param object $obj objet Opération
     * @return int $res résultat de l'insertion
     */
    public function insert(object $obj): int {
       $stmt =  $this->pdo->prepare("INSERT INTO prevoir_op (code_op, num_dde, cout_horaire_ht, duree_prevue) VALUES (:code_op, :num_dde, :cout_horaire_ht, :duree_prevue)");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }
}

