<?php

/**
 * A service layer implementation for Webby
 * It can be used to load service based classes
 * to simplify logic created in controllers
 */
class Base_Service
{
    public function __construct()
    {
        log_message('debug', "Service Class Initialized");
    }

    function __get($key)
    {
        $CI = &get_instance();
        return $CI->$key;
    }
}
