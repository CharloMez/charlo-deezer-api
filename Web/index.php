<?php
namespace Web;

use App\Autoloader;
use App\Kernel;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS . '..' . DS);

require_once '../App/Autoloader.php';
Autoloader::register();

$kernel = new Kernel();

$kernel->launch();
