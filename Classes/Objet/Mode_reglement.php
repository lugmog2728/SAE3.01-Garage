<?php
/**
 * Classe Mode_reglement
 */
class Mode_reglement extends TableObject {
    /**
     * Display the table of the object's fields structured in table rows
     */
    public function getTable(){
        echo "<tr>";
              echo "<td>";
              echo $this->no_mode_regl;
              echo "</td>";
          echo "<td class='nowrapdata'>";
        echo $this->libelle_mode_regl;
              echo "</td>";
          echo "<td class='nowrapdata'>
          <input type='image' name='modif[]' onclick='location.replace(\"./UI/UI_modeReglement.php?id=$this->no_mode_regl \")' src='../img/modif.png'>
          <input type='image' name='supp[]' onclick='supprimer(\"mode_reglement\", \"no_mode_regl\",$this->no_mode_regl)' src='../img/supp.png'> </td>";
          echo "</tr>"; 
      } 
  
      /**
       * Create option list for datalist
       */
      public function getOption(){
        echo '<option value="'.$this->libelle_mode_regl.'">'.$this->libelle_mode_regl.'</option>';
 }
}