<?php

/*
 * Define Directory Paths and bootstrap application 
 */
define('__ONE__', 1); // No special functionality with this. It is just a helper constant

// Path to the front controller (this file)
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// The name of this file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

/*
 *---------------------------------------------------------------
 * COMPOSER AUTOLOADING
 *---------------------------------------------------------------
 *
 * Load composer to simplify class and namespace autoloading
 */
require __DIR__ . '/../vendor/autoload.php';

/*
 *---------------------------------------------------------------
 * CODEIGNITER FRAMEWORK DIRECTORY NAME & PATH
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "codigniter framework" directory.
 * Set the path if it is not in the same directory as this file.
 */
$ci_directory = __DIR__ . '/../vendor/sylynder/codeigniter/framework';
$ci_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * CORE DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * The core directory used to be the application directory 
 *
 * If you want this front controller to use a different "core"
 * directory than the default one you can set its name here. The directory
 * can also be renamed or relocated anywhere on your server. If you do,
 * use an absolute (full) server path.
 * For more info please see the user guide:
 *
 * https://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
$core_directory = __DIR__ . '/../engine/Core';
$core_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * directory, set the path to it here. The directory can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application directory.
 * If you do move this, use an absolute (full) server path.
 *
 * NO TRAILING SLASH!
 */
$view_directory = __DIR__ . '/../app/Views';
$view_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * ASSETS FOLDER NAME
 *---------------------------------------------------------------
 *
 * This folder is where you will put all the css, javascript, images and fonts.
 * You can decide to locate the folder anywhere you like
 */
$asset_directory = 'assets';
$asset_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * THEMES FOLDER NAME
 *---------------------------------------------------------------
 *
 * This folder is where you will put all the themes files.
 * You can decide to locate the folder anywhere you like
 */
$themes_directory =  'themes';
$themes_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * RESOURCES PATH
 *---------------------------------------------------------------
 *
 * This folder is where all files can be stored
 */
$resources_directory = 'resources';
$resources_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * PACKAGES PATH
 *---------------------------------------------------------------
 *
 * This folder is where all packages will be placed
 * You can decide to locate the folder anywhere you like
 */
$packages_directory = __DIR__ . '/../app/Packages';
$packages_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * API PATH
 *---------------------------------------------------------------
 *
 * This folder is where all api application files will be placed
 * This works just as modules in HMVC
 * You can decide to locate the folder anywhere you like
 */
$api_directory = __DIR__ . '/../app/Api';
$api_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * WEB PATH
 *---------------------------------------------------------------
 *
 * This folder is where all web application files will be placed
 * This works just as modules in HMVC
 * You can decide to locate the folder anywhere you like
 */
$web_directory = __DIR__ . '/../app/Web';
$web_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * COMPOSER PATH
 *---------------------------------------------------------------
 *
 * This folder is where developers can add composer to expand SylynderCI
 * You can decide to locate the folder anywhere you like
 */
$composer_directory = __DIR__ . '/../vendor';
$composer_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * WRITABLE PATH
 *---------------------------------------------------------------
 *
 * This folder is where all files can be stored
 */
$writable_directory = __DIR__ . '/../writable';
$writable_directory_line = __LINE__ - __ONE__;

/*
 *---------------------------------------------------------------
 * UPLOAD FOLDER NAME
 *---------------------------------------------------------------
 *
 * This folder is where users of the system will store their files
 */
$upload_directory = __DIR__ . '/../writable/uploads';
$upload_directory_line = __LINE__ - __ONE__;

/*
 * Bootstrap the application here
 */
include_once( __DIR__ . '/../engine/bootstrap.php');

/*
 * Function to detect application 
 * environment 
 */
function detect_environment()
{
    // Make sure ENVIRONMENT isn't already set by other means.
    if (! defined('ENVIRONMENT'))
    {
        // running under Continuous Integration server?
        if (getenv('CI') !== false)
        {
            define('ENVIRONMENT', 'testing');
        }
        else
        {
            return $_SERVER['app.env'] ?: 'production';
        }
    }
}

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
define('ENVIRONMENT', detect_environment());

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

/*
 * --------------------------------------------------------------------
 * LOAD CODEIGNITER BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once CIPATH . 'core/CodeIgniter.php';
