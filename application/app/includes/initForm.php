<?php

    //Write city and country fields on the config.php file
function updateConfigFile($data){
    $configFilePath = __DIR__.'/config.php';
    if(!$f = fopen($configFilePath, 'w')){
        return false;
    }
    
    fwrite($f, '<?php $country=' . '\''.$data['country'] . '\''. ';$city=' . '\''. $data['city'] . '\';?>');
    fclose($f);
}

function initializeForm($data){
        $fields = array();
        
    //First Name field
    $firstNameFieldAttributes = array(
        'type' => 'text',
        'name' => 'first_name',
        'id' => 'first_name',
        'placeholder' => 'First Name'
    );
    //Fill field if previously selected
    if(!empty($data['first_name'])){
        
        $firstNameFieldAttributes['value'] = $data['first_name'];
        }

    $firstNameField = new InputFormField($firstNameFieldAttributes);


    //Last Name field
    $lastNameFieldAttributes = array(

        'type' => 'text',
        'name' => 'last_name',
        'id' => 'last_name',
        'placeholder' => 'Last Name'
    );
    //Fill field if previously selected
    if(!empty($data['last_name'])){
        $lastNameFieldAttributes['value'] = $data['last_name'];
        }

    $lastNameField = new InputFormField($lastNameFieldAttributes);


    //Age field 
    $ageFieldAttributes = array(

        'type' => 'text',
        'name' => 'age',
        'id' => 'age',
        'placeholder' => 'Age'
    );
    //Fill field if previously selected
    if(!empty($data['age'])){
        $ageFieldAttributes['value'] = $data['age'];
        }
    $ageField = new InputFormField($ageFieldAttributes);

    //City field
    $cityFieldAttributes = array(
        'name' => 'city',
        'id' => 'city'
        
    );
    //Fill field from config.php file if previously selected
    if(!empty($data['city'])){
        require_once 'config.php';
        if(isset($city)){
            $cityFieldAttributes['value'] = $city;
        }
    }
    $cityFieldValues = array(
        'Blagoevgrad',
        'Burgas',
        'Varna',
        'Veliko Tyrnovo',
        'Vidin',
        'Vraca',
        'Gabrovo',
        'Dobrich',
        'Kyrdjali',
        'Kiustendil',
        'Lovech',
        'Montana',
        'Pazardjik',
        'Pernik',
        'Pleven',
        'Plovdiv',
        'Razgrad',
        'Ruse',
        'Silistra',
        'Sliven',
        'Smolqn',
        'Other'
    );

    $cityFieldArray = array(
        'attributes' => $cityFieldAttributes,
        'values' => $cityFieldValues
    );

    $cityField = new SelectFormField($cityFieldArray);

    //Nationality field 
    $nationalityFieldAttributes = array(
        'bulgarian' => array('name' => 'nationality', 'id' => 'bulgarian'),
        'foreign' => array('name' => 'nationality', 'id' => 'foreign'),
        '' => array('name' => 'nationality', 'id' => 'blank', 'checked' => 'checked' , 'style' => 'display:none;')
    );
    //Check radio button if previously selected
    if($data['nationality']=='bulgarian'){
        $nationalityFieldAttributes['bulgarian']['checked']='checked';
    }
    else if($data['nationality']=='foreign'){
        $nationalityFieldAttributes['foreign']['checked']='checked';
    }

    $nationalityField = new RadioFormField($nationalityFieldAttributes);

    //Country field
    
    $countryFieldAttributes = array(
        'name' => 'country',
        'id' => 'country'
    );
    //Fill field from config.php file if previously selected
    if(!empty($data['country'])){
        require_once 'config.php';
        if(isset($country)){
            $countryFieldAttributes['value'] = $country;
        }
    }
    //Hide country field if bulgarian nationality is selected.
    if($data['nationality'] == 'bulgarian'){
            $countryFieldAttributes['style'] = 'display:none;';
            $countryFieldAttributes['value'] = '';
    }
        

    $countryFieldValues = array(
        'China',
        'India',
        'USA',
        'Brazil',
        'Nigeria',
        'Russia',
        'Mexico',
        'Japan',
        'Turkey',
        'Other',
        ''
    );
    $countryFieldArray = array(
        'attributes' => $countryFieldAttributes,
        'values' => $countryFieldValues
    );
    $countryField = new SelectFormField($countryFieldArray);


    //Comments field
    $commentsFieldAttributes = array(
        'name' => 'comments',
        'id' => 'comments',
        'placeholder' => 'Comments'
    );
    //Fill field if previously selected
    if(!empty($data['comments'])){
        $commentsFieldAttributes['value'] = $data['comments'];
    }

    $commentsField = new TextAreaFormField($commentsFieldAttributes);

    //Picture field
    $pictureFieldAttributes = array(
        'type' => 'file',
        'name' => 'picture',
        'id' => 'picture'
    );
    $pictureField = new InputFormField($pictureFieldAttributes);


    $fields = array($firstNameField, $lastNameField, $ageField, $cityField, $nationalityField, $countryField, $commentsField, $pictureField);
    //Form field attributes
    $formAttributes = array(
        'method' => 'POST',
        'action' => '/submit',
        'enctype' => 'multipart/form-data'


    );
    
    return new Form($fields,$formAttributes,$data);

    }
    ?>