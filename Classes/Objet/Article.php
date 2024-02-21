<?php
/**
 * Classe Article
 */
class Article extends TableObject
{
    /**
     * Display the table of the object's fields structured in table rows
     */
    public function getTable()
    {
        echo "<tr>";
        echo "<td>";
        echo $this->code_article;
        echo "</td>";
        echo "<td class='nowrapdata'>";
        echo $this->type_article;
        echo "</td>";
        echo "<td>";
        echo $this->libelle_article;
        echo "</td>";
        echo "<td>";
        echo $this->prix_unit_actuel_ht;
        echo "</td>";

        echo "<td class='nowrapdata'>
          <input type='image' name='modif[]' onclick='location.replace(\"./UI/UI_article.php?id=$this->code_article \")' src='../img/modif.png'>
          <input type='image' name='supp[]' onclick='supprimer(\"article\", \"code_article\", $this->code_article)' src='../img/supp.png'> </td>";
        echo "</tr>";
    }

    function getOption()
    {
        echo '<option value="' . $this->libelle_article . '">' . $this->libelle_article . '</option>';
    }
}
