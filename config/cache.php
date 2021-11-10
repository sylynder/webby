<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Your App Cache Array Configurations
| -------------------------------------------------------------------------
| This file lets you define some configurations
| that can help with cache functionalities
|
 */

//Please make sure you understand what you are doing before 
//you change the cache configurations

$config['cache_dir']  = CACHE_PATH;

$config['cache_path'] = CACHE_PATH;

$config['web_cache_path'] = WEB_CACHE_PATH;

/*
|--------------------------------------------------------------------------
| Cache Include Query String
|--------------------------------------------------------------------------
|
| Whether to take the URL query string into consideration when generating
| output cache files. Valid options are:
|
|	false      = Disabled
|	true       = Enabled, take all query parameters into account.
|	             Please be aware that this may result in numerous cache
|	             files generated for the same page over and over again.
|	array('q') = Enabled, but only take into account the specified list
|	             of query parameters.
|
*/
$config['cache_query_string'] = false;

/*
|--------------------------------------------------------------------------
| Cache Expire Time
|--------------------------------------------------------------------------
|
| Tells the time for cache file to expire
|
*/
$config['cache_default_expires'] = 3600;