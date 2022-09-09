<?php
defined('COREPATH') or exit('No direct script access allowed');

use Base\Route\Route;

/*
| -------------------------------------------------------------------------
| RESERVED OR DEFAULT ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = false;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to true, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
|
| Please make sure route names don't conflict in all the route files
| 
| $route['route-pattern'] = 'controller/method/segment1/segment2/segment3';
| 
| Is advisable that you don't use the alternate routing format here
| A new way to add routes also come in this form
| Route::get('route-pattern', 'module/controller/method/segment1/segment2/segment3');
*/

$route['default_controller'] = 'app';
$route['404_override'] = 'errors/handle';
$route['translate_uri_dashes'] = false;