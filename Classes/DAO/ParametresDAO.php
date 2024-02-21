<?php

class ParametresDAO extends DAO{

/**
     *  Récupération d'un objet dont on donne l'identifiant
     * @param string|int|array $id Identifiant de l'objet
     */
    public function getOne(string|int|array $id): object{
        $stmt = $this->pdo->prepare("SELECT * FROM parametres WHERE id=?");
        $stmt->execute(array($id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Parametres($row);
    }

    /**
     * Récupération de tous les objets
     * @return array d'objet Parametres
     */
    public function getAll(): array{
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM parametres ORDER BY id");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Parametres($row);
        return $res;
    }
    /**
     * Insertion d'un objet dans la base
     * @param object $object Objet à insérer
     * @return int
     */
    public function insert(object $obj): int{
        $stmt =  $this->pdo->prepare("INSERT INTO parametres (id, taux_tva_actuel) VALUES (:id, :taux_tva_actuel)");
        $res = $stmt->execute($obj->getFields());
        return $res;

    }
    /**
     * Mise à jour d'un objet dans la base
     * @param object $object Objet à mettre à jour
     * @return int
     */
    public function update(object $obj): int{
        $stmt = $this->pdo->prepare("UPDATE parametres SET  id=:id , taux_tva_actuel=:taux_tva_actuel WHERE id=:id");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }
    /**
     * Suppression d'un objet dans la base
     * @param object $object Objet à supprimer
     * @return int
     */
    public function delete(object $obj): int{
        $stmt = $this->pdo->prepare("DELETE FROM parametre WHERE id=?");
        $res = $stmt->execute(array($obj->id));
        return $res;
    }
}
