<?php 
require_once 'Database.php';
$db = new Database();


// Get all file names
$url = "https://app.testcases.tk/data/all";
$result = file_get_contents($url);

$data = json_decode($result,true);





// Iterate through the file names and make a GET request for each JSON and IMG file individualy with cURL 

foreach($data as $data_array){

    $imgFileName = $data_array[0];
    $formFileName = $data_array[1];
    
    
// Get JSON file with cURL request

$url = "https://app.testcases.tk/data/get?name=".$formFileName;

$url = str_replace(' ', '%20', $url);


$result = getCurl($url);


// Initialize data

$firstName = $result->first_name;
$lastName = $result->last_name;
$age = $result->age;
$city = $result->city;
$nationality = $result->nationality;
$country = $result->country;
$comments = $result->comments;



// Query prepared statement
$sql = 'INSERT INTO form_submissions (first_name, last_name, age, city, nationality, country, comments)
        VALUES (:first_name, :last_name, :age, :city, :nationality, :country, :comments)';
$db->query($sql);

// Bind parameters
$db->bind(':first_name', $firstName);
$db->bind(':last_name', $lastName);
$db->bind(':age', $age);
$db->bind(':city', $city);
$db->bind(':nationality', $nationality);
$db->bind(':country', $country);
$db->bind(':comments', $comments);


//Try to execute query
if(!$db->execute()){
    echo 'API : Failed to save data to the database <br>';
}
else{
    echo 'API : Form data saved succesfully <br>';
}


//Get img data with GET request via cURL

$url = "https://app.testcases.tk/data/get?name=".$imgFileName;
$url = str_replace(' ', '%20', $url);
$rawImage = getCurlImg($url);
$imgNewFileName = strstr($imgFileName, 'IMG-');

if(!file_put_contents("/home/training/api.testcases.tk/img/".$imgNewFileName, $rawImage)){
    echo "API : Failed to save img data to file system<br>";
}
else {
    echo "API : Img file saved to file system<br>";
}

//Delete request for the form file

$url = "https://app.testcases.tk/data/delete?name=".$formFileName;
$url = str_replace(' ', '%20', $url);
if(!curlDelete($url)){
    echo "API : Failed to delete form file<br>";
}
else {
    echo "API : Form file succesfully deleted<br>";
}

//Delete request for the img file

$url = "https://app.testcases.tk/data/delete?name=".$imgFileName;
$url = str_replace(' ', '%20', $url);
if(!curlDelete($url)){
    echo "API : Failed to delete img file<br>";
}
else {
    echo "API : Img file succesfully deleted<br>";
}






  
}





//GET request cURL   
function getCurl ($url){
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL,$url);
$result=json_decode(curl_exec($ch));
curl_close($ch);

return $result;
}

//GET cURL Binary
function getCurlImg ($url){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    curl_close ($ch);
    return $raw;
}

//DELETE cURL request
 function curlDelete($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $result;
}
















?>