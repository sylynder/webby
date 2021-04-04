<?php
defined('COREPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| View Configurations
| -------------------------------------------------------------------------
| This contains configurations to manipulate how
| views are used in Webby 
|
*/

$config['view'] = [
    
    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'views_path' => VIEWPATH,

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled View templates will be
    | stored for your application. Typically, this is within the writable/cache
    | directory. However, as usual, you are free to change this value.
    |
    */

    'cache_view_path' => WEB_CACHE_PATH,

    /*
    | -------------------------------------------------------------------------
    | Set Default Template Engine
    | -------------------------------------------------------------------------
    | Select which view template engine to use
    | Currently plates is only available
    |
    | Leave it empty to fallback on normal view() or $this->load->view();
    |
    */
    
    'view_engine' => 'plates', // e.g. plates| blade | nette | fat-free | etc

];
