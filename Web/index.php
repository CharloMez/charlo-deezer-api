<?php
namespace Web;

use App\Kernel;
use App\Autoloader;
use App\Request;
use App\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS . '..' . DS);

require_once '../App/Autoloader.php';
Autoloader::register();

$request = new Request();
$router = new Router();

$kernel = new Kernel($request, $router);

$kernel->launch();
