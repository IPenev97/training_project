<?php

class Form {
    private $values = array();
    private $errors = array();
    private $fields = array();
    private $attributes = array();
    private $imgData = array();
    const ALLOWED_IMG_TYPES = array("jpeg","png","jpg");
    const MAX_IMG_SIZE = 200000;
    const IMG_UPLOAD_PATH = __DIR__.'/../img/';
    const FORM_DATA_UPLOAD_PATH = __DIR__.'/../form_submissions/';
    const MANDATORY_FIELDS = array('first_name', 'last_name', 'city', 'nationality');
    

    function __construct($fields, $attributes, $data){
        $this->fields = $fields;
        $this->attributes = $attributes;
        $this->imgData = $data['picture'];
        $this->imgData['img_file_type'] = strtolower(pathinfo($this->imgData['name'], PATHINFO_EXTENSION));
        unset($data['picture']);
        $this->values = $data;
    }
    //Check for empty required fields
    private function validateEmpty(){
        foreach($this->values as $key => $value){
            if(in_array($key,self::MANDATORY_FIELDS) && empty($value)){
                
                $this->errors[$key] = str_replace('_',' ',ucfirst($key)).' field is empty!';
            }
        }
        if($this->values['nationality'] == 'foreign'){
            if(empty($this->values['country'])){
                $this->errors['country'] = 'Country field is empty!';
            }
        }
        
    }
    //Validate image
    private function validateImage(){
        if(!is_uploaded_file($this->imgData ['tmp_name'])){
            $this->errors['picture_error']='Select a picture!';
        }
        else{
            $img_size = $this->imgData['size'];
            $img_name = $this->imgData['name'];
            $img_tmp_name = $this->imgData['tmp_name'];
            $img_error = $this->imgData['error'];
            $img_file_type = $this->imgData['img_file_type'];
                
                if($img_error==0){
                    if($img_size>self::MAX_IMG_SIZE){
                        $this->errors['picture_error']='Picture file must be below 200Kb!';
                    }
                    else{
                        
                        if(!in_array($img_file_type,self::ALLOWED_IMG_TYPES)){
                            $this->errors['picture_error']='Picture file type not supported!';
                        }
                        else {
                            unset($this->errors['picture_error']);
                           
    
                        }
                    }
                }
                else {
                    $this->errors['picture_error'] = $img_error;
                }
        }

    }
    //Validate all fields
    private function validate(){
        $this->validateEmpty();
        $this->validateImage();
        foreach($this->errors as $error){
            if(!empty($error)){
                return false;
            }
        }
        return true;
    }

    
    //Save image file
    private function saveImage(){
        $img_new_name = 'IMG-'.date("Y-m-d H:i:s").'.'.$this->imgData['img_file_type'];
        if(!move_uploaded_file($this->imgData['tmp_name'],self::IMG_UPLOAD_PATH.$img_new_name)){
            echo "Error has occured while saving file!";
            return false;
        }
        return true;

    }
    //Save form file
    private function saveFormData(){

        $json_array_data = json_encode($this->values);
        $filename = date("Y-m-d H:i:s").'_form_submition.json';

        if(!file_put_contents(self::FORM_DATA_UPLOAD_PATH.$filename, $json_array_data)){
            echo 'Error has occured while saving form data file!';
            return false;
        }
        return true;
        

    }


    
    function processData(){
        
        if(!$this->validate()){
            return false;
        }
        if(!$this->saveImage()){
            return false;
        }
        if(!$this->saveFormData()){
            return false;
        }
        return true;
        
    }


    


    

    
    
    function toHtml(){
        $output = '<form ';
        
        foreach($this->attributes as $key => $value){
            $output .= $key.'="'.$value.'"';
        }
        $output.='>';
        foreach($this->fields as $field){
            $output.=$field->toHtml();
            $output.='<br><br>';
        }
        foreach($this->errors as $error){
            $output.= '<span class="error">'.$error.'</span><br>';
        }
        $output.='<button type="submit" name="form_submit">Submit</button></form>';
        

        return $output;

    }
}
?> 