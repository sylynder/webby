<?php

defined('BASEPATH') or exit('No direct script access allowed');

if ( ! function_exists('ci')) 
{
    /**
     *  CodeIgniter Instance method
     */

    function ci()
    {
        return $ci = &get_instance();
    }
}
