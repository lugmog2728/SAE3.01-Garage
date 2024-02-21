<?php
/**
 * Classe Operation
 */
class Operation extends TableObject {
    /**
     * Display option list for datalist
     */
    function getOption(){
        echo '<option value="'.$this->libelle_op.'">'.$this->libelle_op.'</option>';
    }

    /**
     * Display the table of the object's fields structured in table rows
     */
    public function getTable(){
        $tarifDAO= new TarifDAO(MaBD::getInstance());
        $tarif = $tarifDAO->getOne($this->code_tarif);
        $tarif = $tarif->cout_horaire_actuel_ht;

        echo "<tr>";
              echo "<td>";
              echo $this->code_op;
              echo "</td>";
          echo "<td class='nowrapdata'>";
              echo $this->libelle_op;
              echo "</td>";
          echo "<td>";
          echo $this->duree_op;
          echo "</td>";
          echo "<td>";
          echo $tarif;
          echo "</td>";
          echo "<td class='nowrapdata'>
          <input type='image' name='modif[]' onclick='location.replace(\"./UI/UI_operation.php?id=$this->code_op \")' src='../img/modif.png'>
          <input type='image' name='supp[]' onclick='supprimer(\"operation\", \"code_op\",$this->code_op)' src='../img/supp.png'> </td>";
          echo "</tr>"; 
      } 
  

}


