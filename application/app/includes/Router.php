<?php

class Router {

    private $handlers = array();
    private $notFoundHandler;
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';
    
    //Get method
    public function get($path,$handler)
    {
        $this->addHandler($path, self::METHOD_GET, $handler);
        
    }
    //Post method
    public function post($path,$handler)
    {
           $this->addHandler($path, self::METHOD_POST, $handler);
    }
    //Delete method
    public function delete($path, $handler){
        $this->addHandler($path, self::METHOD_DELETE, $handler);
    }
    public function notFound($handler){
            $this->notFoundHandler=$handler;
    }
    //Initialize router
    public function run(){
           $requestUri = parse_url($_SERVER['REQUEST_URI']);
           $method = $_SERVER['REQUEST_METHOD'];
           $requestPath = $requestUri['path'];
           $callback = null;
           //Look for required handler
           foreach($this->handlers as $handler) {
            
                if ($handler['path'] == $requestPath && $method == $handler['method']){
                    $callback = $handler['handler'];
                }
           }
           //Call path not found handler if path is not routed
           if(!$callback) {
                if (!empty($this->notFoundHandler)){
                    $callback = $this->notFoundHandler;
                }
           }
           //Execute function if handler is initialized for path
           call_user_func_array($callback, [
               array_merge($_GET, $_POST, $_FILES)
           ]);
    }

    
    private function addHandler($path, $method, $handler)
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' =>$handler
        ];
        
    }
    


}



?>