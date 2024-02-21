<?php
/**
 * Classe VehiculeDAO
 */
class VehiculeDAO extends DAO{


        
    /**
     *  Récupération d'un objet dont on donne l'identifiant
     * @param string|int|array $id Identifiant de l'objet
     */
    public function getOne(string|int|array $id): object{
    $stmt = $this->pdo->prepare("SELECT * FROM vehicule WHERE no_immatriculation=?");
    $stmt->execute(array($id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return new Vehicule($row);
    }
    /**
     * Récupération de tous les objets
     */
    public function getAll(): array{
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM vehicule ORDER BY no_immatriculation");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Vehicule($row);
        return $res;
    }

    /**
     * Insertion d'un objet dans la base
     * @param object $object Objet à insérer
     */
    public function insert(object $obj): int{
        $stmt =  $this->pdo->prepare("INSERT INTO vehicule(no_immatriculation, no_serie, date_mise_en_circulation, code_client, num_modele) 
        VALUES (:no_immatriculation, :no_serie, :date_mise_en_circulation, :code_client, :num_modele)");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }
        

    /**
     * Mise à jour d'un objet dans la base
     * @param object $object Objet à mettre à jour
     */
    public function update(object $obj): int{
        $stmt = $this->pdo->prepare("UPDATE vehicule SET no_immatriculation=:no_immatriculation, no_serie=:no_serie, date_mise_en_circulation=:date_mise_en_circulation, 
        code_client=:code_client, num_modele=:num_modele WHERE  no_immatriculation=:no_immatriculation");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }

    /**
     * Suppression d'un objet dans la base
     * @param object $object Objet à supprimer
     */
    public function delete(object $obj): int{
        $stmt = $this->pdo->prepare("DELETE FROM vehicule WHERE no_immatriculation=?");
        $res = $stmt->execute(array($obj->code_article));
        return $res;
    }
}
