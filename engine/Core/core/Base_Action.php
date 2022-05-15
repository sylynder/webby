<?php
defined('COREPATH') or exit('No direct script access allowed');

/**
 * An action layer implementation for Webby
 * It can be used to load action based classes
 * to simplify logic created in controllers
 * mostly to assist CRUD Based functionalities
 */

class Base_Action
{
    public function __construct()
    {
        log_message('debug', "Action Class Initialized");
    }

    function __get($key)
    {
        $CI = &get_instance();
        return $CI->$key;
    }
}
/* end of file Base_Action.php */
