<?php

class InputFormField extends FormField{
    public function toHtml(){
        $output = '<input ';
        //Add each field attribute from assoc array
        foreach($this->attributes as $key => $value){
            $output .= $key.'="'.$value.'" ';
        }
        $output .= '/>';
        return $output;
    }
}

?>