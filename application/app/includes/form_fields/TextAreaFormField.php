<?php
    class TextAreaFormField extends FormField {
        public function toHtml(){
            //Get field value if previously selected
            $value = $this->attributes['value'];
            $output = '<textarea ';
            //Add each field attribute from assoc array
            foreach($this->attributes as $key => $value){
                $output .= $key.'="'.$value.'" ';
            }
            $output .= '>'.$value.'</textarea>';
            return $output;
        }

    }
?>