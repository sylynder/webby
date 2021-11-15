<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Plates Config File
| -------------------------------------------------------------------------
| This file lets you define configuration for 
| Plates if you want to use it in layouting your views
|
*/


/*
|--------------------------------------------------------------------------
| Plates File Extension
|--------------------------------------------------------------------------
|
| Set the file extension for the plates template
|
*/
$config['plate_extension'] = '.php';

/*
|--------------------------------------------------------------------------
| Cache Expiration Time
|--------------------------------------------------------------------------
|
| Set the amount of time to keep the file in cache
|
*/
$config['cache_time'] = 3600;

/*
|--------------------------------------------------------------------------
| Enable/Disable Autoload
|--------------------------------------------------------------------------
|
| Set to true to autoload CodeIgniter Libraries and Helpers
|
*/
$config['enable_autoload'] = false;

/*
|--------------------------------------------------------------------------
| Resources to Autoload
|--------------------------------------------------------------------------
|
| List of Libraries and Helpers to autoload with Plates.
|
| WARNING: To autoload these resources you must set 'enable_autoload'
| variable to true.
|
*/
$config['libraries'] = [];
$config['helpers'] = [];

/*
|--------------------------------------------------------------------------
| Load Plates Helper
|--------------------------------------------------------------------------
|
| Set to true and Plate helper file will be loaded in the initialization.
| it is located at engine/Core/helpers/plate_helper.php
|
*/
$config['enable_helper'] = true;
