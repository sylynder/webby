<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Include Default Configuration file
|--------------------------------------------------------------------------
|
 */
include_once ROOTPATH . 'config/config.php';

/*
|--------------------------------------------------------------------------
| Load Application Configuration files
|--------------------------------------------------------------------------
|
 */
include_once ENGINEPATH . 'configurator.php';

/*
|--------------------------------------------------------------------------
| HMVC Configuration File
|--------------------------------------------------------------------------
|
 */
include_once ENGINEPATH . 'modular.php';

/*
|--------------------------------------------------------------------------
| Migrations Configuration File
|--------------------------------------------------------------------------
|
 */
include_once COREPATH . 'config/migration.php';
