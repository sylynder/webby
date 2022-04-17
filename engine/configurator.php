<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Get all Configuration files
|--------------------------------------------------------------------------
| 
| Load all configuration files here
|
*/

$files = glob(ROOTPATH . "config" . DIRECTORY_SEPARATOR . "*.php"); 

// Exclude these specified files
$exclude = [
    'autoload',
    'constants',
    'database',
    'hooks',
    'profiler',
    'commands',
];

foreach ($files as $file) 
{
    foreach ($exclude as $name) 
    {
        if (stripos($file, $name) !== false) {
            continue 2; // break out of 2 levels of loops 
        }
    }

    require_once $file;
}
