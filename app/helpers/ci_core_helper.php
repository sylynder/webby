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

if ( ! function_exists('action')) 
{
    /**
     * Use it for form actions.
     *
     * @param string $uri
     * @param mixed $method
     * @return void
     */
    function action($uri = '', $method = null)
    {
        if (is_null($uri)) {
            return "action=''" . ' ';
        }
        
        if (!is_null($method) && $method === 'post' || $method === 'get') {
            return "action='" . site_url($uri) . "'" .' '. "method='" . $method . "'" . ' ';
        }

        return "action='" . site_url($uri) . "'" . ' ';
    }
}

if ( ! function_exists('active_link')) 
{
    /**
    * Use it to set active or current url for 
    * css classes. Default class name is (active)
    */
    function active_link($link, $class = null)
    {
        if ($class !== null) {
            return ci()->uri->uri_string() === $link ? 'class='.$class : '';
        } 
        
        return ci()->uri->uri_string() === $link ? 'class='.'active' : '';
        
    }
}

if ( ! function_exists('uri_segment')) 
{
    /**
     * Undocumented function
     *
     * @param string $n
     * @param mixed $no_result
     * @return void
     */
    function uri_segment($n, $no_result = NULL)
    {
        return ci()->uri->segment($n, $no_result);
    }
}
/* ------------------------------- Uri Functions ---------------------------------*/

