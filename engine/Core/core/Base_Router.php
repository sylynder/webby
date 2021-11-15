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
        $segments = array();

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

        // Include routes every modules
        $modules_locations = config_item('modules_locations') ? config_item('modules_locations') : false;

        if (!$modules_locations) {
            
            $modules_locations = COREPATH . 'modules/';

            if (is_dir($modules_locations)) {
                $modules_locations = array($modules_locations => '../modules/');
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

        $this->routes = (!isset($route) or !is_array($route)) ? array() : $route;
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
}
/* end of file Base_Router.php */
