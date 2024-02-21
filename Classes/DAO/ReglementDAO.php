<?php
/**
 * Classe ReglementDAO
 */
class ReglementDAO 
{
    /**
     * Instance de PDO
     * @var PDO
     */
    const UNKNOWN_ID = -1; // Identifiant non déterminé

    /**
     * Instance de PDO
     */
    protected $pdo; // Objet pdo pour l'accès à la table

    /**
     * Constructeur
     * @param PDO $pdo Instance de PDO
     */
    public function __construct(PDO $connector) { $this->pdo = $connector; }


    /**
     * Récupération du dernier réglement
     * @return int $id identifiant du dernier règlement
     */
    public function getID(){
        $stmt = $this->pdo->query("SELECT max(no_reglement) FROM reglement");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        echo $id;
        return $id+1;
    }

    /**
     * Récupération d'un objet dont on donne l'identifiant
     * @param string|int|array $ref Identifiant de l'objet
     * @return Reglement
     */
    public function getOne(string|int|array $id): object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM reglement WHERE no_reglement=?");
        $stmt->execute(array($id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Reglement($row);
    }

    /**
     * Récupération de tous les objets
     * @return array $res liste des objets Reglement
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM reglement WHERE no_reglement=?");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $res[] = new Reglement($row);
            
        }
        return $res;
    }

    /**
     * Récupération de tous les objets en fonction d'une facture
     * @param int $id identifiant de la facture
     * @return array $res liste des objets Reglement
     */
    public function getAllFacture($id)
    {
        $res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM reglement WHERE no_facture=?");
        $stmt->execute(array($id));
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $res[] = new Reglement($row);
        }
        return $res;
    }

    /**
     * Insertion d'un objet dans la base
     * @param object $object Objet à insérer
     * @return int $res nombre de lignes affectées
     */
    public function insert(object $obj): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO reglement (no_reglement, date_reglement, montant_reglement, no_mode_regl, no_facture)
                                         VALUES (:no_reglement, :date_reglement, :montant_reglement, :no_mode_regl, :no_facture)");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }

    /**
     * Mise à jour d'un objet dans la base
     * @param object $object Objet à mettre à jour
     * @return int $res nombre de lignes affectées
     */
    public function update(object $obj): int
    {
        $stmt = $this->pdo->prepare("UPDATE reglement SET date_reglement=:date_reglement, montant_reglement=:montant_reglement, no_mode_regl=:no_mode_regl, no_facture=:no_facture
        where no_reglement=:no_reglement");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }

    /**
     * Suppression d'un objet dans la base
     * @param object $object Objet à supprimer
     * @return int $res nombre de lignes affectées
     */
    public function delete(object $obj): int
    {
        $stmt =  $this->pdo->prepare("DELETE * FROM reglement where no_reglement=:no_reglement");
        $res = $stmt->execute($obj->getFields());
        return $res;
    }
}
