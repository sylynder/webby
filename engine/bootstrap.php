<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author    EllisLab Dev Team
 * @copyright    Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright    Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license    http://opensource.org/licenses/MIT    MIT License
 * @link    https://codeigniter.com
 * @since    Version 1.0.0
 * @filesource
 */

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here. For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT: If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller. Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 */
// The directory name, relative to the "controllers" directory.  Leave blank
// if your controller is not in a sub-directory within the "controllers" one
// $routing['directory'] = '';

// The controller class file name.  Example:  mycontroller
// $routing['controller'] = '';

// The controller function you wish to be called.
// $routing['function']    = '';

/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 */
// $assign_to_config['name_of_config_item'] = 'value of config item';

// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($ci_directory)) !== false) {
    $ci_directory = $_temp . DIRECTORY_SEPARATOR;
} else {
    // Ensure there's a trailing slash
    $ci_directory = strtr(
        rtrim($ci_directory, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
    ) . DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if (!is_dir($ci_directory)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your ci_directory path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $ci_directory_line;
    exit(3); // EXIT_CONFIG
}

//Set Console path correctly
if (($_temp = realpath($console_directory)) !== false) {
    $console_directory = $_temp . '/';
} else {
    // Ensure there's a trailing slash
    $console_directory = rtrim($console_directory, '/') . '/';
}

// Is the Console path correct?
if (!is_dir($console_directory)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your console directory path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $console_directory_line;
    exit(3); // EXIT_CONFIG
}

//Set Packages path correctly
if (($_temp = realpath($packages_directory)) !== false) {
    $packages_directory = $_temp . '/';
} else {
    // Ensure there's a trailing slash
    $packages_directory = rtrim($packages_directory, '/') . '/';
}

// Is the Packages path correct?
if (!is_dir($packages_directory)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your packages directory path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $packages_directory_line;
    exit(3); // EXIT_CONFIG
}

//Set api path correctly
if (($_temp = realpath($api_directory)) !== false) {
    $api_directory = $_temp . '/';
} else {
    // Ensure there's a trailing slash
    $api_directory = rtrim($api_directory, '/') . '/';
}

// Is the web path correct?
if (!is_dir($api_directory)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your api directory path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $api_directory_line;
    exit(3); // EXIT_CONFIG
}

//Set web path correctly
if (($_temp = realpath($web_directory)) !== false) {
    $web_directory = $_temp . '/';
} else {
    // Ensure there's a trailing slash
    $web_directory = rtrim($web_directory, '/') . '/';
}

// Is the web path correct?
if (!is_dir($web_directory)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your web directory path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $web_directory_line;
    exit(3); // EXIT_CONFIG
}

//Set Composer path correctly
if (($_temp = realpath($composer_directory)) !== false) {
    $composer_directory = $_temp . '/';
} else {
    // Ensure there's a trailing slash
    $composer_directory = rtrim($composer_directory, '/') . '/';
}

// Is the composer path correct?
if (!is_dir($composer_directory)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your composer directory path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $composer_directory_line;
    exit(3); // EXIT_CONFIG
}

//Set writable path correctly
if (($_temp = realpath($writable_directory)) !== false) {
    $writable_directory = $_temp . '/';
} else {
    // Ensure there's a trailing slash
    $writable_directory = rtrim($writable_directory, '/') . '/';
}

// Is the writable path correct?
if (!is_dir($writable_directory)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your writable directory path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $writable_directory_line;
    exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */

// Path to the system (CodeIgniter) folder
define('BASEPATH', str_replace('\\', DIRECTORY_SEPARATOR, $ci_directory));

// Path to the packages folder
define('CONSOLEPATH', str_replace('\\', DIRECTORY_SEPARATOR, $console_directory));

// Path to the packages folder
define('PACKAGEPATH', str_replace('\\', DIRECTORY_SEPARATOR, $packages_directory));

// Path to the web folder
define('WEBPATH', str_replace('\\', DIRECTORY_SEPARATOR, $web_directory));

// Path to the api folder
define('APIPATH', str_replace('\\', DIRECTORY_SEPARATOR, $api_directory));

// Path to the composer folder
define('COMPOSERPATH', str_replace('\\', DIRECTORY_SEPARATOR, $composer_directory));

// Path to the writable folder outside public folder
define('WRITABLEPATH', str_replace('\\', DIRECTORY_SEPARATOR, $writable_directory));

// Path to the root folder
define('ROOTPATH', str_replace('public' . DIRECTORY_SEPARATOR, '', FCPATH));

// Path to the engine folder
define('ENGINEPATH', ROOTPATH . 'engine' . DIRECTORY_SEPARATOR);

/**
 *
 *---------------------------------------------------------------
 * DEVELOPERS APP FOLDER NAME
 *---------------------------------------------------------------
 * Path to the developers applicaton directory
 * This directory is where you will put all the application files.
 * Since Codeigniter recognizes APPPATH as its old/own application folder name
 * We decided to name the developers app directory as APPROOT so that it will 
 * deferentiate the two
 * Please do not relocate this folder
 */
define('APPROOT', ROOTPATH . 'app/');

// Name of the "codeigniter folder"
define('SYSDIR',
    trim(
        strrchr(
            trim(BASEPATH, DIRECTORY_SEPARATOR),
            DIRECTORY_SEPARATOR
        ),
        DIRECTORY_SEPARATOR
    )
);

// Path to Stubs APPROOT . 'cli/Commands' . DIRECTORY_SEPARATOR;
// define('STUBSPATH', ENGINEPATH . 'Sylynder/Views/Console/stubs' . DIRECTORY_SEPARATOR);

// define('COMMANDPATH', APPROOT . 'Cli/Commands' . DIRECTORY_SEPARATOR);

// This used to be the "application" folder for codeigniter
// The path to "core" folder
if (is_dir($core_directory)) {
    
    if (($_temp = realpath($core_directory)) !== false) {
        $core_directory = $_temp;
    }

    define('APPPATH', $core_directory . DIRECTORY_SEPARATOR);
} else {

    if (!is_dir(BASEPATH . $core_directory . DIRECTORY_SEPARATOR)) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your common directory path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $core_directory_line;
        exit(3); // EXIT_CONFIG
    }

    define('APPPATH', BASEPATH . $core_directory . DIRECTORY_SEPARATOR);
}

/*
 * We set these constant because we don't want
 * to change APPPATH and BASEPATH Since codeigniter uses them
 */
define('COREPATH', APPPATH);
define('CIPATH', BASEPATH);


// The path to the "views" folder
if (!is_dir($view_directory)) {

    if (!empty($view_directory) && is_dir(COREPATH . $view_directory . DIRECTORY_SEPARATOR)) {
        $view_directory = COREPATH . $view_directory;
    } elseif (!is_dir(COREPATH . 'views' . DIRECTORY_SEPARATOR)) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your view folder path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $view_directory_line;
        exit(3); // EXIT_CONFIG
    } else {
        $view_directory = COREPATH . 'views';
    }
}

if (($_temp = realpath($view_directory)) !== false) {
    $view_directory = $_temp . DIRECTORY_SEPARATOR;
} else {
    $view_directory = rtrim($view_directory, '/\\') . DIRECTORY_SEPARATOR;
}

define('VIEWPATH', $view_directory);

// The path to the "asset" folder
if (is_dir($asset_directory)) {
    define('ASSETS', $asset_directory . DIRECTORY_SEPARATOR);
} else {

    if (!is_dir(CIPATH . $asset_directory . DIRECTORY_SEPARATOR) && !defined('STDIN')) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your assets folder path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line ' . $asset_directory_line;
        exit(3); // EXIT_CONFIG
    }

    define('ASSETS', $asset_directory . DIRECTORY_SEPARATOR);
}

// The path to the "upload_directory" folder
if (is_dir($upload_directory)) {
    define('UPLOADPATH', $upload_directory . DIRECTORY_SEPARATOR);
} else {

    if (!is_dir(CIPATH . $upload_directory . DIRECTORY_SEPARATOR)) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your uploads data folder path does not appear to be set correctly. Please open the public/index.php file and set a correct path on line '. $upload_directory_line;
        exit(3); // EXIT_CONFIG
    }

    define('UPLOADPATH', $upload_directory . DIRECTORY_SEPARATOR);
}

/*
 * --------------------------------------------------------------------
 * DEFINE WEBBY VERSION
 * --------------------------------------------------------------------
 */
define('WEBBY_VERSION', 'v1.2.1');

// Load environment settings from .env files
// into $_SERVER and $_ENV
require_once COREPATH . 'DotEnv.php';

$env = new DotEnv(ROOTPATH);
$env->load();
