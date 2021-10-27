<?php
class SelectFormField extends FormField{

    
    
    public function toHtml(){

    
        $output = '<select ';
        //Get field value if previously selected
        $selected = $this->attributes['attributes']['value'];


        if(isset($this->attributes)){
        //Add each field attribute from assoc array
        foreach ($this->attributes['attributes'] as $key => $value){
            $output .= $key.'="'.$value.'" ';
        }
        $output .= '>';
        //Add each select option from array
        foreach ($this->attributes['values'] as $value){
            $output .= '<option value="'.$value.'"';
            //Add selected attribute if there is a selected option
            if($selected==$value){
                $output .= 'selected';
            }
            $output.='>'.$value.'</option>';
        }
    }

    
        $output .= '</select>';
        return $output;
    }
}
?>