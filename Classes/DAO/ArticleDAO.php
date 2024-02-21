<?php
/**
 * Classe ArticleDAO
 */
class ArticleDAO extends DAO {

    /**
     * Récupération d'un nouvel identifiant
     * @return int
     */
    public function getNewId(): int{
        $stmt = $this->pdo->query("SELECT max(code_article) FROM article");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }
    /**
     *  Récupération d'un objet dont on donne l'identifiant
     * @param string|int|array $id Identifiant de l'objet
     */
    public function getOne(string|int|array $id): object{
        $stmt = $this->pdo->prepare("SELECT * FROM article WHERE code_article=?");
        $stmt->execute(array($id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Article($row);
    }

    /**
     * Récupération d'un Article à partir de son libellé
     * @param string $libelle Libellé de l'article
     * @return Article
     */
    public function getOneFromLibelle(string $libelle): Article {
        $stmt = $this->pdo->prepare("SELECT * FROM article WHERE libelle_article=?");
        $stmt->execute(array($libelle));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Article($row);
    }

    /**
     * Récupération de tous les objets
     */
    public function getAll(): array{
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM article ORDER BY code_article");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Article($row);
        return $res;
    }
    /**
     * Insertion d'un objet dans la base
     * @param object $object Objet à insérer
     */
    public function insert(object $obj): int{
        $stmt =  $this->pdo->prepare("INSERT INTO article (code_article, type_article, prix_unit_actuel_ht, libelle_article) VALUES (:code_article, :type_article, :prix_unit_actuel_ht, :libelle_article) ");
        $res = $stmt->execute($obj->getFields());
        return $res;

    }
    /**
     * Mise à jour d'un objet dans la base
     * @param object $object Objet à mettre à jour
     */
    public function update(object $obj): int{
        $stmt = $this->pdo->prepare("UPDATE article SET type_article=:type_article, 
                                                        prix_unit_actuel_ht=:prix_unit_actuel_ht,
                                                        libelle_article=:libelle_article WHERE  code_article=:code_article ");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }
    /**
     * Suppression d'un objet dans la base
     * @param object $object Objet à supprimer
     */
    public function delete(object $obj): int{
        $stmt = $this->pdo->prepare("DELETE FROM article WHERE code_article=?");
        $res = $stmt->execute(array($obj->code_article));
        return $res;
    }
}
