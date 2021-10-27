<?php

class RadioFormField extends FormField{
    
    public function toHtml(){
        
        $output;
        //Add each radio option as an input field
        foreach($this->attributes as $optionValue => $attributes){
            $output .= '<input type="radio" value="'.$optionValue.'" ';
            //Add each field attribute to each radio option field from assoc array
            foreach ($attributes as $key => $value) {
                $output.= $key.'="'.$value.'" ';
            }
            //Add lable to each radio option
            $output .= '><lable for="'.$optionValue.'">'.$optionValue.'</lable>';
            


            
        }
        return $output;
    }
}

?>