<?php

// Path to the front controller (this file)
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// The name of this file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Use Webby Outside
define('WEBBY_OUTSIDE',  filter_var(getenv('app.outside'), FILTER_VALIDATE_BOOLEAN));

if (WEBBY_OUTSIDE) {
    return;
}

/*
 *---------------------------------------------------------------
 * COMPOSER AUTOLOADING
 *---------------------------------------------------------------
 *
 * Load composer to simplify class and namespace autoloading
 */
require __DIR__ . '/../vendor/autoload.php';

/*
 * Paths for needed directories
 */
include_once __DIR__ . '/../engine/paths.php';

/*
 * Bootstrap the application here
 */
include_once __DIR__ . '/../engine/bootstrap.php';

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
