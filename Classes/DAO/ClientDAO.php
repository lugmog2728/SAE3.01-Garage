<?php
/**
 * Classe ClientDAO
 */
class ClientDAO extends DAO{


    /**
     * Récupération d'un nouvel identifiant
     * @return int
     */
    public function getNewId(): int{
        $stmt = $this->pdo->query("SELECT max(code_client) FROM client");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }

/**
     *  Récupération d'un objet dont on donne l'identifiant
     * @param string|int|array $id Identifiant de l'objet
     */
    public function getOne(string|int|array $id): object{
        $stmt = $this->pdo->prepare("SELECT * FROM client WHERE code_client=?");
        $stmt->execute(array($id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Client($row);
    }
    /**
     * Récupération d'un objet dont on donne le nom et le prénom
     * @param string $nom Nom de l'objet
     * @param string $prenom Prénom de l'objet
     * @return object
     */
    public function getOneByName(string $nom, string $prenom): object{
        $stmt = $this->pdo->prepare("SELECT * FROM client WHERE nom=? AND prenom=?");
        $stmt->execute(array($nom, $prenom));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Client($row);
    }
    /**
     * Récupération de tous les objets
     */
    public function getAll(): array{
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM client ORDER BY code_client");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Client($row);
        return $res;
    }
    /**
     * Insertion d'un objet dans la base
     * @param object $object Objet à insérer
     */
    public function insert(object $obj): int{
        $stmt =  $this->pdo->prepare("INSERT INTO client (code_client, nom, prenom, adresse, codepostal, ville, tel, mail, date_creation) VALUES (:code_client, :nom, :prenom, :adresse, :codepostal, :ville, :tel, :mail, :date_creation) ");
        $res = $stmt->execute($obj->getFields());
        return $res;

    }
    /**
     * Mise à jour d'un objet dans la base
     * @param object $object Objet à mettre à jour
     */
    public function update(object $obj): int{
        $stmt = $this->pdo->prepare("UPDATE client SET  nom=:nom , prenom=:prenom, adresse=:adresse, codepostal=:codepostal, ville=:ville, tel=:tel, mail=:mail, date_creation=:date_creation WHERE  code_client=:code_client ");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }
    /**
     * Suppression d'un objet dans la base
     * @param object $object Objet à supprimer
     */
    public function delete(object $obj): int{
        $stmt = $this->pdo->prepare("DELETE FROM client WHERE code_client=?");
        $res = $stmt->execute(array($obj->code_client));
        return $res;
    }
}
