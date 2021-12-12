<?php

defined('COREPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| HMVC Setup
| -------------------------------------------------------------------------
| This file has some setup defined to simplify how
| the framework should work when applying module concepts
|
 */

/*
|--------------------------------------------------------------------------
| HMVC Path Configuration
|--------------------------------------------------------------------------
| Here we are setting up which directories can be used
| for implementing HMVC functionalities
|
 */
$config['modules_locations'] = [
    CONSOLEPATH  => '../../../app/Console/',
    WEBPATH      => '../../../app/Web/',
    PACKAGEPATH  => '../../../app/Packages/',
    APIPATH      => '../../../app/Api/',
];
