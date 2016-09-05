<?php

namespace Tests;

use App\Autoloader;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS . '..' . DS);

require __DIR__ . '/../App/Autoloader.php';

Autoloader::register();
