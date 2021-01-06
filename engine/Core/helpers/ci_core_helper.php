<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  CI_CORE Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah-Nti
 */

// ------------------------------------------------------------------------


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

if (! function_exists('env'))
{
	/**
	 * Allows user to retrieve values from the environment
	 * variables that have been set. Especially useful for
	 * retrieving values set from the .env file for
	 * use in config files.
	 *
	 * @param string $key
	 * @param null   $default
	 *
	 * @return mixed
	 */
	function env(string $key, $default = null)
	{
		$value = getenv($key);
		if ($value === false)
		{
			$value = $_ENV[$key] ?? $_SERVER[$key] ?? false;
		}

		// Not found? Return the default value
		if ($value === false)
		{
			return $default;
		}

		// Handle any boolean values
		switch (strtolower($value))
		{
			case 'true':
				return true;
			case 'false':
				return false;
			case 'empty':
				return '';
			case 'null':
				return null;
		}

		return $value;
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

if ( ! function_exists('is_active')) 
{
    /**
    * Use it to set active or current url for 
    * css classes. Default class name is (active)
    */
    function is_active($link, $class = null)
    {
        if ($class != null) {
            return ci()->uri->uri_string() == $link ? $class : '';
        } 
        
        return ci()->uri->uri_string() == $link ? 'active' : '';
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
     * @param string $index
     * @param bool $xss_clean
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

/* ------------------------------- Form Functions ---------------------------------*/

if ( ! function_exists('selected')) 
{
    /**
     * Use it to compare values without 
     * CodeIgniter's set_select function
     *
     * @param string $existing_value
     * @param string $comparing_value
     * @return void
     */
    function selected($existing_value, $comparing_value)
    {
        return ($existing_value === $comparing_value) ? ' selected="selected"' : '';
    }
}

if ( ! function_exists('verify_selected')) 
{
    /**
     * Works similarly as the above function
     * This time use it to compare values with CodeIgniter's 
     * set_select function as a third parameter 
     *
     * e.g set_select('field_name', 
     *           $value_to_compare, 
     *           verify_selected($value_to_compare , $compared_value)
     *       );      
     * 
     * @param string $existing_value
     * @param string $comparing_value
     * @return void
     */
    function verify_selected($existing_value, $comparing_value)
    {
        //Use it to compare values
        return ($existing_value === $comparing_value) ? true: false;
    }
}

if ( ! function_exists('validate')) 
{
    /**
     * Alias of CodeIgniter's 
     * $this->form_validation->set_rules
     *
     * @param string $field
     * @param string $label
     * @param string|array $rules
     * @param mixed $errors
     * @return void
     */
    function validate($field, $label = '', $rules, $errors = null)
    {
        ci()->form_validation->set_rules($field, $label, $rules, $errors);
    }
}

if ( ! function_exists('form_valid')) 
{
    /**
     * Checks if form is valid
     * Can use parameter ($rules) to specify a
     * an already given rules
     *
     * @param string $rules
     * @return void
     */
    function form_valid($rules = '')
    {
        return ci()->form_validation->run($rules);
    }
}

if ( ! function_exists('form_error_exists')) 
{
    /**
     * Checks if a form error exists
     *
     * @param string $input_field
     * @return void
     */
    function form_error_exists($input_field = null)
    {
        $error = form_error($input_field);
        $custom_error = get_form_error($input_field);

        if (is_null($input_field)) {
            return '';
        }

        if ( ! empty($error) ) {
            return true;
        }

        if (! empty($custom_error)) {
            return $custom_error;
        }

        return false;
    }
}

if ( ! function_exists('form_error_array')) 
{
    /**
     * Gets form errors in an array form
     *
     * @return void
     */
    function form_error_array()
    {
        return ci()->form_validation->error_array();
    }
}

if ( ! function_exists('get_form_error')) 
{
    /**
     * Retrieve a form error from
     * error array
     *
     * @param string $error_key
     * @return void
     */
    function get_form_error($error_key)
    {
        if (array_key_exists($error_key, form_error_array())) {
            return form_error_array()[$error_key];
        }
        
        return;
    }
}

if ( ! function_exists('set_error')) 
{
    /**
     * Sets form error on a 
     * named input field
     *
     * @param [type] $field
     * @param [type] $error
     * @return void
     */
    function set_error($field, $error)
    {
        ci()->form_validation->set_error($field, $error);
    }
}

if ( ! function_exists('set_error_delimeter')) 
{
    /**
     * Sets error delimeter to
     * be used when displaying errors
     *
     * @param string $open_tag
     * @param string $close_tag
     * @return void
     */
    function set_error_delimeter($open_tag = '', $close_tag = '')
    {
        ci()->form_validation->set_error_delimiters($open_tag, $close_tag);
    }
}

if ( ! function_exists('set_form_data')) 
{
    /**
     * Set form data
     *
     * @param string $form_data
     * @return void
     */
    function set_form_data($form_data)
    {
        // @Todo
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

        $library = has_dot($library);

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
        $model = has_dot($model);

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
        $helper = has_dot($helper);

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
