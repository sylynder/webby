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

if (!function_exists('void_url')) 
{
    /**
     * A function that adds a void url
     *
     * @return void
     */
    function void_url()
    {
        echo 'javascript:void(0)';
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
     * Alias for CodeIgniter's $this->uri->segment
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

if (!function_exists('go_back')) 
{
    /**
     * Go back using Html5 previous history
     *
     * @param string $text
     * @param string $style
     * @return void
     */
    function go_back($text, $style = null)
    {
        echo '<a class="' . $style . '" href="javascript:window.history.go(-1);">' . $text . '</a>';
    }
}

if (!function_exists('html5_back')) 
{
    /**
     * Alias of go_back function
     * To be used in href
     *
     * @return void
     */
    function html5_back()
    {
        return 'javascript:window.history.go(-1)';
    }
}

/* ------------------------------- Request | Resource && User Agent Functions ---------------------------------*/

if ( ! function_exists('post')) 
{
    /**
     * Function to set only post methods
     *
     * @param string $index
     * @param bool $xss_clean
     * @return void
     */
    function post($index = null, $xss_clean = null)
    {
        return ci()->input->post($index, $xss_clean);
    }
}

if ( ! function_exists('get')) 
{
    /**
     * Function to set only get methods
     *
     * @param $string $index
     * @param bool $xss_clean
     * @return void
     */
    function get($index = null, $xss_clean = null)
    {
        return ci()->input->get($index, $xss_clean);
    }
}

if ( ! function_exists('is_ajax_request')) 
{
    /**
     * Check whether request is an ajax request
     *
     * @return boolean
     */
    function is_ajax_request()
    {
        return ci()->input->is_ajax_request();
    }
}

if ( ! function_exists('server')) 
{
    /**
     * Function to set only server methods
     *
     * @param [type] $index
     * @param [type] $xss_clean
     * @return void
     */
    function server($index, $xss_clean = NULL)
    {
        return ci()->input->server($index, $xss_clean);
    }
}

if ( ! function_exists('ip_address')) 
{
    /**
     * Alias of IP Address Fetching from 
     * CodeIgniter's Input Class
     *
     * @return void
     */
    function ip_address()
    {
        return ci()->input->ip_address();
    }
}

if ( ! function_exists('raw_input_stream')) 
{
    /**
     * Holds a cache of php://input contents
     *
     * @return void
     */
    function raw_input_stream()
    {
        return ci()->input->raw_input_stream;
    }
}

if ( ! function_exists('raw_input_contents')) 
{
    /**
     * Get a uri and treat as php://input contents
     *
     * @param string|array $uri
     * @return void
     */
    function raw_input_contents($uri = null)
    {

        if ( ! is_null($uri) && ! is_array($uri)) {
            return file_get_contents($uri);
        }

        //@Todo: Will implement a logic here
        if (is_null($uri) && is_array($uri)) {
            //return file_get_contents("do something");
        }

        return raw_input_stream();
    }
}

/* ------------------------------- Loader Functions ---------------------------------*/

if ( ! function_exists('use_library')) 
{
    /**
     * Use a library/libraries and instantiate
     *
     * @param string|array $library
     * @param array $params
     * @param string $object_name
     * @return void
     */
    function use_library($library, $params = NULL, $object_name = NULL)
    {

        $library = with_dot($library);

        ci()->load->library($library, $params, $object_name);
    }
}

if ( ! function_exists('use_model')) 
{
    /**
     * Use a model/models and instantiate
     *
     * @param string|array $model
     * @param string $name
     * @param boolean $db_conn
     * @return void
     */
    function use_model($model, $name = '', $db_conn = false)
    {
        $model = with_dot($model);

        ci()->load->model($model, $name, $db_conn);
    }
}

if ( ! function_exists('use_helper')) 
{
    /**
     * Use a helper/helpers
     *
     * @param string|array $helper
     * @return void
     */
    function use_helper($helper): object
    {
        $helper = with_dot($helper);

        ci()->load->helper($helper);
    }
}

if ( ! function_exists('load_language')) 
{
    /**
     * load a language file 
     *
     * @param string $langfile
     * @param string $idiom
     * @param boolean $return
     * @param boolean $add_suffix
     * @param string $alt_path
     * @return void
     */
    function load_language($langfile, $idiom = '', $return = false, $add_suffix = true, $alt_path = '')
    {
        ci()->lang->load($langfile, $idiom, $return, $add_suffix, $alt_path);
    }
}

if ( ! function_exists('language')) 
{
    /**
     * specify a line to use 
     * from the language file
     *
     * @param string $line
     * @param boolean $log_errors
     * @return void
     */
    function language($line, $log_errors = true)
    {
        return ci()->lang->line($line, $log_errors);
    }
}
