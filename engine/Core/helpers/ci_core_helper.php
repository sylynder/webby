<?php
defined('COREPATH') or exit('No direct script access allowed');

/**
 *  CI_CORE Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah-Nti
 */

use Base\CodeIgniter\Instance;
use Base\Route\Route;

// -------------------------------------- Diety Functions ---------------------------

if ( ! function_exists('ci')) 
{
    /**
     * CodeIgniter Instance function
     * Powered with loading internal libraries
     * in an expressive manner
     * 
     * @param string $class
     * @param array $params
     * @return object CodeIgniter Instance
     */
    function ci(string $class = null, array $params = [])
    {
        if ($class === null) {
            return Instance::create();
        }

        //	Special cases 'user_agent' and 'unit_test' are loaded
		//	with diferent names
		if ($class !== 'user_agent') {
            $library = ($class == 'unit_test') ? 'unit' : $class;
		} else {
            $library = 'agent';
		}
        
        //	Library not loaded
		if ( ! isset(ci()->$library)) {
            
            //	Special case 'cache' is a driver
			if ($class == 'cache') {
				ci('load')->driver($class, $params);
            }
            
            // Let's guess it's a library
			ci('load')->library($class, $params);
        } 
        
        //	Special name for 'unit_test' is 'unit'
		if ($class == 'unit_test') {
			return ci()->unit;
		}
		//	Special name for 'user_agent' is 'agent'
        elseif ($class == 'user_agent') {
			return ci()->agent;
		}	
        
        if (! ends_with($class, '_model') || !ends_with($class, '_m')) {
			return ci()->$class;
		} else {
			$class = ($params == []) ? $class : $params ;
			return ci()->$class;
        }
    }
}

if ( ! function_exists('app')) 
{
     /**
      * Easy access to models, services and
      * libraries
      *
      * @param string $class
      * @param array $params
      * @return object 
      */
    function app(string $class = null, array $params = [])
    {

        if ($class === null) {
            return Instance::create();
        }
        
        $get_class = explode('/', has_dot($class));
        $class_type = count($get_class);

        $class_name = ($class_type == 2) ? $get_class[1]: $get_class[0];

        if (ends_with($class, '_model') || ends_with($class, '_m')) {
            
            use_model($class); // load model

            return ci()->{$class_name}; // return model object
        }

        if (contains('Model', $class)) {
            
            use_model($class); // load model

            return ci()->{$class_name}; // return model object
        }

        // let's assume it's a model without
        // the above conditions
        // If it does not exists we will load a library
        // Or discover it as a service
        // Not a good implementation but it works
        try {
            ci('load')->model(has_dot($class));
        } catch (Exception $e) {
            (!empty(ci()->{$class}) && is_object(ci()->{$class})) 
                ? ci()->{$class} 
                : ci('load')->library(has_dot($class));
        }

        if (!is_object(ci()->{$class_name})) {
            return ci(has_dot($class), $params);
        }
        
        return ci()->{$class_name};
    }
}

if ( ! function_exists('service')) {
    /**
     * Easy access to services
     *
     * @param string $class
     * @param string $alias
     * @param mixed $params
     * @return object
     */
    function service(string $class = '', string $alias = '', $params = [])
    {
        $get_class = explode('/', has_dot($class));

        $class_type = count($get_class);

        $class_name = ($class_type == 2) ? $get_class[1] : $get_class[0];
        
        if (contains('Service', $class)) {
            (!empty($alias)) ? use_service($class, $alias) : use_service($class);

            return (!empty($alias)) ? ci()->{$alias} : ci()->{$class_name};
        }

        $app_services = ci()->config->item('app_services');

        if (array_key_exists($class, $app_services)) {

            $class = isset($app_services[$class]) ? $app_services[$class] : [];

            return (is_object(new $class()))
                ? (!empty($params) ?: (new $class($params))) : (new $class());

        }

        $webby_services = ci()->config->item('webby_services');

        if (array_key_exists($class, $webby_services)) {
            
            $class = isset($webby_services[$class]) ? $webby_services[$class] : [];

            $class = has_dot($class);

            use_service($class, $class_name);

            return ci()->{$class_name};
        }

        (!empty($alias)) ? use_service($class_name, $alias) : use_service($class_name);

        return (!empty($alias)) ? ci()->{$alias} : ci()->{$class_name};

    }
}

if ( ! function_exists('env'))
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

        $env = new DotEnv(ROOTPATH);

        $value = $env->prepareVariable($value);

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
     * @return string
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
     * @return string
     */
    function url($uri = '', $param = '', $protocol = null)
    {
        $uri = is_array($uri) ? $uri : dot2slash($uri);

        if ($uri === 'void') {
            return void_url();
        }

        if (!empty($param) && $protocol === null) {
            return site_url($uri.'/'. $param);
        }

        return site_url($uri, $protocol);
    }
}

if ( ! function_exists('void_url')) 
{
    /**
     * A function that adds a void url
     *
     * @return string
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
     * @return string
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

if ( ! function_exists('is_active')) 
{
    /**
     * Use it to set active or current url for 
     * css classes. Default class name is (active)
     *
     * @param string $link
     * @param string $class
     * @return string
     */
    function is_active($link, $class = null)
    {
        $link = dot2slash($link);

        if ($class != null) {
            return ci()->uri->uri_string() == $link ? $class : '';
        }

        return ci()->uri->uri_string() == $link ? 'active' : '';
    }
}

if ( ! function_exists('active_link')) 
{
    /**
     * Alias for is_active
     *
     * @param string $link
     * @param string $class
     * @return string
     */
    function active_link($link, $class = null)
    {
        return is_active($link, $class);
    }
}

if ( ! function_exists('active_segment')) 
{
    /**
     * Use it to set active or current uri_segment for 
     * css classes. Default class name is (active)
     *
     * @param string $segment
     * @param string $segment_name
     * @param string $class
     * @return string
     */
    function active_segment(int $segment, string $segment_name, $class = 'active')
    {
        return uri_segment($segment) === $segment_name ? $class : '';
    }
}


if ( ! function_exists('uri_segment')) 
{
    /**
     * Alias for CodeIgniter's $this->uri->segment
     *
     * @param string $n
     * @param mixed $no_result
     * @return string
     */
    function uri_segment($n, $no_result = NULL)
    {
        return ci()->uri->segment($n, $no_result);
    }
}

if ( ! function_exists('go_back')) 
{
    /**
     * Go back using Html5 previous history
     * with a styled anchor tag
     * 
     * @param string $text
     * @param string $style
     * @return string
     */
    function go_back($text, $style = null)
    {
        echo '<a class="' . $style . '" href="javascript:window.history.go(-1);">' . $text . '</a>';
    }
}

if ( ! function_exists('html5_back')) 
{
    /**
     * Similar to go_back() function
     * 
     * To be used as link in href
     *
     * @return string
     */
    function html5_back()
    {
        return 'javascript:window.history.go(-1)';
    }
}

if ( ! function_exists('route')) 
{
    /**
     * @param string $uri 
     * @return object
     */
    function route($uri = '')
    {
        return (new Route())->setRoute($uri);
    }
}

if ( ! function_exists('route_to')) 
{
    /**
     * @param string $uri 
     * @return object
     */
    function route_to($uri = '')
    {
        return (new Route())->setRoute($uri)->redirect();
    }
}

if ( ! function_exists('current_route'))
{
    /**
     * Returns the current route
     *
     * @return string
     */
    function current_route()
    {
        return uri_string(); 
    }
}

/* ------------------------------- Request | Resource && User Agent Functions ---------------------------------*/

if ( ! function_exists('files')) 
{
    /**
     * function to get $_FILES values
     *
     * @param string $index
     * @return array|string
     */
    function files($index = '')
    {
        if ($index !== '') {
            return $_FILES[$index];
        }

        return $_FILES;
    }
}

if ( ! function_exists('has_file')) 
{
    /**
     * Check if file to upload is not empty
     *
     * @param string $file
     * @return boolean
     */
    function has_file($file)
    {
        return (empty($file['name']))
            ? false
            : true;
    }
}

if ( ! function_exists('is_file_empty')) 
{
    /**
     * Check if file is truely empty
     * 
     * expects $_FILES as $file
     * 
     * @param string $file
     * @return boolean
     */
    function is_file_empty($file)
    {
        return (empty($file['name']))
            ? true
            : false;
    }
}

if ( ! function_exists('input')) 
{
    /**
     * Function to set the input object
     *
     * @return CI_Input
     */
    function input()
    {
        return ci()->input;
    }
}

if ( ! function_exists('post')) 
{
    /**
     * Function to set only post methods
     *
     * @param string $index
     * @param bool $xss_clean
     * @return string|array
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
     * @return string|array
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
     * Fetch an item or all items 
     * from the SERVER array
     *
     * @param string $index
     * @param bool $xss_clean
     * @return string|array
     */
    function server($index = null, $xss_clean = null)
    {
        if(is_null($index)) {
            return $_SERVER;
        }

        return ci()->input->server($index, $xss_clean);
    }
}

if ( ! function_exists('ip_address')) 
{
    /**
     * Alias of IP Address Fetching from 
     * CodeIgniter's Input Class
     *
     * @return string
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
     * @return mixed
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
     * @return mixed
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

if ( ! function_exists('old')) 
{

    /**
     * Use it as an alias and fill in for 
     * CodeIgniter's set_value function
     *
     * @param	string	$field		Field name
     * @param	string	$default	Default value
     * @param	bool	$html_escape	Whether to escape HTML special characters or not
     * @return	string
     * 
     */
    function old($field, $default = '', $html_escape = true)
    {
        if (!empty(session('old')) && !empty(session('old')[$field])) {
            return session('old')[$field];
        }

        return set_value($field, $default, $html_escape);
    }
}

if ( ! function_exists('old_radio')) 
{

    /**
     * Use it as a fill in for 
     * CodeIgniter's set_radio function
     * when returning form validation 
     * with input fields in a session
     *
     * @param	string	$field	Field name
     * @param	string	$value	Field value
     * @return	string
     * 
     */
    function old_radio($field, $value = '')
    {
        if (!empty(session('old')) && !empty(session('old')[$field])) {
            $field = session('old')[$field];
        }

        return ($field == $value) ? 'checked=checked' : '';
    }
}

if ( ! function_exists('old_checkbox')) 
{

    /**
     * Use it as a fill in for 
     * CodeIgniter's set_checkbox function
     * when returning form validation 
     * with input fields in a session
     *
     * @param [type] $field
     * @param string $value
     * @param boolean $default
     * @return string
     */
    function old_checkbox($field, $value = '')
    {
        return old_radio($field, $value);
    }
}

if ( ! function_exists('selected')) 
{
    /**
     * Use it to compare values without 
     * CodeIgniter's set_select function
     *
     * @param string $existing_value
     * @param string $comparing_value
     * @return string
     */
    function selected($existing_value, $comparing_value)
    {
        return ($existing_value === $comparing_value) ? ' selected="selected"' : '';
    }
}

if ( ! function_exists('multi_selected')) 
{
    /**
     * Use it to compare values that have
     * multiple selected values
     * 
     * Preferrable when updating a form 
     *
     * @param string $existing_value
     * @param array $comparing_array_values
     * @return string
     */
    function multi_selected($existing_value, $comparing_array_values)
    {
        return in_array($existing_value, $comparing_array_values) ? ' selected="selected"' : '';
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
     * @return string
     */
    function verify_selected($existing_value, $comparing_value)
    {
        //Use it to compare values
        return ($existing_value === $comparing_value) ? true: false;
    }
}

if ( ! function_exists('validator')) 
{
    /**
     * Alias of CodeIgniter's $this->form_validation
     * 
     * @return object
     */
    function validator()
    {
        ci()->load->library('form_validation');
        return ci()->form_validation;
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
     * @return mixed
     */
    function validate($field, $label = '', $rules = [], $errors = null)
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
     * @return bool
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
     * @return mixed
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
     * @return array
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
     * @return mixed
     */
    function get_form_error($error_key)
    {
        $error_array = !empty(session('form_error')) ? session('form_error') : [];
        $error_array = array_merge(form_error_array(), $error_array);
        
        if (array_key_exists($error_key, $error_array)) {
            return $error_array[$error_key];
        }
        
        return '';
    }
}

if ( ! function_exists('set_error')) 
{
    /**
     * Sets form error on a 
     * named input field
     *
     * @param string $field
     * @param string $error
     * @return mixed
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
     * @return mixed
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
     * @param array $form_data
     * @return mixed
     */
    function set_form_data(array $form_data)
    {
        ci()->form_validation->set_data($form_data);
    }
}

/* ------------------------------- Loader Functions ---------------------------------*/

if ( ! function_exists('use_config')) 
{
    /**
     * Load a config file and instantiate
     *
     * @param string $config_file
     * @param bool $use_sections
     * @param bool $fail_gracefully
     * @return bool true if the file was loaded correctly or false on failure
     */
    function use_config(
        $config_file = '', 
        $use_sections = false, 
        $fail_gracefully = false
    ) {

        $config_file = has_dot($config_file);

        ci()->config->load($config_file, $use_sections, $fail_gracefully);
    }
}

if ( ! function_exists('use_package')) 
{
    /**
     * Use a package from a specific directory
     * and use it's available models, libraries etc
     * the codeigniter way
     *
     * @param string $path
     * @param string $file
     * @param bool $file_content
     * @param bool $view_cascade
     * @return void
     */
    function use_thirdparty($path, $file = '', $file_content = false, $view_cascade = true)
    {
        return ci()->load->thirdparty($path, $file, $file_content, $view_cascade);
    }
}

if ( ! function_exists('remove_thirdparty')) 
{
    /**
     * Remove a package from a Third Party directory
     * including it's available models, libraries etc
     * the codeigniter way
     *
     * @param string $path
     * @return void
     */
    function remove_thirdparty($path)
    {
        ci()->load->removeThirdparty($path);
    }
}

if ( ! function_exists('use_package')) 
{
    /**
     * Use a package from a specific directory
     * and use it's available models, libraries etc
     * the codeigniter way
     *
     * @param string $path
     * @param bool $view_cascade
     * @return void
     */
    function use_package($path, $view_cascade = true)
    {
        ci()->load->package($path, $view_cascade);
    }
}

if ( ! function_exists('remove_package')) 
{
    /**
     * Remove a package from a specific directory
     * including it's available models, libraries etc
     * the codeigniter way
     *
     * @param string $path
     * @return void
     */
    function remove_package($path)
    {
        ci()->load->removePackage($path);
    }
}

if ( ! function_exists('use_library')) 
{
    /**
     * Use a library/libraries and instantiate
     *
     * @param string|array $library
     * @param array $params
     * @param string $object_name
     * @return object
     */
    function use_library($library, $params = null, $object_name = null)
    {
        $library = has_dot($library);

        ci()->load->library($library, $params, $object_name);
    }
}

if ( ! function_exists('use_driver')) 
{
    /**
     * Use a driver/drivers and instantiate
     *
     * @param string|array $driver
     * @param array $params
     * @param string $object_name
     * @return object
     */
    function use_driver($driver, $params = null, $object_name = null)
    {
        $driver = has_dot($driver);

        ci()->load->driver($driver, $params, $object_name);
    }
}

if ( ! function_exists('use_service')) 
{
    /**
     * Use a service/services and instantiate
     *
     * @param string|array $service
     * @param array $params
     * @param string $object_name
     * @return object
     */
    function use_service($service, $object_name = null, $params = null)
    {
        $service = has_dot($service);

        ci()->load->service($service, $params, $object_name);
    }
}

if ( ! function_exists('use_services')) 
{
    /**
     * Discover services listed in
     * the service.php config file
     *
     * Only instantiate webby services and
     * not app services
     * 
     * @param array $classes
     * @return mixed
     */
    function use_services(array $classes = [])
    {

        $webby_services = ci()->config->item('webby_services');
        $app_services = ci()->config->item('app_services');

        $services = !empty($webby_services) ? $webby_services : [];

        if (!empty($classes) || !empty($app_services)) {
            $services = array_merge($services, $classes);
        }

        $keys = array_keys($services);
        $values = has_dot(array_values($services));
        $services = array_unique(array_combine($keys, $values));

        foreach ($services as $alias => $service) {
            service($service, $alias);
        }

        $services = array_merge($services, $app_services);

        return $services;
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
     * @return object
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
     * @return object
     */
    function use_helper($helper)
    {
        $helper = has_dot($helper);

        ci()->load->helper($helper);
    }
}

if ( ! function_exists('use_rule')) 
{
    /**
     * Use a rule
     * This function lets users load rules.
	 * That can be used when validating forms 
     * It is designed to be called from a user's app
	 * It can be used in controllers or models
     *
	 * @param string|array $rule
     * @param boolean $return_array
     * @return void
     */
    function use_rule($rule = [], $return_array = false)
    {
        $rule = has_dot($rule);

        ci()->load->rule($rule, $return_array);
    }
}

if ( ! function_exists('use_form')) 
{
    /**
     * Use a form
     * This function lets users load forms.
     * That can be used when validating forms 
     * 
     * It is designed to be called from a user's app
     * It can be used in controllers or models
     *
     * @param string|array $rule
     * @return void
     */
    function use_form($form = [])
    {
        $form = has_dot($form);

        ci()->load->form($form);
    }
}

if ( ! function_exists('rules')) 
{
    /**
     * Return available rules
     * Call this function when you load
     * files that use $rules array variable
     *
	 * @param string $rule
	 * @return mixed
     */
    function rules()
    {
        return !empty(ci()->load->rules) ? ci()->load->rules : [];
    }
}

if ( ! function_exists('use_language')) 
{
    /**
     * load a language file 
     *
     * @param string $langfile
     * @param string $idiom
     * @param boolean $return
     * @param boolean $add_suffix
     * @param string $alt_path
     * @return void|array
     */
    function use_language($langfile, $idiom = '', $return = false, $add_suffix = true, $alt_path = '')
    {
        ci()->lang->load($langfile, $idiom, $return, $add_suffix, $alt_path);
    }
}

if ( ! function_exists('trans')) 
{
    /**
     * specify a line to use 
     * from the language file
     *
     * @param string $line
     * @param boolean $log_errors
     * @return string
     */
    function trans($line, $log_errors = true)
    {
        return ci()->lang->line($line, $log_errors);
    }
}

if ( ! function_exists('__')) 
{
    /**
     * alias to the function above
     *
     * @param string $line
     * @param boolean $log_errors
     * @return string
     */
    function __($line, $log_errors = true)
    {
        return trans($line, $log_errors);
    }
}
