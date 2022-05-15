<?php

namespace Base\Console\Commands;

class MakeDirectory
{

    // recursive create folder and return file path
    public static function createModuleDirectory($modulePath, $directoryName)
    {

        $directory = $modulePath . $directoryName;

        if (!file_exists($directory)) {
            // return true;
        }

        return false;

    }
}