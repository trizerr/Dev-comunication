<?php



namespace Core;
use Controllers;


class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
      $arr = require ROOTHPATH . '/config/routes.php';

        foreach ($arr as $k => $v)
        {
            $this->add($k, $v);
        }
    }

    public function add($route, $params)
    {
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route => $params)
        {
            if (preg_match($route, $url, $matches))
            {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
     public function run(){

       if($this-> match()){
         $path = 'Controllers'. DIRECTORY_SEPARATOR . ucfirst($this->params['controller'].'Controller');
          // var_dump($path);
         //if(class_exists($path)){
             var_dump("nicer");
            $action = $this->params['action'].'Action';
            //if(method_exists($path, $action)){
                var_dump("niceeer");
                $controller = new $path($this->params);
                $controller->$action();
           // }else{
            //    View::errorCode(404);
            //}
         //}else{
         //   View::errorCode(404);
         //}
       }else{
        View::errorCode(404);
       }
     }
}