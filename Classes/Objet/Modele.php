<?php
/**
 * Classe Modele
 */
class Modele extends TableObject
{

    /**
     * Display object's fields structured in table rows
     */
    public function getTable()
    {
        // Récupération de l'objet marque à partir du numéro de marque
        $marqueDAO = new MarqueDAO(MaBD::getInstance());
        $marque = $marqueDAO->getOne($this->num_marque);

        echo "<tr>";
        echo "<td>";
        echo $this->num_modele;
        echo "</td>";
        echo "<td class='nowrapdata'>";
        echo $marque->marque;
        echo "</td>";
        echo "<td>";
        echo $this->modele;
        echo "</td>";
        echo "<td class='nowrapdata'>
      <input type='image' name='modif[]' onclick='location.replace(\"../Structure/UI/UI_modele.php?id=$this->num_modele \")' src='../img/modif.png'>
      <input type='image' name='supp[]' onclick='supprimer(\"modele\", \"num_modele\",$this->num_modele)' src='../img/supp.png'> </td>";
        echo "</tr>";
    }
}