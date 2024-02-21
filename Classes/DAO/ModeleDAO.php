<?php
/**
 * Classe pour l'accès à la table produit
 */
class ModeleDAO extends DAO {

    /**
     * Récupération des modeles dont on donne le nom de la marque
     * @param string|int|array $ref Nom de la marque
     * @return array $res liste des modeles
     */
    public function getByMarque($id){
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM modele WHERE num_marque = $id");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Modele($row);
        return $res;
    }
    /**
     * Récupération de la dernière modele
     * @return int $id identifiant de la dernière modele
     */
    public function getID(){
        $stmt = $this->pdo->query("SELECT max(num_modele) FROM modele");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }

    /**
     * Récupération d'une modele dont on donne l'identifiant
     * @param string|int|array $ref Identifiant de la modele
     * @return Modele
     */
    public function getOne(string|int|array $ref): Modele {
        $stmt = $this->pdo->prepare("SELECT * FROM modele WHERE num_modele=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Modele($row);
    }


    /**
     * Récupération de toutes les Tarifs
     * @return array $res liste des Tarifs
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM modele ORDER BY num_marque");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Modele($row);
        return $res;
    }

    /**
     * Insertion d'une modele dans la base
     * @param object $obj Modele à insérer
     * @return int $res succès de l'insertion
     */
    public function insert(object $obj): int {
       $stmt =  $this->pdo->prepare("INSERT INTO modele (num_marque, num_modele, modele) VALUES (:num_marque, :num_modele, :modele) ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Mise à jour d'une modele dans la base
     * @param object $obj Modele à mettre à jour
     * @return int $res succès de la mise à jour
     */
    public function update(object $obj): int {
       $stmt = $this->pdo->prepare("UPDATE modele SET modele=:modele, num_marque=:num_marque WHERE  num_modele=:num_modele ");
       $res = $stmt->execute($obj->getFields());
       return $res;
    }

    /**
     * Suppression d'une modele dans la base
     * @param object $obj Modele à supprimer
     * @return int $res succès de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM modele WHERE num_modele=?");
        $res = $stmt->execute(array($obj->num_modele));
        return $res;
    }

}