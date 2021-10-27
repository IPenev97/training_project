<?php
    class Communicator{

        const FORM_FILES_PATH = __DIR__.'/../form_submissions/*';
        const IMG_UPLOAD_PATH = __DIR__.'/../img/*';
        //Get all json/img file paths 
        public function getAllData(){
            $output_array = $this->getAllFilesAsJsonArray();
            if(!headers_sent()){
            header('Content-type:application/json');
            }
            return $output_array;

        }

        //Get json file 
        public function getData($file){
            $output = $this->getFile($file);
            if(empty($output)){
                return 'File not found!';
            }
            if(!headers_sent()){
                header('Content-type:application/json');
                }
            return $output;
        }
        //Delete file
        public function deleteData($file){
            if(!$this->deleteFile($file)){
                return false;
            }
            return true;
        }

        private function getAllFilesAsJsonArray(){
            $forms_array = array();
            $imgs_array = array();
            $output_array = array();
            foreach(glob(self::FORM_FILES_PATH) as $file) {

                $forms_array[] = $file;
            }
            foreach(glob(self::IMG_UPLOAD_PATH) as $file) {
                $imgs_array[] = $file;
            
            }
            for($i=0 ; $i<count($forms_array) ; $i++){
                $tmp_array = array();
                $tmp_array[0] = $imgs_array[$i];
                $tmp_array[1] = $forms_array[$i];
                $output_array[$i] = $tmp_array; 
            }

            $output_array = json_encode($output_array);
            return $output_array;
            
            
        }
        private function getFile($path){

            return file_get_contents($path);
        }
        private function deleteFile($path){

            return unlink($path);
        }




    }
?>