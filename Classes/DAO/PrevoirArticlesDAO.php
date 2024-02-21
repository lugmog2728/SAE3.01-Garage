<?php
/**
 * Classe pour l'accès à la table PrevoirArticles
 */
class PrevoirArticlesDAO extends DAO {

//Les fonctions ci dessous ne sont pas fonctionnel. 

    /**
     * Récupération d'un objet PrevoirArticles dont on donne l'identifiant
     * @param string|int|array $ref identifiant du produit
     * @return Article objet PrevoirArticles
     */
    public function getOne(string|int|array $ref): Article {
        $stmt = $this->pdo->prepare("SELECT * FROM prevoir_art WHERE code_article=? and num_dde=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Article($row);
    }

    public function getOneWith3param(string|int|array $codeart, string|int|array $numdde, string|int|array $qte) {
        $stmt = $this->pdo->prepare("SELECT * FROM prevoir_art WHERE code_article=? and num_dde=? and qte_prevue=?");
        $stmt->execute(array($codeart, $numdde, $qte));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row == false){
            $stmt = $this->pdo->prepare("SELECT * FROM prevoir_art WHERE code_article=? and num_dde=?");
            $stmt->execute(array($codeart, $numdde));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row == false) {
                return null;
            }
            return 'false';
        }
        return new Article($row);
    }

    /**
     * Récupération de la liste des articles
     * @return array $res liste des articles
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM prevoir_art ORDER BY num_dde, code_article");
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
       $stmt = $this->pdo->prepare("UPDATE prevoir_art SET qte_prevue=:qte_prevue, 
                                                            pu_ht=:pu_ht where code_article=:code_article 
                                                            and num_dde=:num_dde");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Suppression d'un article
     * @param object $obj object PrevoirArticles
     * @return int $res résultat de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM prevoir_art WHERE num_dde=? and code_article=?");
        $res = $stmt->execute(array($obj->num_dde,$obj->code_op));
        return $res;
    }

    public function deleteAll( $num_dde){
        $stmt = $this->pdo->prepare("DELETE FROM prevoir_art WHERE num_dde=?");
        $res = $stmt->execute(array($num_dde));
        return $res;
    }


//Seule les fonction ci-dessous sont fonctionnel 

    /**
     * Retourne la liste des opération
     * @return array $res liste des opération
     */
    public function getAllIntervention($obj): array {
        $res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM prevoir_art where num_dde=? ORDER BY code_article ");
        $stmt->execute(array($obj->num_dde));
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
       $stmt =  $this->pdo->prepare("INSERT INTO prevoir_art (num_dde, code_article, qte_prevue, pu_ht) VALUES ( :num_dde, :code_article, :qte_prevue, :pu_ht) ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Retourne la quantité d'un article dans une intervention
     * @param object $interv objet Intervention
     * @param object $art objet Article
     * @return int $res quantité de l'article dans l'intervention
     */
    public function getQte(object $interv, object $art): int {
        $stmt = $this->pdo->prepare("SELECT qte_prevue FROM prevoir_art WHERE num_dde=? and code_article=?");
        $stmt->execute(array($interv->num_dde, $art->code_article));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['qte_prevue'];
    }
}

