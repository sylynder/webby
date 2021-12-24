<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Your Application Cache Array Configurations
| -------------------------------------------------------------------------
| This file lets you define some configurations
| that can help with cache functionalities
|
| Please make sure you understand what you are doing before 
| you change the cache configurations
 */

/*
|--------------------------------------------------------------------------
| Cache Path
|--------------------------------------------------------------------------
|
| Main directory for all cache files
|
*/
$config['cache_path'] = CACHE_PATH;

/*
|--------------------------------------------------------------------------
| Web Catch Path 
|--------------------------------------------------------------------------
|
| Main directory for web cache files
|
*/
$config['web_cache_path'] = WEB_CACHE_PATH . 'app';

/*
|--------------------------------------------------------------------------
| Plates Cache Path
|--------------------------------------------------------------------------
|
| Main directory for plate template cache files
|
*/
$config['plates_cache_path'] = WEB_CACHE_PATH . 'plates';

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
|	['q'] = Enabled, but only take into account the specified list
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

/*
|--------------------------------------------------------------------------
| Enable Custom Cache
|--------------------------------------------------------------------------
|
| Checks if custom caches are allowed
|
*/
$config['enable_custom_cache'] = false;

/*
|--------------------------------------------------------------------------
| Cache With Language
|--------------------------------------------------------------------------
|
| Uses language based to cache files
| This is useful on a multi-language site
|
*/
$config['cache_with_lang'] = false;

/*
|--------------------------------------------------------------------------
| Cache Drivers
|--------------------------------------------------------------------------
|
| Use to set the cache driver
| Default is file
|
| Available adapters are: apc|memcached|redis
|
*/
$condig['cache_driver'] = [
    'adapter' => 'apc',
    'backup' => 'file'
];
