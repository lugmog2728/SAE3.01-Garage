<?php
/**
 * Classe OperateurDAO
 */
class OperateurDAO extends DAO {

    /**
     * Récupération d'un nouvel identifiant
     * @return int
     */
    public function getNewId(): int{
        $stmt = $this->pdo->query("SELECT max(id_operateur) FROM operateur");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }
    /**
     *  Récupération d'un objet dont on donne l'identifiant
     * @param string|int|array $id Identifiant de l'objet
     */
    public function getOne(string|int|array $id): object{
        $stmt = $this->pdo->prepare("SELECT * FROM operateur WHERE id_operateur=?");
        $stmt->execute(array($id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Operateur($row);
    }
    /**
     * Récupération de tous les objets
     */
    public function getAll(): array{
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM operateur ORDER BY id_operateur");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Operateur($row);
        return $res;
    }
    /**
     * Insertion d'un objet dans la base
     * @param object $object Objet à insérer
     */
    public function insert(object $obj): int{
        $stmt =  $this->pdo->prepare("INSERT INTO operateur (id_operateur, nom, prenom) VALUES (:id_operateur, :nom, :prenom) ");
        $res = $stmt->execute($obj->getFields());
        return $res;

    }
    /**
     * Mise à jour d'un objet dans la base
     * @param object $object Objet à mettre à jour
     */
    public function update(object $obj): int{
        $stmt = $this->pdo->prepare("UPDATE operateur SET nom=:nom, prenom=:prenom WHERE id_operateur=:id_operateur ");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }
    /**
     * Suppression d'un objet dans la base
     * @param object $object Objet à supprimer
     */
    public function delete(object $obj): int{
        $stmt = $this->pdo->prepare("DELETE FROM operateur WHERE id_operateur=?");
        $res = $stmt->execute(array($obj->id_operateur));
        return $res;
    }
}
