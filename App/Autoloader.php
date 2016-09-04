<?php

namespace App;

/**
 * Class Autoloader
 *
 * @package App
 */
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * @param string $class
     */
    public static function autoload($class)
    {
        $parts = preg_split('#\\\#', $class);

        $className = array_pop($parts);

        $path = implode(DS, $parts);
        $file = $className . '.php';

        $filePath = ROOT . $path . DS . $file;

        require $filePath;
    }
}