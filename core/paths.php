<?php

/*
 * Define Directory Paths and bootstrap application 
 */
define('__ONE__', 1); // No special functionality with this. It is just a helper constant

/*
 *---------------------------------------------------------------
 * CODEIGNITER FRAMEWORK DIRECTORY NAME & PATH
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "codigniter framework" directory.
 * Set the path if it is not in the same directory as this file.
 */
$ci_directory = __DIR__ . '/../vendor/sylynder/engine/CodeIgniter/Framework';
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
$core_directory = __DIR__ . '/../vendor/sylynder/engine/Core';
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
 * CONTROLLERS FOLDER NAME
 *---------------------------------------------------------------
 *
 * This folder is where you will put controllers that you don't
 * want to use in an HMVC manner. It needs to be located exactly
 * where is has been specified below.
 */
$controllers_directory = __DIR__ . '/../app/Controllers';
$controllers_directory_line = __LINE__ - __ONE__;

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
 * CONSOLE PATH
 *---------------------------------------------------------------
 *
 * This folder is where all console commands will be placed
 * You can decide to locate the folder anywhere you like
 */
$console_directory = __DIR__ . '/../app/Console';
$console_directory_line = __LINE__ - __ONE__;

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
