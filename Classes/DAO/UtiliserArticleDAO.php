<?php
/**
 * Classe VehiculeDAO
 */
class UtiliserArticleDAO extends DAO {

            /**
             * Récupération d'un objet PrevoirArticles dont on donne l'identifiant
             * @param string|int|array $ref identifiant du produit
             * @return Article objet PrevoirArticles
             */
            public function getOne(string|int|array $ref): Article {
                $stmt = $this->pdo->prepare("SELECT * FROM utiliser_art WHERE code_article=? and no_facture=?");
                $stmt->execute(array($ref));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return new Article($row);
            }
        
        
            /**
             * Récupération de la liste des articles
             * @return array $res liste des articles
             */
            public function getAll(): array {
                $res = array();
                $stmt = $this->pdo->query("SELECT * FROM utiliser_art ORDER BY no_facture, code_article");
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
                    $res[] = new Article($row);
                return $res;
            }
        
            /**
             * Mise à jour d'un article
             * @param object $obj objet Article
             * @return int $res résultat de la mise à jour
             */
            public function update(object $obj): int {
               $stmt = $this->pdo->prepare("UPDATE utiliser_art SET qte_fact=:qte_prevue, 
                                                                    pu_ht=:pu_ht where code_article=:code_article 
                                                                    and no_facture=:no_facture");
               $res = $stmt->execute($obj->getFields());
               return $res;
            }
        
            /**
             * Suppression d'un article
             * @param object $obj object PrevoirArticles
             * @return int $res résultat de la suppression
             */
            public function delete(object $obj): int {
                $stmt = $this->pdo->prepare("DELETE FROM utiliser_art WHERE no_facture=? and code_article=?");
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
                $stmt = $this->pdo->prepare("SELECT * FROM utiliser_art where no_facture=? ORDER BY code_article ");
                $stmt->execute(array($obj->no_facture));
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
                    $res[] = new Article($row);
                }
                return $res;
            }
        
            /**
             * Insertion d'un article dans une intervention
             * @param object $obj objet PrevoirArticles
             * @return int $res résultat de l'insertion
             */
            public function insert(object $obj): int {
               $stmt =  $this->pdo->prepare("INSERT INTO utiliser_art (no_facture, code_article, qte_fact, pu_ht) VALUES ( :num_dde, :code_article, :qte_prevue, :pu_ht) ");
               $res = $stmt->execute($obj->getFields());
               return $res;
            }
        
        }
        
        