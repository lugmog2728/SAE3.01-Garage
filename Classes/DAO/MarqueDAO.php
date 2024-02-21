<?php
/**
 * Classe pour l'accès à la table produit
 */
class MarqueDAO extends DAO {

    /**
     * Récupération de la dernière marque
     * @return int $id identifiant de la dernière marque
     */
    public function getID(){
        $stmt = $this->pdo->query("SELECT max(num_marque) FROM marque");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }

    /**
     * Récupération d'une marque dont on donne l'identifiant
     * @param string|int|array $ref Identifiant de la marque
     * @return Marque
     */
    public function getOne(string|int|array $id): object {
        $stmt = $this->pdo->prepare("SELECT * FROM marque WHERE num_marque=?");
        $stmt->execute(array($id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Marque($row);
    }

    /**
     * Récupération d'une marque dont on donne le nom
     * @param string|int|array $ref Nom de la marque
     * @return Marque
     */
    public function getOneByName(string|int|array $ref): ?Marque
    {
        $stmt = $this->pdo->prepare("SELECT * FROM marque WHERE marque=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row== false){
            return NULL;
        }
        return new Marque($row);
    }

    /**
     * Récupération de toutes les Tarifs
     * @return array $res liste des Tarifs
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM marque ORDER BY num_marque");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Marque($row);
        return $res;
    }

    /**
     * Insertion d'une marque dans la base
     * @param object $obj Marque à insérer
     * @return int $res succès de l'insertion
     */
    public function insert(object $obj): int {
       $stmt =  $this->pdo->prepare("INSERT INTO marque (num_marque, marque) VALUES (:num_marque, :marque) ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Mise à jour d'une marque dans la base
     * @param object $obj Marque à mettre à jour
     * @return int $res succès de la mise à jour
     */
    public function update(object $obj): int {
       $stmt = $this->pdo->prepare("UPDATE marque SET marque=:marque WHERE  num_marque=:num_marque ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Suppression d'une marque dans la base
     * @param object $obj Marque à supprimer
     * @return int $res succès de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM marque WHERE num_marque=?");
        $res = $stmt->execute(array($obj->num_marque));
        return $res;
    }

}