<?php
/**
 * Classe Operateur
 */
class Operateur extends TableObject {
    /**
     * Display option list for datalist
     */
    function getOption(){
        echo '<option value="'.$this->nom." ".$this->prenom.'">'.$this->nom." ".$this->prenom.'</option>';
    }
    
    /**
     * Display the table of the object's fields structured in table rows
     */
    public function getTable(){
        echo "<tr>";
              echo "<td>";
              echo $this->id_operateur;
              echo "</td>";
          echo "<td class='nowrapdata'>";
              echo $this->nom;
              echo "</td>";
          echo "<td>";
          echo $this->prenom;
          echo "</td>";
          echo "<td class='nowrapdata'>
          <input type='image' name='modif[]' onclick='location.replace(\"./UI/UI_operateur.php?id=$this->id_operateur \")' src='../img/modif.png'>
          <input type='image' name='supp[]' onclick='supprimer(\"operateur\", \"id_operateur\",$this->id_operateur)' src='../img/supp.png'> </td>";
          echo "</tr>"; 
    }
    
    /**
     * Display operator Full Name
     * @return string Full Name
     */
    public function getFullName(){
        return $this->nom." ".$this->prenom;
    }
  

}


