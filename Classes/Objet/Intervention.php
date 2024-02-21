<?php
/**
 * Classe pour l'accès à la table Intervention
 */
class Intervention extends TableObject {

    /**
     * Appel la procédure stockée pour récupérer le prix net de l'intervention
     * @return int $res prix net de la facture
     */
    public function tarifier(): int{$pdo = MaBD::getInstance();
        $stmt = $pdo->prepare("SELECT devis(?)");
        $stmt->execute(array($this->num_dde));
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) explode($res," ")[0];}

    /**
     * Mise à jour de l'état de l'intervention à Annulée
     */
    public function cancel(){
        $pdo = MaBD::getInstance();
        $this->etat_demande="ANNULE";
        $dao = new InterventionDAO($pdo);
        $dao->update($this);
    }

    /**
     * Mise à jour de l'état de l'intervention à Terminée
     */
    public function clore(){
        $pdo = MaBD::getInstance();
        $this->etat_demande="TERMINE";
        $dao = new FacturesDAO($pdo);
        $dao->update($this);
    }

    /**
     * Récupération de la liste des interventions
     */
    public function getOperation(){
        return $this->fields['operations'];
    }


    /**
     * Récupération de la liste des articles
     */
    public function getArticle(){
        return $this->fields['articles'];
    }

    public function getOperateur(){
        return $this->fields['id_operateur'];
    }

    /**
     * Ajout d'un article à l'intervention
     * @return array $prev_art liste des articles de l'intervention
     */
    private function setArticle(){
        $pdo = MaBD::getInstance();
        $prev_art = new PrevoirArticlesDAO($pdo);
        $temp = $prev_art->getAllIntervention($this);
        return $temp;
    }

    /**
     * Ajout d'une opération à l'intervention
     * @return array $prev_art liste des opérations de l'intervention
     */
    private function setOperation(){
        $pdo = MaBD::getInstance();
        $prev_op = new PrevoirOperationsDAO($pdo);
        return $prev_op->getAllIntervention($this);
    } 
    /**
     * Ajoute une opération
     * @param Operation $op opération à ajouter
     */
    public function addOperation(){}
    /**
     * Ajouter un Article 
     * @param Article $art article à ajouter
     */
    public function addArticle(){}

    public function deleteIntervention(){
        $pdo = MaBD::getInstance();
        $stmt = $pdo->prepare("Call get(?)");
        $stmt->execute(array($this->num_dde));
    }

    public function annulerIntervention(){
        $this->etat_demande="ANNULER";
    }

    public function getTable(){
      echo "<tr>";
            echo "<td>";
            echo $this->num_dde;
            echo "</td>";
        echo "<td class='nowrapdata'>";
            echo $this->date_rdv;
            echo "</td>";
        echo "<td>";
        echo $this->heure_rdv;
        echo "</td>";
        
        echo "<td>";
        echo $this->code_client;
        echo "</td>";
        echo "<td>";
        try{
        echo $this->id_operateur;
        }catch(Exception $e){
            echo "None";
        }
        echo "</td>";
        echo "<td>";
        try{
        echo $this->descriptif_demande;
        }catch(Exception $e){
            echo "None";
        }   
        echo "</td>";
        echo "<td>";
        echo $this->etat_demande;
        echo "</td>";
        echo "<td class='nowrapdata'>
        <input type='image' name='voir[]' onclick='location.replace(\"ordre_intervention.php?id_interv=$this->num_dde\")' src='../img/eye.png' style='height:30px;width:30px'>
        <input type='image' name='modif[]' onclick='location.replace(\"completer_RDV.php?id=$this->num_dde \")' src='../img/modif.png'>
        <input type='image' name='supp[]' onclick='supprimer(this,$this->num_dde)' src='../img/supp.png'> </td>";
        echo "<td>";
        echo "<input type='image' name='voir[]' onclick='location.replace(\"afficher_devis.php?id_interv=$this->num_dde\")' src='../img/document.png' style='height:30px;width:30px'>";
        echo "</td>";
        echo "</tr>"; 
    }
}

