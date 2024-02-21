<?php
/**
 * Classe RealiserOpDAO
 */
class RealiserOpDAO extends DAO {

    
        /**
         * Récupération d'un objet PrevoirOperations dont on donne l'identifiant
         * @param string|int|array $ref identifiant du produit
         * @return Operation objet Operation
         */
        public function getOne(string|int|array $ref): Operation {
            $stmt = $this->pdo->prepare("SELECT * FROM realiser_op WHERE code_op=? and no_facture=?");
            $stmt->execute(array($ref));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Operation($row);
        }

        /**
         * Récupération de la liste des Operation
         * @return array $res liste des Operation
         */
        public function getAll(): array {
            $res = array();
            $stmt = $this->pdo->query("SELECT * FROM realiser_op ORDER BY no_facture ,code_op");
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
           $stmt = $this->pdo->prepare("UPDATE realiser_op SET cout_horaire_ht=:cout_horaire_ht, duree_reel=:duree_prevu
                                                           where code_op=:code_op and no_facture=:num_dde");
           $res = $stmt->execute($obj->getFields());
           return $res;
        }
    
        /**
         * Suppression d'un Operation
         * @param object $obj object PrevoirOperations
         * @return int $res résultat de la suppression
         */
        public function delete(object $obj): int {
            $stmt = $this->pdo->prepare("DELETE FROM realiser_op WHERE no_facture=? and code_op=?");
            $res = $stmt->execute(array($obj->no_facture, $obj->code_op));
            return $res;
        }
    
    
    //Seule les fonction ci-dessous sont fonctionnel 
    
        /**
         * Retourne la liste des opération
         * @return array $res liste des opération
         */
        public function getAllIntervention($obj): array {
            $res = array();
            $stmt = $this->pdo->prepare("SELECT * FROM realiser_op where no_facture=? ORDER BY code_op ");
            $stmt->execute(array($obj->no_facture));
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
           $stmt =  $this->pdo->prepare("INSERT INTO realiser_op (code_op, no_facture, cout_horaire_ht, duree_reel)
                                                         VALUES (:code_op, :num_dde, :cout_horaire_ht, :duree_prevue)");
           $res = $stmt->execute($obj->getFields());
           return $res;
        }
    }
    
    
