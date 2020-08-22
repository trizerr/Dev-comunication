<?php


use App\Application;

require_once '../vendor/autoload.php';


ini_set('display_errors', 1);
ini_set('log_errors',1);
//ini_set('error_log',dirname(__DIR__ ) . '/App/helpers/errors.log');

error_reporting(E_ALL);

(new App\helpers\ErrorHandler())->register();

Application::init();
