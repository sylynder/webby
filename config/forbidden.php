<?php
defined('COREPATH') or exit('No direct script access allowed');

/* 
| -------------------------------------------------------------------------
| Forbidden Routes Configurations
| -------------------------------------------------------------------------
| This contains configurations to
| control how intruders can be routed 
| outside any Webby Application
|
*/

/* 
| -------------------------------------------------------------------------
| Forbidden Routes List
| -------------------------------------------------------------------------
| A list of forbidden routes
| You can add more if any
|
*/
$config['forbidden_routes'] = [
    '.git',
    '.env',
    'env',
    'wp-admin',
    'wp-login',
    'wp-login.php',
    'wp-admin.php',
    'composer.lock',
    'yarn.lock',
    'package-lock.json',
    'xmlrpc.php',
    'typo3',
];

/* 
| -------------------------------------------------------------------------
| The default route to use
| -------------------------------------------------------------------------
| You can define a module/controller
| that can handle your routes here
|
*/
$config['default_outside_route'] = 'error/handle/outside';

/* 
| -------------------------------------------------------------------------
| The default url to route outside
| -------------------------------------------------------------------------
| The url below is set as the default
| to route all forbidden routes to.
|
| You can change to any url of your choice
|
*/
$config['route_outside'] = 'https://google.com';
