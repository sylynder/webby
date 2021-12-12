<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  App Autoloader
| -------------------------------------------------------------------
| Location of app autoloaders:
| These files have been autoloaded
| to help application's core functionality
|  require_once ROOTPATH . 'config/autoload.php';
|
 */
require_once ROOTPATH . 'config/autoload.php';

/*
| -------------------------------------------------------------------
|  Webby Autoloader
| -------------------------------------------------------------------
| Location of core autoloaders:
| These files have been autoloaded
| to help Webby's core functionality
|
|  require_once ENGINEPATH.'core_loader.php';
|
 */
require_once ENGINEPATH . 'core_loader.php';


/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = [APPPATH.'third_party', '/usr/local/shared'];
|
*/
$autoload['packages'] = $packages;

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in system/libraries/ or your
| application/libraries/ directory, with the addition of the
| 'database' library, which is somewhat of a special case.
|
| Prototype:
|
|	$autoload['libraries'] = ['database', 'email', 'session'];
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|	$autoload['libraries'] = ['user_agent' => 'ua'];
*/
$autoload['libraries'] = [$libraries, $core_libraries];

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = ['cache'];
|
| You can also supply an alternative property name to be assigned in
| the controller:
|
|	$autoload['drivers'] = ['cache' => 'cch'];
|
*/
$autoload['drivers'] = $drivers;

/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = ['url', 'file'];
*/
$autoload['helper'] = [$helpers, $core_helpers];

/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = ['config1', 'config2'];
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/
$autoload['config'] = $config;

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = ['lang1', 'lang2'];
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as ['codeigniter'];
|
*/
$autoload['language'] = $language;

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = ['first_model', 'second_model'];
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|	$autoload['model'] = ['first_model' => 'first'];
*/
$autoload['model'] = [$models, $core_models];
