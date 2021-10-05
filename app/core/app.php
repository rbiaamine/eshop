<?php
class App{

    protected $controller = "home";
    protected $method = "index";
    protected $params ;

    public function __construct(){
        $url = $this->parseURL();
       
        if (file_exists("../app/controllers/" . strtolower($url[0]) . ".php")) {
            $this->controller = strtolower($url[0]);
            unset($url[0]);
        }
        require "../app/controllers/" . $this->controller . ".php";
        show($url);
        $this->controller = new $this->controller;  
        
        if (method_exists($this->controller, $url[1])){
            $this->method = strtolower($url[1]);
            unset($url[1]);
        }
        $this->params = (count($url) > 0) ? array_values($url) : ['home'] ;
        show(array_values($url));
        call_user_func_array([$this->controller,$this->method], $this->params);
    }
    
    
    private function parseURL(){
        
        $url = isset($_GET['url']) ? $_GET['url'] : 'home';
        
        $url = explode('/' ,filter_var((trim($url, "/")), FILTER_SANITIZE_URL));
        return $url;
    }
}