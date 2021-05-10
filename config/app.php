<?php
defined('COREPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Your Application Array Configurations
|--------------------------------------------------------------------------
|
| You can add more config array here for your application
|
| e.g $config['some_config_name_here'] = 'some_value_here';
*/

/*
| -------------------------------------------------------------------------
| Application name: e.g Webby 
|  
| It makes available everywhere
| 
| Your App Name might be the name of the application
| you are working on.
| -------------------------------------------------------------------------
|
 */
$config['app_name'] = 'Asap';

/*
| -------------------------------------------------------------------------
| Application Status
|  
| This sets the status of the app
| 
| -------------------------------------------------------------------------
|
 */
$config['app_status'] = false;

/*
| -------------------------------------------------------------------------
| Application Maintenance
|  
| Turn site maintenance on or off 
| (found in config/constants.php)
| 
| -------------------------------------------------------------------------
|
 */
$config['maintenance_mode'] = SITE_ON;

/*
| -------------------------------------------------------------------------
| Error 404 Emergency view
|  
| Set this view for possible 
| error 404 page
| 
| -------------------------------------------------------------------------
|
 */

$config['app_error_view'] = 'errors/error404';