<?php

namespace Core;


class View
{

    public $path;
    public $layout = 'default';


    public function __construct($route)
    {

        $this->path = $route['controller'].'/'.$route['action'];

    }

    // public function render($title, $vars = [])
    // {
    //     extract($vars);
    //     $path = '../App/Views/pages/' . $this->path. '.php';
    //     if (file_exists($path)) {
    //         ob_start();
    //         require $path;
    //         $content = ob_get_clean();
    //         require '../App/Views/layouts/' . $this->layout . '.php';
    //     }else{
    //         echo 'View is not found: '. $this->path;
    //     }
    // }

    // public function redirect($url){
    //     header('location: '.$url);
    //     exit;
    // }

    public static function errorCode($code){
        http_response_code($code);
        $path = '../App/Views/errors/' . $code . '.twig';
        if(file_exists($path)){
            require $path;
        }
        exit;
    }


}
