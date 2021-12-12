<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Your Application Services Discovery Configurations
|--------------------------------------------------------------------------
|
| You can add more config array here for your application services
|
| e.g $config['services_type'] = ['some_service_alias' => 'path_to_discover_service'];
*/


/*
|--------------------------------------------------------------------------
| Define your alias and services source here
|--------------------------------------------------------------------------
|
| This can be loaded with the use_services() function
| in a given controller function or constructor
|
| e.g. 'user' => 'Auth/UserService',
*/

$config['webby_services'] = [];


/*
|--------------------------------------------------------------------------
| A Service Discovery Implementation
|--------------------------------------------------------------------------
|
| If you would like to use other services from packages like composer 
| or a loaded third party package, you will specify it here. 
| See the user guide for details. (Currently works but left some few tweaks)
|
*/

$config['app_services'] = [];
