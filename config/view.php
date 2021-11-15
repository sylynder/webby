<?php
defined('COREPATH') or exit('No direct script access allowed');

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
    | View Path
    |--------------------------------------------------------------------------
    |
    | Here you can specify from the path you want your files to 
    | be loaded from. The default has been provided already
    | VIEWPATH. Make sure you understand before you modify
    |
    */

    'views_path' => VIEWPATH,

    /*
    |--------------------------------------------------------------------------
    | Cached View Path
    |--------------------------------------------------------------------------
    |
    | Here your compiled view templates will be stored
    | It is currently stored within WEB_CACHE_PATH, you 
    | can modify the value to any location.
    |
    |
    */

    'cache_view_path' => WEB_CACHE_PATH,

    /*
    | -------------------------------------------------------------------------
    | Set Default Template Engine
    | -------------------------------------------------------------------------
    | Select which view template engine to use
    | Note: Currently plates is only available
    |
    | Leave it empty to fallback on normal view() or $this->load->view();
    |
    | Don't use any other value below apart from "plates" else views will malfunction
    */
    
    'view_engine' => '', // e.g. plates | blade | latte | fat-free | twig | etc

];
