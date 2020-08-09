<?php

defined('BASEPATH') or exit('No direct script access allowed');

if ( ! function_exists('ci')) 
{
    /**
     *  CodeIgniter Instance function
     */

    function ci()
    {
        return $ci = &get_instance();
    }
}

/* ------------------------------- Uri Functions ---------------------------------*/

if ( ! function_exists('app_url')) 
{
    /**
     * alias of base_url.
     *
     * @param string $uri
     * @param bool $protocol
     * @return void
     */
    function app_url($uri = '', $protocol = NULL)
    {   
        return base_url($uri, $protocol);
    }
}

if ( ! function_exists('url')) 
{
    /**
     * alias of site_url
     *
     * @param string $uri
     * @param bool $protocol
     * @return void
     */
    function url($uri = '', $protocol = NULL)
    {
        
        if ($uri === 'void') {
            return void_url();
        }

        return site_url($uri, $protocol);
    }
}

/* ------------------------------- Uri Functions ---------------------------------*/

