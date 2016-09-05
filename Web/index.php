<?php
namespace Web;

use App\Database\MySQLConnector;
use App\Kernel;
use App\Autoloader;
use App\Request;
use App\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS . '..' . DS);

$parametersFile = file_get_contents(dirname(__FILE__) . '/../.env');

if ($parametersFile === false) {
    throw new \Exception('Missing .env file !');
}

$parameters = new \SimpleXMLElement($parametersFile);

require_once '../App/Autoloader.php';
Autoloader::register();

try {
    MySQLConnector::initDB(array(
        'database_host' => (string) $parameters->database->database_host,
        'database_port' => (string) $parameters->database->database_port,
        'database_name' => (string) $parameters->database->database_name,
        'database_user' => (string) $parameters->database->database_user,
        'database_password' => (string) $parameters->database->database_password
    ));
} catch (\Exception $e) {
    die($e->getMessage());
}

$request = new Request();
$router = new Router();

$request->evalRequest();
$response = $request->getResponse();

$kernel = new Kernel($request, $response, $router);

$content = $kernel->launch();

print $content;