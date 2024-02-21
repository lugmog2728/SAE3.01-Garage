<?php
/**
 * Classe Client
 */
class Client extends TableObject
{
    /**
     * Create option list for datalist
     */
    function getOption(){
        echo '<option value="'.$this->nom." ".$this->prenom.'">'.$this->nom." ".$this->prenom.'</option>';
    }

    /**
     * Display the table of the object's fields structured in table rows
     */
    public function getTable()
    {
        echo "<tr>";
        echo "<td>";
        echo $this->code_client;
        echo "</td>";
        echo "<td class='nowrapdata'>";
        echo $this->nom;
        echo "</td>";
        echo "<td>";
        echo $this->prenom;
        echo "</td>";

        echo "<td>";
        echo $this->tel;
        echo "</td>";
        echo "<td>";
        try {
            echo $this->mail;
        } catch (Exception $e) {
            echo "None";
        }
        echo "</td>";
        echo "<td class='nowrapdata'>
          <input type='image' name='voir[]' onclick='location.replace(\"afficher_client.php?id=$this->code_client\")' src='../img/eye.png' style='height:30px;width:30px'>
          <input type='image' name='modif[]' onclick='location.replace(\"./UI/UI_client.php?id=$this->code_client \")' src='../img/modif.png'>
          <input type='image' name='supp[]' onclick='supprimer(\"client\", \"code_client\",$this->code_client)' src='../img/supp.png'> </td>";
        echo "</tr>";
    }

    /**
     * Display client Full Name
     * @return string Full Name
     */
    public function getFullName()
    {
        return $this->nom . " " . $this->prenom;
    }
}
