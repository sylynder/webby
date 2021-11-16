<?php
defined('COREPATH') or exit('No direct script access allowed');

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
$config['app_name'] = getenv('app.name') ?: 'Webby';

/*
| -------------------------------------------------------------------------
| Application Status
|  
| This sets the status of the app
| defaults to maintenance mode if false
| -------------------------------------------------------------------------
|
 */
$config['app_status'] = true;

/*
|--------------------------------------------------------------------------
| Force the use of SSL
|--------------------------------------------------------------------------
|
| Set to force the use of SSL
|
*/
$config['force_ssl'] = false;

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
$config['maintenance_mode'] = getenv('app.mode.on') ?: APP_ON;

/*
| -------------------------------------------------------------------------
| App maintenance view
|  
| Set this to show app maintenance view
| 
| -------------------------------------------------------------------------
|
 */

$config['maintenance_view'] = getenv('app.maintenance.view') ?: APP_MAINTENANCE_VIEW;

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

$config['app_error_view'] = 'errors/app/error404';

/*
| -------------------------------------------------------------------------
| Error 404 Emergency Route
|  
| Default is using 404_override route
|
| Set this route for possible 
| error 404 page
| 
| e.g. Route::get('not-found', 'App/App/error404');
| 
| 
| -------------------------------------------------------------------------
|
 */
$config['app_error_route'] = '404_override';


// ------------------------- Custom Application Config Here --------------------------------
