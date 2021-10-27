<?php
require_once __DIR__. '/autoloader.php';

 $router = new Router();



 $router->get('/', function(){
    require_once __DIR__. '/formpage.php';
    $form = initializeForm($data = array(), $imgData = array());
    echo $form->toHtml();
 });


 $router->post('/submit', function($params){
    
    require_once __DIR__. '/formpage.php';
    updateConfigFile($params);
    $form = initializeForm($params);
    if(!$form->processData()){
        echo $form->toHtml();
    }
    else {
        require_once __DIR__. '/formsubmitted.php';
    }

 });

 $router->get('/data/all', function(){
     $communicator = new Communicator();
     echo $communicator->getAllData();
     
     

 });

 
 $router->get('/data/get', function($params){
    $communicator = new Communicator();
    echo $communicator->getData($params['name']);
        
    
 });
 
 $router->delete('/data/delete', function($params){
     $communicator = new Communicator();
     if(!$communicator->deleteData($params['name'])){
         echo 'Failed to delete file!';
     }
 });
 



 $router->notFound(function(){
    echo 'Page Not Found';
 });

 $router->run();

 
?> 
