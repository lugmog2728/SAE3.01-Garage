<?php
/**
 * Classe Marque
 */
class Marque extends TableObject
{
    /**
     * Create option list for datalist
     */
    function getOption(){
        echo '<option value="'.$this->marque.'">'.$this->marque.'</option>';
    }
}