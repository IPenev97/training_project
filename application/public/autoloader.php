<?php
function autoLoader($className){

    $directories = array(
        '%s/../app/includes/%s.php',
        '%s/../app/includes/form_fields/%s.php'

    );

        foreach($directories as $directory) {
            $path = sprintf($directory,__DIR__,$className);
            if(file_exists($path)) {
                require_once $path;
                return;
                
            
            }

        }








}
spl_autoload_register('autoLoader');
?>