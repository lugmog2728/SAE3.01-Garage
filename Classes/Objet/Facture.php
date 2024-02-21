<?php
/**
 * Classe abstraite pour l'accès aux données d'une base
 */
class Facture extends TableObject {


    /**
     * Création d'une facture à partir de son numéro
     * @param int $numFacture numéro de la facture
     * @return Facture
     */
    static function nouvelle_facture(int $num_dde){
        $fDAO= new FacturesDAO(MaBD::getInstance());
        $f=
        array(
            "no_facture" => $fDAO->getID(),
            "date_facture" =>date("d-m-Y",time()),
            "taux_tva" => Parametres::getTVA(),
            "etat_facture" => "IMPAYER",
            "num_dde" => $num_dde,
            "net_a_payer" => 0
        );
        $facture = new Facture($f);
        $fDAO->insert($facture);
        return $facture;
    }

    /**
     * Retourne le prix net de la facture
     * @return int prix facture
     */
    public function tarifier() {
        $pdo = MaBD::getInstance();
        $stmt =  $pdo->prepare("SELECT rdvgarage.tarification(?)");
        $stmt->execute(array((int)$this->no_facture));
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['tarification'];
    }

    /**
     * Retourne les operations effectuées dans la facture
     */
    public function getOperations(){}

    /**
     * Retourne les articles utilisés dans la facture
     */
    public function getArticles(){}

    /**
     * Ajoute des articles à la facture
     */
    private function setArticles(){}

    /**
     * Ajoute des operations à la facture
     */
    private function setOperations(){} 
    
    /**
     * Ajoute une operation à la facture
     */
    public function addOperation(){}

    /**
     * Ajoute un article à la facture
     */
    public function addArticle(){}

    /**
     * Affiche une facture
     */
    public function printFacture(){
        $clientDAO = new ClientDAO(MaBD::getInstance());
        $interventionDAO = new InterventionDAO(MaBD::getInstance());
        $intervention = $interventionDAO->getOne($this->num_dde);
        $client = $clientDAO->getOne($intervention->code_client);
        
        echo "<tr scope='col' style='width:6%'>";

        echo "<td scope='col' style='width:6%' class='nowrapdata'>";
            echo $this->date_facture;
            echo "</td>";

        echo "<td scope='col' style='width:6%'>";
        echo $client->nom ." ". $client->prenom;
        echo "</td>";
        
        echo "<td scope='col' style='width:6%'>";
        echo $this->etat_facture;
        echo "</td>";

        echo "<td scope='col' style='width:6%'>";
        echo $this->net_a_payer."€";
        echo "</td>";

        echo "<td scope='col' style='width:6%' class='nowrapdata'>
        <input type='image' name='modif[]' onclick='location.replace(\"fiche_facture.php?id=$this->no_facture \")' src='../img/modif.png'>
        <input type='image' name='supp[]' onclick='supprimer(\"facture\", \"no_facture\",$this->no_facture)' src='../img/supp.png'> 
        <input type='image' name='voir[]' onclick='location.replace(\"afficher_devis.php?id_interv=$this->num_dde\")' src='../img/document.png' style='height:30px;width:30px'></td>";
        echo "</tr>";
    }
}


