<?php
defined('COREPATH') or exit('No direct script access allowed');

use Base\Route\Route;

/*
| -------------------------------------------------------------------------
| WEB URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
|
| Please make sure route names don't conflict in all the route files
| 
*/

/*
| -------------------------------------------------------------------------
| WEB ROUTING HINT
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions
| that controls WEB activities. Please make sure route names don't conflict 
| in all the other route files
| 
| $route['route-pattern'] = 'module/controller/method/segment1/segment2/segment3';
|
| A new way to add routes also come in this form
| Route::get('route-pattern', 'module/controller/method/segment1/segment2/segment3');
*/
