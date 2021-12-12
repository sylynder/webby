<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configure Commands
|--------------------------------------------------------------------------
|
| Allows you to choose which command type to use
| Available currently is webby-console i.e by using controllers
| 
| There is an option to use Symfony/Console by setting 
| command_type as 'symfony-console' (Currently not available)
|
| @Todo add the said feature above
*/
$config['command_type'] = 'webby-console';

/*
|--------------------------------------------------------------------------
| Register Commands Signature
|--------------------------------------------------------------------------
|
| This option allows you to add commands and their signatures 
|
*/
$config['commands'] = [];
