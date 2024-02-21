<?php
/**
 * Classe Vehicule
 */
class Vehicule extends TableObject
{
    /**
     * Create option list for datalist
     */
    public function getOption(){
            echo '<option value="'.$this->no_immatriculation.'">'.$this->no_immatriculation.'</option>';
     }

    /**
     * Display the table of the object's fields structured in table rows
     */
    public function getTable()
    {
        // Récupération du nom et prénom du client à partir du code client
        $clientDAO = new ClientDAO(MaBD::getInstance());
        $client = $clientDAO->getOne($this->code_client);
        $nomPrenomClient = $client->nom . ' ' . $client->prenom;

        // Récupération de l'objet modele à partir du numéro de modele
        $modeleDAO = new ModeleDAO(MaBD::getInstance());
        $modele = $modeleDAO->getOne($this->num_modele);

        // Récupération de l'objet marque à partir du numéro de marque du modele
        $marqueDAO = new MarqueDAO(MaBD::getInstance());
        $marque = $marqueDAO->getOne($modele->num_marque);

        echo "<tr>";
        echo "<td>";
        echo $this->no_immatriculation;
        echo "</td>";
        echo "<td class='nowrapdata'>";
        echo $marque->marque;
        echo "</td>";
        echo "<td>";
        echo $modele->modele;
        echo "</td>";
        echo "<td>";
        echo $nomPrenomClient;
        echo "</td>";
        echo "<td class='nowrapdata'>
              <input type='image' name='voir[]' onclick='location.replace(\"afficher_vehicule.php?immat=$this->no_immatriculation\")' src='../img/eye.png' style='height:30px;width:30px'>
              <input type='image' name='modif[]' onclick='location.replace(\"./UI/UI_vehicule.php?id=$this->no_immatriculation \")' src='../img/modif.png'>
              <input type='image' name='supp[]' onclick='supprimer(\"vehicule\", \"no_immatriculation\",$this->no_immatriculation)' src='../img/supp.png'> </td>";
        echo "</tr>";
    }
}
