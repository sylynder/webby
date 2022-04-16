<?php 
defined('COREPATH') or exit('No direct script access allowed');

/* load the MX_Router class */
require_once ENGINEPATH . "/MX/Router.php";

class Base_Router extends MX_Router
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set the route mapping
     *
     * This function determines what should be served based on the URI request,
     * as well as any "routes" that have been set in the routing config file.
     *
     * @access   private
     * @return   void
     */
    public function _set_routing()
    {
        // Are query strings enabled in the config file?  Normally CI doesn't utilize query strings
        // since URI segments are more search-engine friendly, but they can optionally be used.
        // If this feature is enabled, we will gather the directory/class/method a little differently
        $segments = [];

        if ($this->config->item('enable_query_strings') === true and isset($_GET[$this->config->item('controller_trigger')])) {
            
            if (isset($_GET[$this->config->item('directory_trigger')])) {
                $this->set_directory(trim($this->uri->_filter_uri($_GET[$this->config->item('directory_trigger')])));
                $segments[] = $this->router->directory;
            }

            if (isset($_GET[$this->config->item('controller_trigger')])) {
                $this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));
                $segments[] = $this->router->class;
            }

            if (isset($_GET[$this->config->item('function_trigger')])) {
                $this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
                $segments[] = $this->router->method;
            }
        }

        // Load the routes.php file.
        if (defined('ENVIRONMENT') and is_file(COREPATH . 'config/' . ENVIRONMENT . '/routes.php')) {
            include(COREPATH . 'config/' . ENVIRONMENT . '/routes.php');
        } elseif (is_file(COREPATH . 'config/routes.php')) {
            include(COREPATH . 'config/routes.php');
        }

        // Include routes in every module
        $modules_locations = config_item('modules_locations') ? config_item('modules_locations') : false;

        if (!$modules_locations) {
            
            $modules_locations = COREPATH . 'modules/';

            if (is_dir($modules_locations)) {
                $modules_locations = [$modules_locations => '../modules/'];
            } else {
                show_error('Modules directory not found');
            }
        }

        foreach ($modules_locations as $key => $value) {
            
            if ($handle = opendir($key)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        if (is_dir($key . $entry)) {
                            $rfile = Modules::find('Routes' . EXT, $entry, 'Config/');

                            if ($rfile[0]) {
                                include($rfile[0] . $rfile[1]);
                            }
                        }
                    }
                }
                
                closedir($handle);
            }
        }

        $this->routes = (!isset($route) or !is_array($route)) ? [] : $route;
        unset($route);

        // Set the default controller so we can display it in the event
        // the URI doesn't correlated to a valid controller.
        $this->default_controller = (!isset($this->routes['default_controller']) or $this->routes['default_controller'] == '') ? false : strtolower($this->routes['default_controller']);

        // Were there any query string segments?  If so, we'll validate them and bail out since we're done.
        if (count($segments) > 0) {
            return $this->_validate_request($segments);
        }

        // Fetch the complete URI string
        $this->uri->uri_string();

        // Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
        if ($this->uri->uri_string == '') {
            return $this->_set_default_controller();
        }

        // Do we need to remove the URL suffix?
        $this->uri->slash_segment($this->uri->total_segments());

        // Compile the segments into an array
        $this->uri->segment_array();

        // Parse any custom routing that may exist
        $this->_parse_routes();

        // Re-index the segment array so that it starts with 1 rather than 0
        $this->uri->rsegment_array();
    }

    // --------------------------------------------------------------------

    /**
     * Parse Routes
     *
     * Matches any routes that may exist in the config/routes.php file
     * against the URI to determine if the class/method need to be remapped.
     *
     * @return	void
     */
    protected function _parse_routes()
    {
        // Turn the segment array into a URI string
        $uri = implode('/', $this->uri->segments);

        // Get HTTP verb
        $http_verb = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';

        // Loop through the route array looking for wildcards
        foreach ($this->routes as $key => $val) {
            // Check if route format is using HTTP verbs
            if (is_array($val)) {
                $val = array_change_key_case($val, CASE_LOWER);
                if (isset($val[$http_verb])) {
                    $val = $val[$http_verb];
                } else {
                    continue;
                }
            }

            // Check if named parameters exists
            $key = $this->namedParameter($key);

            // Convert wildcards to RegEx
            $key = str_replace(
                [':any', ':num', ':uuid', ':alphanum', ':alpha'],
                [
                    '[^/]+', 
                    '[0-9]+', 
                    '[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$',
                    '[a-zA-Z]+[a-zA-Z0-9._]+$',
                    '[a-zA-Z]+$'
                ], 
                $key
            );

            // Does the RegEx match?
            if (preg_match('#^' . $key . '$#', $uri, $matches)) {
                // Are we using callbacks to process back-references?
                if (!is_string($val) && is_callable($val)) {
                    // Remove the original string from the matches array.
                    array_shift($matches);

                    // Execute the callback using the values in matches as its parameters.
                    $val = call_user_func_array($val, $matches);
                }
                // Are we using the default routing method for back-references?
                elseif (strpos($val, '$') !== FALSE && strpos($key, '(') !== FALSE) {
                    $val = preg_replace('#^' . $key . '$#', $val, $uri);
                }

                $this->_set_request(explode('/', $val));
                return;
            }
        }

        // If we got this far it means we didn't encounter a
        // matching route so we'll set the site default route
        $this->_set_request(array_values($this->uri->segments));
    }

    /**
     * Convert {id} and {num} to :num OR {anytext} to :any
     *
     * @param string $key
     * @return string
     */
    private function namedParameter($key)
    {

        $key = str_replace('{id}', '(:num)', $key);
        $key = str_replace('{num}', '(:num)', $key);
        $key = str_replace('{uuid}', '(:uuid)', $key);
        $key = str_replace('{alpha}', '(:alpha)', $key);
        $key = str_replace('{alphanum}', '(:alphanum)', $key);

        $hasCurly = strpos($key, '{');
        $defaultKey = $key;

        $key = ($hasCurly && !(strpos($defaultKey, '{id}')))
                    ? preg_replace('/\{(.+?)\}/', '(:any)', $key)
                    : $key;

        return $key;
    }

}
/* end of file Base_Router.php */
