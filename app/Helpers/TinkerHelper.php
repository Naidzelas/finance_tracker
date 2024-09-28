<?php

namespace App\Helpers;

class TinkerHelper
{
    public static function __callStatic($name, $arguments)
    {
        $path = app_path(
             DIRECTORY_SEPARATOR . 'Helpers' .
            DIRECTORY_SEPARATOR . 'TinkerScripts' .
            DIRECTORY_SEPARATOR . $arguments[0] . '.php'
        );

        if (file_exists($path)) {
            include $path;

            return run();
        }

        return "Calling '$name' yield no results";
    }
}
