<?php
/**
 * Classe InterventionDAO
 */
class InterventionDAO extends DAO {


    /**
     * Récupération d'un nouvel identifiant
     * @return int
     */
    public function getNewId(): int{
        $stmt = $this->pdo->query("SELECT max(num_dde) FROM dde_intervention");
        $id = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
        return $id+1;
    }

    /**
     * Récupération d'une Intervention dont on donne l'identifiant
     * @param string|int|array $ref identifiant du produit
     * @return Intervention $intervention objet Intervention
     */
    public function getOne(string|int|array $ref): Intervention {
        $stmt = $this->pdo->prepare("SELECT * FROM dde_intervention WHERE num_dde=?");
        $stmt->execute(array($ref));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Intervention($row);
    }

    /**
     * Récupération d'une Intervention dont on donne le code client, la date et l'heure
     * @param int $codeClient code du client
     * @param string $date date de l'intervention
     * @param string $heure heure de l'intervention
     * @return Intervention $intervention objet Intervention
     */
    public function getOneByCodeClientDateHeure(int $codeClient, string $date, string $heure): Intervention {
        $stmt = $this->pdo->prepare("SELECT * FROM dde_intervention WHERE code_client=? and date_rdv=? and heure_rdv=?");
        $stmt->execute(array($codeClient, $date, $heure));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Intervention($row);
    }


    /**
     * Récupération de la liste des interventions
     * @return array $res liste des interventions
     */
    public function getAll(): array {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM dde_intervention ORDER BY num_dde");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Intervention($row);
        return $res;
    }

    /**
     * Ajout d'une intervention
     * @param object $obj objet Intervention
     * @return int $res résultat de l'ajout
     */
    public function insert(object $obj): int {
       $stmt =  $this->pdo->prepare("INSERT INTO dde_intervention (num_dde, date_rdv, heure_rdv, descriptif_demande, km_actuel, devis_on, etat_demande, code_client, no_immatriculation, id_operateur) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
       $res = $stmt->execute(array($obj->num_dde, $obj->date_rdv, $obj->heure_rdv, $obj->descriptif_demande,Null, ($obj->devis_on) ? "True" : "False" , $obj->etat_demande, $obj->code_client, Null, Null));
       return $res;
    }

    /**
     * Mise à jour d'une intervention
     * @param object $obj objet Intervention
     * @return int $res résultat de la mise à jour
     */
    public function update(object $obj): int {
       $stmt = $this->pdo->prepare("UPDATE dde_intervention SET num_dde=:num_dde,
                                                                date_rdv=:date_rdv,
                                                                heure_rdv=:heure_rdv, 
                                                                descriptif_demande=:descriptif_demande,
                                                                km_actuel=:km_actuel,
                                                                devis_on=:devis_on,
                                                                etat_demande=:etat_demande,
                                                                code_client=:code_client,
                                                                no_immatriculation=:no_immatriculation,
                                                                id_operateur=:id_operateur
                                                                WHERE num_dde=:num_dde");
       // Cette ligne est nécessaire car en php Vrai = TRUE en sql Vrai = true. Et il ne sont pas content sinon.   
       $obj->devis_on = ($obj->devis_on)? "true":"false" ; 
       $res = $stmt->execute($obj->getFields());
        
       return $res;
    }

    /**
     * Annulation d'une intervention
     * @param int $num_dde identifiant de l'intervention
     * @return int $res résultat de l'annulation
     */
    public function annuler(int $num_dde): int {
        $stmt = $this->pdo->prepare("UPDATE dde_intervention SET etat_demande='ANNULE' WHERE num_dde=?");                                                        
        $res = $stmt->execute(array($num_dde));        
        return $res;
     }

    /**
     * Suppression d'une intervention
     * @param object $obj object Intervention
     * @return int $res résultat de la suppression
     */
    public function delete(object $obj): int {
        $stmt = $this->pdo->prepare("DELETE FROM dde_intervention WHERE num_dde=?");
        $res = $stmt->execute(array($obj->num_dde));
        return $res;
    }

    /**
     * Récupération de la liste des interventions entre deux dates
     * @param string $start date de début
     * @param string $end date de fin
     * @return array $res liste des interventions
     */
    public function getAllBetween($start, $end){
        $stmt = $this->pdo->prepare("Select * from dde_intervention where dde_intervention.date_rdv Between ? and ?");
        $stmt->execute(array($start,$end));
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Intervention($row);
        return $res;
    }

    /**
     * Récupération de la liste des interventions du jour
     * @return array $res liste des interventions
     */
    public function getToday(){
        $stmt = $this->pdo->query("Select * from today");
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Intervention($row);
        if (!isset($res))
            return [];
        return $res;
    }

    /**
     * Vérifie si le vehicule est renseigné dans l'intervention
     * @param int $num_dde identifiant de l'intervention
     * @return string $row["no_immatriculation"] immatriculation de l'intervention ou null
     */
    public function checkImat(int $num_dde){
        $stmt = $this->pdo->prepare("select no_immatriculation FROM dde_intervention WHERE num_dde=?");
        $row = $stmt->execute(array($num_dde));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row["no_immatriculation"] ==null){
            return null;
        }else{
            return $row["no_immatriculation"];
        }
    }

    /**
     * Vériifie si l'opérateur est renseigné dans l'intervention
     * @param int $num_dde identifiant de l'intervention
     * @return string $row["id_operateur"] identifiant de l'opérateur ou null
     */
    public function checkOperateur(int $num_dde){
        $stmt = $this->pdo->prepare("select id_operateur FROM dde_intervention WHERE num_dde=?");
        $row = $stmt->execute(array($num_dde));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row["id_operateur"] == null){
            return null;
        }else{
            return $row["id_operateur"];
        }
    }


}

