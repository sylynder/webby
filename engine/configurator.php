<?php
defined('COREPATH') OR exit('No direct script access allowed');

/**
*
*  Load all configuration files here
*
*/

/*
|--------------------------------------------------------------------------
| Get all Configuration files
|--------------------------------------------------------------------------
| e.g $config['some_config_name_here'] = 'some_value_here';
*/

$files = glob(ROOTPATH . "config/*.php"); 

$exclude = [
    'autoload',
	'constants',
	'database',
    'hooks',
    'profiler',
	// 'settings',
    // 'commands', 
];

foreach($files as $file)
{  
    foreach($exclude as $name) 
    { 
        if (stripos($file, $name) !== false) 
        { 
            continue 2; // break out of 2 levels of loops 
        } 
    } 

    require_once $file;
}