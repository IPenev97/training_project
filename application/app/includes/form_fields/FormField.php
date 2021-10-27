<?php
 abstract class FormField
 {
    
    function __construct($fieldAttributes){
        $this->attributes = $fieldAttributes;
    }
    abstract function toHtml();
}

?>