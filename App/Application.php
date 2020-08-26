<?php


namespace App;

use Core\Database;
use Core\Router;

class Application
{
  public static $db;

  public static function init()
  {
    require_once __DIR__ . '/consts.php';

    static::$db = new Database();
      var_dump(class_exists('Core\Router'));
    var_dump(class_exists('Controllers/PageController'));
    $router = new Router();

    $router ->run();
  }

}

