<?php

namespace Base\Api;

use stdClass;
use Exception;
use Base\Helpers\Format;
use Base\Http\HttpStatus;
use Base\Controllers\Controller;

/**
 * CodeIgniter Api Server Controller
 * 
 * A fully REST Api server implementation for CodeIgniter3 
 * using one library, one config file and one controller.
 *
 * @link  https://github.com/chriskacerguis/ci-apiserver
 *
 * Note: Breaking modifications have been done to work with Webby
 * @since 4.0.0 
 * @author Kwame Oteng Appiah-Nti (Developer Kwame)
 * 
 */
class ApiServerController extends Controller
{
    /**
     * This defines the api format
     * Must be overridden in a controller 
     * so that it is set.
     *
     * @var string|null
     */
    protected $apiFormat = null;

    /**
     * Defines the list of method properties 
     * such as limit, log and level.
     *
     * @var array
     */
    protected $methods = [];

    /**
     * Defines https status.
     */
    protected $httpStatus = [];

    /**
     * List of allowed HTTP methods.
     *
     * @var array
     */
    protected $allowedHttpMethods = [
        'get',
        'delete',
        'post',
        'put',
        'options',
        'patch',
        'head'
    ];

    /**
     * Contains details about the request
     * Fields: body, format, method, ssl
     * Note: This is a dynamic object (stdClass).
     *
     * @var object
     */
    protected $request = null;

    /**
     * Contains details about the response
     * Fields: format, lang
     * Note: This is a dynamic object (stdClass).
     *
     * @var object
     */
    protected $response = null;

    /**
     * Contains details about the API
     * Fields: db, ignore_limits, key, level, user_id
     * Note: This is a dynamic object (stdClass).
     *
     * @var object
     */
    protected $api = null;

    /**
     * The arguments for the GET request method.
     *
     * @var array
     */
    protected $get_args = [];

    /**
     * The arguments for the POST request method.
     *
     * @var array
     */
    protected $post_args = [];

    /**
     * The arguments for the PUT request method.
     *
     * @var array
     */
    protected $put_args = [];

    /**
     * The arguments for the DELETE request method.
     *
     * @var array
     */
    protected $delete_args = [];

    /**
     * The arguments for the PATCH request method.
     *
     * @var array
     */
    protected $patch_args = [];

    /**
     * The arguments for the HEAD request method.
     *
     * @var array
     */
    protected $head_args = [];

    /**
     * The arguments for the OPTIONS request method.
     *
     * @var array
     */
    protected $options_args = [];

    /**
     * The arguments for the query parameters.
     *
     * @var array
     */
    protected $query_args = [];

    /**
     * The arguments from GET, POST, PUT, DELETE, PATCH, 
     * HEAD and OPTIONS request methods combined.
     *
     * @var array
     */
    protected $args = [];

    /**
     * The insertId of the log entry (if we have one).
     *
     * @var string
     */
    protected $insertId = '';

    /**
     * If the request is allowed based on the API key provided.
     *
     * @var bool
     */
    protected $allow = true;

    /**
     * The LDAP distinguished name of the User post authentication.
     *
     * @var string
     */
    protected $userLdapDn = '';

    /**
     * The start of the response time from the server.
     *
     * @var int|float|string
     */
    protected $start_rtime;

    /**
     * The end of the response time from the server.
     *
     * @var int|float|string
     */
    protected $end_rtime;

    /**
     * List all supported methods, the first will be the default format.
     *
     * @var array
     */
    protected $supportedFormats = [
        'json'       => 'application/json',
        'array'      => 'application/json',
        'csv'        => 'application/csv',
        'html'       => 'text/html',
        'jsonp'      => 'application/javascript',
        'php'        => 'text/plain',
        'serialized' => 'application/vnd.php.serialized',
        'xml'        => 'application/xml',
    ];

    /**
     * Information about the current API user.
     *
     * @var object
     */
    protected $apiUser;

    /**
     * Whether or not to perform a CORS check and apply CORS headers to the request.
     *
     * @var bool
     */
    protected $checkCors = null;

    /**
     * Enable XSS flag
     * Determines whether the XSS filter is always active when
     * GET, OPTIONS, HEAD, POST, PUT, DELETE and PATCH data is encountered
     * Set automatically based on config setting.
     *
     * @var bool
     */
    protected $enableXss = false;

    private $isValidRequest = true;

    /**
     * Common HTTP status codes and their respective description.
     *
     * @link http://www.apiapitutorial.com/httpstatuscodes.html
     */
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_INTERNAL_ERROR = 500;

    /**
     * @var Format
     */
    private $format;

    /**
     * @var bool
     */
    protected $authOverride;

    /**
     * Extend this function to apply additional checking early on in the process.
     *
     * @return void
     */
    protected function earlyChecks()
    {
    }

    /**
     * Constructor for the REST API.
     *
     * @param string $config Configuration filename minus the file extension
     *                       e.g: my_api.php is passed as 'my_api'
     */
    public function __construct($config = 'api')
    {
        parent::__construct();

        // Set the default value of global xss filtering. Same approach as CodeIgniter 3
        $this->enableXss = ($this->config->item('global_xss_filtering') === true);

        // Don't try to parse template variables like {elapsed_time} and {memory_usage}
        // when output is displayed for not damaging data accidentally
        $this->output->parse_exec_vars = false;

        // Load the api.php configuration file
        $this->getLocalConfig($config);

        // Log the loading time to the log table
        if ($this->config->item('api_enable_logging') === true) {
            // Start the timer for how long the request takes
            $this->start_rtime = microtime(true);
        }

        // Determine supported output formats from configuration
        $supportedFormats = $this->config->item('api_supported_formats');

        // Validate the configuration setting output formats
        if (empty($supportedFormats)) {
            $supportedFormats = [];
        }

        if (!is_array($supportedFormats)) {
            $supportedFormats = [$supportedFormats];
        }

        // Add silently the default output format if it is missing
        $defaultFormat = $this->getDefaultOutputFormat();
        if (!in_array($defaultFormat, $supportedFormats)) {
            $supportedFormats[] = $defaultFormat;
        }

        // Now update $this->supportedFormats
        $this->supportedFormats = array_intersect_key($this->supportedFormats, array_flip($supportedFormats));

        // Get the language
        $language = $this->config->item('api_language');

        if ($language === null) {
            $language = 'english';
        }

        // Load the language file
        $this->lang->load('api_controller', $language);

        // Initialise the response, request and api objects
        $this->request = new stdClass();
        $this->response = new stdClass();
        $this->api = new stdClass();

        // Check to see if the current IP address is blacklisted
        if ($this->config->item('api_ip_blacklist_enabled') === true) {
            $this->checkBlacklistAuth();
        }

        // Determine whether the connection is HTTPS
        $this->request->ssl = is_https();

        // How is this request being made? GET, POST, PATCH, DELETE, INSERT, PUT, HEAD or OPTIONS
        $this->request->method = $this->detectMethod();

        // Check for CORS access request
        $checkCors = $this->config->item('check_cors');
        if ($checkCors === true) {
            $this->checkCORS();
        }

        // Create an argument container if it doesn't exist e.g. get_args
        if (isset($this->{$this->request->method . '_args'}) === false) {
            $this->{$this->request->method . '_args'} = [];
        }

        // Set up the query parameters
        $this->parseQuery();

        // Set up the GET variables
        $this->get_args = array_merge($this->get_args, $this->uri->ruri_to_assoc());

        // Try to find a format for the request (means we have a request body)
        $this->request->format = $this->detectInputFormat();

        // Not all methods have a body attached with them
        $this->request->body = null;

        $this->{'parse' . ucfirst($this->request->method)}();

        // Fix parse method return arguments null
        if ($this->{$this->request->method . '_args'} === null) {
            $this->{$this->request->method . '_args'} = [];
        }

        // Which format should the data be returned in?
        $this->response->format = $this->detectOutputFormat();

        // Which language should the data be returned in?
        $this->response->lang = $this->detectLang();

        // Now we know all about our request, let's try and parse the body if it exists
        if ($this->request->format && $this->request->body) {
            $this->request->body = Format::factory($this->request->body, $this->request->format)->toArray();

            // Assign payload arguments to proper method container
            $this->{$this->request->method . '_args'} = $this->request->body;
        }

        //get header vars
        $this->head_args = $this->input->request_headers();

        // Merge both for one mega-args variable
        $this->args = array_merge(
            $this->get_args,
            $this->options_args,
            $this->patch_args,
            $this->head_args,
            $this->put_args,
            $this->post_args,
            $this->delete_args,
            $this->{$this->request->method . '_args'}
        );

        // Extend this function to apply additional checking early on in the process
        $this->earlyChecks();

        // Load DB if its enabled
        // Set database and enable any of these configurations
        if (
            $this->config->item('api_database_group') !== 'default'
            && $this->config->item('api_use_database')
            && ($this->config->item('api_enable_keys')
                || $this->config->item('api_enable_logging'))
            || $this->config->item('api_enable_token')
        ) {

            if ($this->config->item('api_database_path') === 'default') {
                $this->load->database();
                $this->api->db = $this->db;
            } else {
                list($module, $filename) = explode('/', $this->config->item('api_database_path'));
                $this->config->load($module . '/' . $filename, true);
                $config_name = $this->config->item($filename);
                $this->api->db = $this->load->database($config_name[$this->config->item('api_database_group')], true);
            }
        }
        // Use default database if that is set
        else if (
            $this->config->item('api_database_group') === 'default'
            && $this->config->item('api_use_database')
            && ($this->config->item('api_enable_keys')
                || $this->config->item('api_enable_logging'))
            || $this->config->item('api_enable_token')
        ) {
            $this->load->database();
            $this->api->db = $this->db;
        }
        // Set database to use it anyway
        // Please $this->useDatabase(); in your Controler
        else if ($this->config->item('api_use_database') === true && $this->config->item('api_database_group') === 'default') {
            $this->load->database();
            $this->api->db = $this->db;
        }

        // Check if there is a specific auth type for the current class/method
        // authOverrideCheck could exit so we need $this->api->db initialized before
        $this->authOverride = $this->authOverrideCheck();

        // Checking for keys? GET TO WorK!
        // Skip keys test for $config['auth_override_class_method']['class'['method'] = 'none'
        if ($this->config->item('api_enable_keys') && $this->authOverride !== true) {
            $this->allow = $this->detectApiKey();
        }

        // Only allow ajax requests
        if ($this->input->is_ajax_request() === false && $this->config->item('api_ajax_only')) {
            // Display an error response
            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_ajax_only'),
            ], HttpStatus::NOT_ACCEPTABLE);
        }

        // When there is no specific override for the current 
        // class/method, use the default auth value set in the config
        if (
            $this->authOverride === false &&
            (!($this->config->item('api_enable_keys') && $this->allow === true) ||
                ($this->config->item('allow_auth_and_keys') === true && $this->allow === true))
        ) {
            $apiAuth = strtolower($this->config->item('api_auth'));
            switch ($apiAuth) {
                case 'basic':
                    $this->prepareBasicAuth();
                    break;
                case 'digest':
                    $this->prepareDigestAuth();
                    break;
                case 'session':
                    $this->checkPhpSession();
                    break;
                case 'token':
                    $this->checkToken();
                    break;
            }
        }
    }

    /**
     * Does the auth stuff.
     */
    private function doAuth($method = false)
    {
        // If we don't want to do auth, then just return true
        if ($method === false) {
            return true;
        }

        if (file_exists(__DIR__ . '/auth/' . $method . '.php')) {
            include __DIR__ . '/auth/' . $method . '.php';
        }
    }

    /**
     * @param $configFile
     */
    private function getLocalConfig($configFile)
    {
        if (file_exists(ROOTPATH . 'config/' . $configFile . '.php')) {

            $configFile = ROOTPATH . 'config/' . $configFile . '.php';
        } else {
            if (file_exists(__DIR__ . '/' . $configFile . '.php')) {
                $config = [];
                include __DIR__ . '/' . $configFile . '.php';
                foreach ($config as $key => $value) {
                    $this->config->set_item($key, $value);
                }
            }
        }
    }

    /**
     * De-constructor.
     *
     * @author Chris Kacerguis
     *
     * @return void
     */
    public function __destruct()
    {
        // Log the loading time to the log table
        if ($this->config->item('api_enable_logging') === true) {
            // Get the current timestamp
            $this->end_rtime = microtime(true);

            $this->logAccessTime();
        }
    }

    /**
     * Requests are not made to methods directly, the request will be for
     * an "object". This simply maps the object and method to the correct
     * Controller method.
     *
     * @param string $objectCalled
     * @param array  $arguments     The arguments passed to the controller method
     *
     * @throws Exception
     */
    public function _remap($object_called, $arguments = [])
    {
        // Should we answer if not over SSL?
        if ($this->config->item('force_https') && $this->request->ssl === false) {
            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_unsupported'),
            ], HttpStatus::FORBIDDEN);
        }

        // Remove the supported format from the function name e.g. index.json => index
        $object_called = preg_replace('/^(.*)\.(?:' . implode('|', array_keys($this->supportedFormats)) . ')$/', '$1', $object_called);

        $controllerMethod = $object_called . '_' . $this->request->method;
        // Does this method exist? If not, try executing an index method
        if (!method_exists($this, $controllerMethod)) {
            $controllerMethod = 'index_' . $this->request->method;
            array_unshift($arguments, $object_called);
        }

        // Do we want to log this method (if allowed by config)?
        $log_method = !(isset($this->methods[$controllerMethod]['log']) && $this->methods[$controllerMethod]['log'] === false);

        // Use keys for this method?
        $use_key = !(isset($this->methods[$controllerMethod]['key']) && $this->methods[$controllerMethod]['key'] === false);

        // They provided a key, but it wasn't valid, so get them out of here
        if ($this->config->item('api_enable_keys') && $use_key && $this->allow === false) {
            if ($this->config->item('api_enable_logging') && $log_method) {
                $this->logRequest();
            }

            // fix cross site to option request error
            if ($this->request->method == 'options') {
                exit;
            }

            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => sprintf($this->lang->line('text_invalid_api_key'), $this->api->key),
            ], HttpStatus::FORBIDDEN);
        }

        // Check to see if this key has access to the requested controller
        if ($this->config->item('api_enable_keys') && $use_key && empty($this->api->key) === false && $this->checkAccess() === false) {
            if ($this->config->item('api_enable_logging') && $log_method) {
                $this->logRequest();
            }

            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_key_unauthorized'),
            ], HttpStatus::UNAUTHORIZED);
        }

        // Sure it exists, but can they do anything with it?
        if (!method_exists($this, $controllerMethod)) {
            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_unknown_method'),
            ], HttpStatus::METHOD_NOT_ALLOWED);
        }

        // Doing key related stuff? Can only do it if they have a key right?
        if ($this->config->item('api_enable_keys') && empty($this->api->key) === false) {
            // Check the limit
            if ($this->config->item('api_enable_limits') && $this->checkLimit($controllerMethod) === false) {
                $response = [$this->config->item('api_status_field_name') => false, $this->config->item('api_message_field_name') => $this->lang->line('text_api_key_time_limit')];
                $this->response($response, HttpStatus::UNAUTHORIZED);
            }

            // If no level is set use 0, they probably aren't using permissions
            $level = isset($this->methods[$controllerMethod]['level']) ? $this->methods[$controllerMethod]['level'] : 0;

            // If no level is set, or it is lower than/equal to the key's level
            $authorized = $level <= $this->api->level;
            // IM TELLIN!
            if ($this->config->item('api_enable_logging') && $log_method) {
                $this->logRequest($authorized);
            }
            if ($authorized === false) {
                // They don't have good enough perms
                $response = [$this->config->item('api_status_field_name') => false, $this->config->item('api_message_field_name') => $this->lang->line('text_api_key_permissions')];
                $this->response($response, HttpStatus::UNAUTHORIZED);
            }
        }

        //check request limit by ip without login
        elseif ($this->config->item('api_limits_method') == 'IP_ADDRESS' && $this->config->item('api_enable_limits') && $this->checkLimit($controllerMethod) === false) {
            $response = [$this->config->item('api_status_field_name') => false, $this->config->item('api_message_field_name') => $this->lang->line('text_api_ip_address_time_limit')];
            $this->response($response, HttpStatus::UNAUTHORIZED);
        }

        // No key stuff, but record that stuff is happening
        elseif ($this->config->item('api_enable_logging') && $log_method) {
            $this->logRequest($authorized = true);
        }

        // Call the controller method and passed arguments
        try {
            if ($this->isValidRequest) {
                call_user_func_array([$this, $controllerMethod], $arguments);
            }
        } catch (Exception $ex) {
            if ($this->config->item('api_handle_exceptions') === false) {
                throw $ex;
            }

            // If the method doesn't exist, then the error will be caught and an error response shown
            $_error = &load_class('Exceptions', 'core');
            $_error->show_exception($ex);
        }
    }

    /**
     * Takes mixed data and optionally a status code, then creates the response.
     *
     * @param array|null $data      Data to output to the user
     * @param int|null   $httpCode HTTP status code
     * @param bool       $continue  true to flush the response to the client and continue
     *                              running the script; otherwise, exit
     */
    public function response($data = null, $httpCode = null, $continue = false)
    {
        //if profiling enabled then print profiling data
        $isProfilingEnabled = $this->config->item('enable_profiling');
        if (!$isProfilingEnabled) {
            ob_start();
            // If the HTTP status is not NULL, then cast as an integer
            if ($httpCode !== null) {
                // So as to be safe later on in the process
                $httpCode = (int) $httpCode;
            }

            // Set the output as NULL by default
            $output = null;

            // If data is NULL and no HTTP status code provided, then display, error and exit
            if ($data === null && $httpCode === null) {
                $httpCode = HttpStatus::NOT_FOUND;
            }

            // If data is not NULL and a HTTP status code provided, then continue
            elseif ($data !== null) {

                $types = ['php, json, csv, xml, html'];

                $responseFormat = in_array($this->response->format, $types)
                    ? strtoupper($this->response->format)
                    : ucfirst($this->response->format);

                // If the format method exists, call and return the output in that format
                if (method_exists(Format::class, 'to' . $responseFormat)) {
                    // CORB protection
                    // First, get the output content.
                    $output = Format::factory($data)->{'to' . $responseFormat}();

                    // Set the format header
                    // Then, check if the client asked for a callback, and if the output contains this callback :
                    if (isset($this->get_args['callback']) && $this->response->format == 'json' && preg_match('/^' . $this->get_args['callback'] . '/', $output)) {
                        $this->output->set_content_type($this->supportedFormats['jsonp'], strtolower($this->config->item('charset')));
                    } else {
                        $this->output->set_content_type($this->supportedFormats[$this->response->format], strtolower($this->config->item('charset')));
                    }

                    // An array must be parsed as a string, so as not to cause an array to string error
                    // Json is the most appropriate form for such a data type
                    if ($this->response->format === 'array') {
                        $output = Format::factory($output)->{'toJSON'}();
                    }
                } else {
                    // If an array or object, then parse as a json, so as to be a 'string'
                    if (is_array($data) || is_object($data)) {
                        $data = Format::factory($data)->{'toJSON'}();
                    }

                    // Format is not supported, so output the raw data as a string
                    $output = $data;
                }
            }

            // If not greater than zero, then set the HTTP status code as 200 by default
            // Though perhaps 500 should be set instead, for the developer not passing a
            // correct HTTP status code
            $httpCode > 0 || $httpCode = HttpStatus::OK;

            $this->output->set_status_header($httpCode);

            // JC: Log response code only if api logging enabled
            if ($this->config->item('api_enable_logging') === true) {
                $this->logResponseCode($httpCode);
            }

            // Output the data
            $this->output->set_output($output);

            if ($continue === false) {
                // Display the data and exit execution
                $this->output->_display();
                exit;
            } else {
                if (is_callable('fastcgi_finish_request')) {
                    // Terminates connection and returns response to client on PHP-FPM.
                    $this->output->_display();
                    ob_end_flush();
                    fastcgi_finish_request();
                    ignore_user_abort(true);
                } else {
                    // Legacy compatibility.
                    ob_end_flush();
                }
            }
            ob_end_flush();
            // Otherwise dump the output automatically
        } else {
            echo json_encode($data);
        }
    }

    /**
     * Takes mixed data and optionally a status code, then creates the response
     * within the buffers of the Output class. The response is sent to the client
     * lately by the framework, after the current controller's method termination.
     * All the hooks after the controller's method termination are executable.
     *
     * @param array|null $data      Data to output to the user
     * @param int|null   $httpCode HTTP status code
     */
    public function setResponse($data = null, $httpCode = null)
    {
        $this->response($data, $httpCode, true);
    }

    /**
     * Get the input format e.g. json or xml.
     *
     * @return string|null Supported input format; otherwise, NULL
     */
    protected function detectInputFormat()
    {
        // Get the CONTENT-TYPE value from the SERVER variable
        $contentType = $this->input->server('CONTENT_TYPE');

        if (empty($contentType) === false) {
            // If a semi-colon exists in the string, then explode by ; and get the value of where
            // the current array pointer resides. This will generally be the first element of the array
            $contentType = (strpos($contentType, ';') !== false ? current(explode(';', $contentType)) : $contentType);

            // Check all formats against the CONTENT-TYPE header
            foreach ($this->supportedFormats as $type => $mime) {
                // $type = format e.g. csv
                // $mime = mime type e.g. application/csv

                // If both the mime types match, then return the format
                if ($contentType === $mime) {
                    return $type;
                }
            }
        }
    }

    /**
     * Gets the default format from the configuration. Fallbacks to 'json'
     * if the corresponding configuration option $config['api_default_format']
     * is missing or is empty.
     *
     * @return string The default supported input format
     */
    protected function getDefaultOutputFormat()
    {
        $defaultFormat = (string) $this->config->item('api_default_format');

        return $defaultFormat === '' ? 'json' : $defaultFormat;
    }

    /**
     * Detect which format should be used to output the data.
     *
     * @return mixed|null|string Output format
     */
    protected function detectOutputFormat()
    {
        // Concatenate formats to a regex pattern e.g. \.(csv|json|xml)
        $pattern = '/\.(' . implode('|', array_keys($this->supportedFormats)) . ')($|\/)/';
        $matches = [];

        // Check if a file extension is used e.g. http://example.com/api/index.json?param1=param2
        if (preg_match($pattern, $this->uri->uri_string(), $matches)) {
            return $matches[1];
        }

        // Get the format parameter named as 'format'
        if (isset($this->get_args['format'])) {
            $format = strtolower($this->get_args['format']);

            if (isset($this->supportedFormats[$format]) === true) {
                return $format;
            }
        }

        // Get the HTTP_ACCEPT server variable
        $httpAccept = $this->input->server('HTTP_ACCEPT');

        // Otherwise, check the HTTP_ACCEPT server variable
        if ($this->config->item('api_ignore_http_accept') === false && $httpAccept !== null) {
            // Check all formats against the HTTP_ACCEPT header
            foreach (array_keys($this->supportedFormats) as $format) {
                // Has this format been requested?
                if (strpos($httpAccept, $format) !== false) {
                    if ($format !== 'html' && $format !== 'xml') {
                        // If not HTML or XML assume it's correct
                        return $format;
                    } elseif ($format === 'html' && strpos($httpAccept, 'xml') === false) {
                        // HTML or XML have shown up as a match
                        // If it is truly HTML, it wont want any XML
                        return $format;
                    } elseif ($format === 'xml' && strpos($httpAccept, 'html') === false) {
                        // If it is truly XML, it wont want any HTML
                        return $format;
                    }
                }
            }
        }

        // Check if the controller has a default format
        if (empty($this->apiFormat) === false) {
            return $this->apiFormat;
        }

        // Obtain the default format from the configuration
        return $this->getDefaultOutputFormat();
    }

    /**
     * Get the HTTP request string e.g. get or post.
     *
     * @return string|null Supported request method as a lowercase string; otherwise, NULL if not supported
     */
    protected function detectMethod()
    {
        // Declare a variable to store the method
        $method = null;

        // Determine whether the 'enable_emulate_request' setting is enabled
        if ($this->config->item('enable_emulate_request') === true) {
            $method = $this->input->post('_method');
            if ($method === null) {
                $method = $this->input->server('HTTP_X_HTTP_METHOD_OVERRIDE');
            }

            if ($method !== null) {
                $method = strtolower($method);
            }
        }

        if (empty($method)) {
            // Get the request method as a lowercase string
            $method = $this->input->method();
        }

        return in_array($method, $this->allowedHttpMethods) && method_exists($this, 'parse' . ucfirst($method)) ? $method : 'get';
    }

    /**
     * See if the user has provided an API key.
     *
     * @return bool
     */
    protected function detectApiKey()
    {
        // Get the api key name variable set in the api config file
        $apiKeyVariable = $this->config->item('api_key_name');

        // Work out the name of the SERVER entry based on config
        $keyName = 'HTTP_' . strtoupper(str_replace('-', '_', $apiKeyVariable));

        $this->api->key = null;
        $this->api->level = null;
        $this->api->user_id = null;
        $this->api->ignore_limits = false;

        // Find the key from server or arguments
        if (($key = isset($this->args[$apiKeyVariable]) ? $this->args[$apiKeyVariable] : $this->input->server($keyName))) {
            if (!($row = $this->api->db->where($this->config->item('api_key_column'), $key)->get($this->config->item('api_keys_table'))->row())) {
                return false;
            }

            $this->api->key = $row->{$this->config->item('api_key_column')};

            isset($row->user_id) && $this->api->user_id = $row->user_id;
            isset($row->level) && $this->api->level = $row->level;
            isset($row->ignore_limits) && $this->api->ignore_limits = $row->ignore_limits;

            $this->apiUser = $row;

            /*
             * If "is private key" is enabled, compare the ip address with the list
             * of valid ip addresses stored in the database
             */
            if (empty($row->is_private_key) === false) {
                // Check for a list of valid ip addresses
                if (isset($row->ip_addresses)) {
                    // multiple ip addresses must be separated using a comma, explode and loop
                    $listIpAddresses = explode(',', $row->ip_addresses);
                    $ipAddress = $this->input->ip_address();
                    $foundAddress = false;

                    foreach ($listIpAddresses as $listIp) {
                        if ($ipAddress === trim($listIp)) {
                            // there is a match, set the the value to true and break out of the loop
                            $foundAddress = true;
                            break;
                        }
                    }

                    return $foundAddress;
                } else {
                    // There should be at least one IP address for this private key
                    return false;
                }
            }

            return true;
        }

        // No key has been sent
        return false;
    }

    /**
     * Preferred return language.
     *
     * @return string|null|array The language code
     */
    protected function detectLang()
    {
        $lang = $this->input->server('HTTP_ACCEPT_LANGUAGE');
        if ($lang === null) {
            return;
        }

        // It appears more than one language has been sent using a comma delimiter
        if (strpos($lang, ',') !== false) {
            $langs = explode(',', $lang);

            $returnLangs = [];
            foreach ($langs as $lang) {
                // Remove weight and trim leading and trailing whitespace
                list($lang) = explode(';', $lang);
                $returnLangs[] = trim($lang);
            }

            return $returnLangs;
        }

        // Otherwise simply return as a string
        return $lang;
    }

    /**
     * Add the request to the log table.
     *
     * @param bool $authorized true the user is authorized; otherwise, false
     *
     * @return bool true the data was inserted; otherwise, false
     */
    protected function logRequest($authorized = false)
    {
        // Insert the request into the log table
        $isInserted = $this->api->db
            ->insert(
                $this->config->item('api_logs_table'),
                [
                    'uri'        => $this->uri->uri_string(),
                    'method'     => $this->request->method,
                    'params'     => $this->args ? ($this->config->item('api_logs_json_params') === true ? json_encode($this->args) : serialize($this->args)) : null,
                    'api_key'    => isset($this->api->key) ? $this->api->key : '',
                    'ip_address' => $this->input->ip_address(),
                    'time'       => time(),
                    'authorized' => $authorized,
                ]
            );

        // Get the last insert id to update at a later stage of the request
        $this->insertId = $this->api->db->insert_id();

        return $isInserted;
    }

    /**
     * Check if the requests to a controller method exceed a limit.
     *
     * @param string $controllerMethod The method being called
     *
     * @return bool true the call limit is below the threshold; otherwise, false
     */
    protected function checkLimit($controllerMethod)
    {
        // They are special, or it might not even have a limit
        if (empty($this->api->ignore_limits) === false) {
            // Everything is fine
            return true;
        }

        $apiKey = isset($this->api->key) ? $this->api->key : '';

        switch ($this->config->item('api_limits_method')) {
            case 'IP_ADDRESS':
                $apiKey = $this->input->ip_address();
                $limitedUri = 'ip-address:' . $apiKey;
                break;

            case 'API_KEY':
                $limitedUri = 'api-key:' . $apiKey;
                break;

            case 'METHOD_NAME':
                $limitedUri = 'method-name:' . $controllerMethod;
                break;

            case 'ROUTED_URL':
            default:
                $limitedUri = $this->uri->ruri_string();
                if (strpos(strrev($limitedUri), strrev($this->response->format)) === 0) {
                    $limitedUri = substr($limitedUri, 0, -strlen($this->response->format) - 1);
                }
                $limitedUri = 'uri:' . $limitedUri . ':' . $this->request->method; // It's good to differentiate GET from PUT
                break;
        }

        if (isset($this->methods[$controllerMethod]['limit']) === false) {
            // Everything is fine
            return true;
        }

        // How many times can you get to this method in a defined timeLimit (default: 1 hour)?
        $limit = $this->methods[$controllerMethod]['limit'];

        $timeLimit = (isset($this->methods[$controllerMethod]['time']) ? $this->methods[$controllerMethod]['time'] : 3600); // 3600 = 60 * 60

        // Get data about a keys' usage and limit to one row
        $result = $this->api->db
            ->where('uri', $limitedUri)
            ->where('api_key', $apiKey)
            ->get($this->config->item('api_limits_table'))
            ->row();

        // No calls have been made for this key
        if ($result === null) {
            // Create a new row for the following key
            $this->api->db->insert($this->config->item('api_limits_table'), [
                'uri'          => $limitedUri,
                'api_key'      => $apiKey,
                'count'        => 1,
                'hour_started' => time(),
            ]);
        }

        // Been a time limit (or by default an hour) since they called
        elseif ($result->hour_started < (time() - $timeLimit)) {
            // Reset the started period and count
            $this->api->db
                ->where('uri', $limitedUri)
                ->where('api_key', $apiKey)
                ->set('hour_started', time())
                ->set('count', 1)
                ->update($this->config->item('api_limits_table'));
        }

        // They have called within the hour, so lets update
        else {
            // The limit has been exceeded
            if ($result->count >= $limit) {
                return false;
            }

            // Increase the count by one
            $this->api->db
                ->where('uri', $limitedUri)
                ->where('api_key', $apiKey)
                ->set('count', 'count + 1', false)
                ->update($this->config->item('api_limits_table'));
        }

        return true;
    }

    /**
     * Check if there is a specific auth type set for the current class/method/HTTP-method being called.
     *
     * @return bool
     */
    protected function authOverrideCheck()
    {
        // Assign the class/method auth type override array from the config
        $authOverrideClassMethod = $this->config->item('auth_override_class_method');

        // Check to see if the override array is even populated
        if (!empty($authOverrideClassMethod)) {
            // Check for wildcard flag for rules for classes
            if (!empty($authOverrideClassMethod[$this->router->class]['*'])) { // Check for class overrides
                // No auth override found, prepare nothing but send back a true override flag
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'none') {
                    return true;
                }

                // Basic auth override found, prepare basic
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'basic') {
                    $this->prepareBasicAuth();

                    return true;
                }

                // Digest auth override found, prepare digest
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'digest') {
                    $this->prepareDigestAuth();

                    return true;
                }

                // Session auth override found, check session
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'session') {
                    $this->checkPhpSession();

                    return true;
                }

                // Token auth override found, check token
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'token') {
                    $this->checkToken();

                    return true;
                }

                // Whitelist auth override found, check client's ip against config whitelist
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'whitelist') {
                    $this->checkWhitelistAuth();

                    return true;
                }
            }

            // Check to see if there's an override value set for the current class/method being called
            if (!empty($authOverrideClassMethod[$this->router->class][$this->router->method])) {
                // None auth override found, prepare nothing but send back a true override flag
                if ($authOverrideClassMethod[$this->router->class][$this->router->method] === 'none') {
                    return true;
                }

                // Basic auth override found, prepare basic
                if ($authOverrideClassMethod[$this->router->class][$this->router->method] === 'basic') {
                    $this->prepareBasicAuth();

                    return true;
                }

                // Digest auth override found, prepare digest
                if ($authOverrideClassMethod[$this->router->class][$this->router->method] === 'digest') {
                    $this->prepareDigestAuth();

                    return true;
                }

                // Session auth override found, check session
                if ($authOverrideClassMethod[$this->router->class][$this->router->method] === 'session') {
                    $this->checkPhpSession();

                    return true;
                }

                // Token auth override found, check token
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'token') {
                    $this->checkToken();

                    return true;
                }

                // Whitelist auth override found, check client's ip against config whitelist
                if ($authOverrideClassMethod[$this->router->class][$this->router->method] === 'whitelist') {
                    $this->checkWhitelistAuth();

                    return true;
                }
            }
        }

        // Assign the class/method/HTTP-method auth type override array from the config
        $authOverrideClassMethodHttp = $this->config->item('auth_override_class_method_http');

        // Check to see if the override array is even populated
        if (!empty($authOverrideClassMethodHttp)) {
            // check for wildcard flag for rules for classes
            if (!empty($authOverrideClassMethodHttp[$this->router->class]['*'][$this->request->method])) {
                // None auth override found, prepare nothing but send back a true override flag
                if ($authOverrideClassMethodHttp[$this->router->class]['*'][$this->request->method] === 'none') {
                    return true;
                }

                // Basic auth override found, prepare basic
                if ($authOverrideClassMethodHttp[$this->router->class]['*'][$this->request->method] === 'basic') {
                    $this->prepareBasicAuth();

                    return true;
                }

                // Digest auth override found, prepare digest
                if ($authOverrideClassMethodHttp[$this->router->class]['*'][$this->request->method] === 'digest') {
                    $this->prepareDigestAuth();

                    return true;
                }

                // Session auth override found, check session
                if ($authOverrideClassMethodHttp[$this->router->class]['*'][$this->request->method] === 'session') {
                    $this->checkPhpSession();

                    return true;
                }

                // Token auth override found, check token
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'token') {
                    $this->checkToken();

                    return true;
                }

                // Whitelist auth override found, check client's ip against config whitelist
                if ($authOverrideClassMethodHttp[$this->router->class]['*'][$this->request->method] === 'whitelist') {
                    $this->checkWhitelistAuth();

                    return true;
                }
            }

            // Check to see if there's an override value set for the current class/method/HTTP-method being called
            if (!empty($authOverrideClassMethodHttp[$this->router->class][$this->router->method][$this->request->method])) {
                // None auth override found, prepare nothing but send back a true override flag
                if ($authOverrideClassMethodHttp[$this->router->class][$this->router->method][$this->request->method] === 'none') {
                    return true;
                }

                // Basic auth override found, prepare basic
                if ($authOverrideClassMethodHttp[$this->router->class][$this->router->method][$this->request->method] === 'basic') {
                    $this->prepareBasicAuth();

                    return true;
                }

                // Digest auth override found, prepare digest
                if ($authOverrideClassMethodHttp[$this->router->class][$this->router->method][$this->request->method] === 'digest') {
                    $this->prepareDigestAuth();

                    return true;
                }

                // Session auth override found, check session
                if ($authOverrideClassMethodHttp[$this->router->class][$this->router->method][$this->request->method] === 'session') {
                    $this->checkPhpSession();

                    return true;
                }

                // Token auth override found, check token
                if ($authOverrideClassMethod[$this->router->class]['*'] === 'token') {
                    $this->checkToken();

                    return true;
                }

                // Whitelist auth override found, check client's ip against config whitelist
                if ($authOverrideClassMethodHttp[$this->router->class][$this->router->method][$this->request->method] === 'whitelist') {
                    $this->checkWhitelistAuth();

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Parse the GET request arguments.
     *
     * @return void
     */
    protected function parseGet()
    {
        // Merge both the URI segments and query parameters
        $this->get_args = array_merge($this->get_args, $this->query_args);
    }

    /**
     * Parse the POST request arguments.
     *
     * @return void
     */
    protected function parsePost()
    {
        $this->post_args = $_POST;

        if ($this->request->format) {
            $this->request->body = $this->input->raw_input_stream;
        }
    }

    /**
     * Parse the PUT request arguments.
     *
     * @return void
     */
    protected function parsePut()
    {
        if ($this->request->format) {
            $this->request->body = $this->input->raw_input_stream;
            if ($this->request->format === 'json') {
                $this->put_args = json_decode($this->input->raw_input_stream);
            }
        } elseif ($this->input->method() === 'put') {
            // If no file type is provided, then there are probably just arguments
            $this->put_args = $this->input->input_stream();
        }
    }

    /**
     * Parse the HEAD request arguments.
     *
     * @return void
     */
    protected function parseHead()
    {
        // Parse the HEAD variables
        parse_str(parse_url($this->input->server('REQUEST_URI'), PHP_URL_QUERY), $head);

        // Merge both the URI segments and HEAD params
        $this->head_args = array_merge($this->head_args, $head);
    }

    /**
     * Parse the OPTIONS request arguments.
     *
     * @return void
     */
    protected function parseOptions()
    {
        // Parse the OPTIONS variables
        parse_str(parse_url($this->input->server('REQUEST_URI'), PHP_URL_QUERY), $options);

        // Merge both the URI segments and OPTIONS params
        $this->options_args = array_merge($this->options_args, $options);
    }

    /**
     * Parse the PATCH request arguments.
     *
     * @return void
     */
    protected function parsePatch()
    {
        // It might be a HTTP body
        if ($this->request->format) {
            $this->request->body = $this->input->raw_input_stream;
        } elseif ($this->input->method() === 'patch') {
            // If no file type is provided, then there are probably just arguments
            $this->patch_args = $this->input->input_stream();
        }
    }

    /**
     * Parse the DELETE request arguments.
     *
     * @return void
     */
    protected function parseDelete()
    {
        // These should exist if a DELETE request
        if ($this->input->method() === 'delete') {
            $this->delete_args = $this->input->input_stream();
        }
    }

    /**
     * Parse the query parameters.
     *
     * @return void
     */
    protected function parseQuery()
    {
        $this->query_args = $this->input->get();
    }

    // INPUT FUNCTION --------------------------------------------------------------

    /**
     * Retrieve a value from a GET request.
     *
     * @param null $key       Key to retrieve from the GET request
     *                        If NULL an array of arguments is returned
     * @param null $xss_clean Whether to apply XSS filtering
     *
     * @return array|string|null Value from the GET request; otherwise, NULL
     */
    public function get($key = null, $xss_clean = null)
    {
        if ($key === null) {
            return $this->get_args;
        }

        return isset($this->get_args[$key]) ? $this->xssClean($this->get_args[$key], $xss_clean) : null;
    }

    /**
     * Retrieve a value from a OPTIONS request.
     *
     * @param null $key       Key to retrieve from the OPTIONS request.
     *                        If NULL an array of arguments is returned
     * @param null $xss_clean Whether to apply XSS filtering
     *
     * @return array|string|null Value from the OPTIONS request; otherwise, NULL
     */
    public function options($key = null, $xss_clean = null)
    {
        if ($key === null) {
            return $this->options_args;
        }

        return isset($this->options_args[$key]) ? $this->xssClean($this->options_args[$key], $xss_clean) : null;
    }

    /**
     * Retrieve a value from a HEAD request.
     *
     * @param null $key       Key to retrieve from the HEAD request
     *                        If NULL an array of arguments is returned
     * @param null $xss_clean Whether to apply XSS filtering
     *
     * @return array|string|null Value from the HEAD request; otherwise, NULL
     */
    public function head($key = null, $xss_clean = null)
    {
        if ($key === null) {
            return $this->head_args;
        }

        return isset($this->head_args[$key]) ? $this->xssClean($this->head_args[$key], $xss_clean) : null;
    }

    /**
     * Retrieve a value from a POST request.
     *
     * @param null $key       Key to retrieve from the POST request
     *                        If NULL an array of arguments is returned
     * @param null $xss_clean Whether to apply XSS filtering
     *
     * @return array|string|null Value from the POST request; otherwise, NULL
     */
    public function post($key = null, $xss_clean = null)
    {
        if ($key === null) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->post_args), \RecursiveIteratorIterator::CATCH_GET_CHILD) as $key => $value) {
                $this->post_args[$key] = $this->xssClean($this->post_args[$key], $xss_clean);
            }

            return $this->post_args;
        }

        return isset($this->post_args[$key]) ? $this->xssClean($this->post_args[$key], $xss_clean) : null;
    }

    /**
     * Retrieve a value from a PUT request.
     *
     * @param null $key       Key to retrieve from the PUT request
     *                        If NULL an array of arguments is returned
     * @param null $xss_clean Whether to apply XSS filtering
     *
     * @return array|string|null Value from the PUT request; otherwise, NULL
     */
    public function put($key = null, $xss_clean = null)
    {
        if ($key === null) {
            return $this->put_args;
        }

        return isset($this->put_args[$key]) ? $this->xssClean($this->put_args[$key], $xss_clean) : null;
    }

    /**
     * Retrieve a value from a DELETE request.
     *
     * @param null $key       Key to retrieve from the DELETE request
     *                        If NULL an array of arguments is returned
     * @param null $xss_clean Whether to apply XSS filtering
     *
     * @return array|string|null Value from the DELETE request; otherwise, NULL
     */
    public function delete($key = null, $xss_clean = null)
    {
        if ($key === null) {
            return $this->delete_args;
        }

        return isset($this->delete_args[$key]) ? $this->xssClean($this->delete_args[$key], $xss_clean) : null;
    }

    /**
     * Retrieve a value from a PATCH request.
     *
     * @param null $key       Key to retrieve from the PATCH request
     *                        If NULL an array of arguments is returned
     * @param null $xss_clean Whether to apply XSS filtering
     *
     * @return array|string|null Value from the PATCH request; otherwise, NULL
     */
    public function patch($key = null, $xss_clean = null)
    {
        if ($key === null) {
            return $this->patch_args;
        }

        return isset($this->patch_args[$key]) ? $this->xssClean($this->patch_args[$key], $xss_clean) : null;
    }

    /**
     * Retrieve a value from the query parameters.
     *
     * @param null $key       Key to retrieve from the query parameters
     *                        If NULL an array of arguments is returned
     * @param null $xss_clean Whether to apply XSS filtering
     *
     * @return array|string|null Value from the query parameters; otherwise, NULL
     */
    public function query($key = null, $xss_clean = null)
    {
        if ($key === null) {
            return $this->query_args;
        }

        return isset($this->query_args[$key]) ? $this->xssClean($this->query_args[$key], $xss_clean) : null;
    }

    /**
     * Sanitizes data so that Cross Site Scripting Hacks can be
     * prevented.
     *
     * @param string $value     Input data
     * @param bool   $xss_clean Whether to apply XSS filtering
     *
     * @return string
     */
    protected function xssClean($value, $xss_clean)
    {
        is_bool($xss_clean) || $xss_clean = $this->enableXss;

        return $xss_clean === true ? $this->security->xss_clean($value) : $value;
    }

    /**
     * Retrieve the validation errors.
     *
     * @return array
     */
    public function validationErrors()
    {
        $string = strip_tags($this->form_validation->error_string());

        return explode(PHP_EOL, trim($string, PHP_EOL));
    }

    // SECURITY FUNCTIONS ---------------------------------------------------------

    /**
     * Perform LDAP Authentication.
     *
     * @param string $username The username to validate
     * @param string $password The password to validate
     *
     * @return bool
     */
    protected function performLdapAuth($username = '', $password = null)
    {
        if (empty($username)) {
            log_message('debug', 'LDAP Auth: failure, empty username');

            return false;
        }

        log_message('debug', 'LDAP Auth: Loading configuration');

        $this->config->load('ldap', true);

        $ldap = [
            'timeout' => $this->config->item('timeout', 'ldap'),
            'host'    => $this->config->item('server', 'ldap'),
            'port'    => $this->config->item('port', 'ldap'),
            'rdn'     => $this->config->item('binduser', 'ldap'),
            'pass'    => $this->config->item('bindpw', 'ldap'),
            'basedn'  => $this->config->item('basedn', 'ldap'),
        ];

        log_message('debug', 'LDAP Auth: Connect to ' . (isset($ldap['host']) ? $ldap['host'] : '[ldap not configured]'));

        // Connect to the ldap server
        $ldapconn = ldap_connect($ldap['host'], $ldap['port']);
        if ($ldapconn) {
            log_message('debug', 'Setting timeout to ' . $ldap['timeout'] . ' seconds');

            ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, $ldap['timeout']);

            log_message('debug', 'LDAP Auth: Binding to ' . $ldap['host'] . ' with dn ' . $ldap['rdn']);

            // Binding to the ldap server
            $ldapbind = ldap_bind($ldapconn, $ldap['rdn'], $ldap['pass']);

            // Verify the binding
            if ($ldapbind === false) {
                log_message('error', 'LDAP Auth: bind was unsuccessful');

                return false;
            }

            log_message('debug', 'LDAP Auth: bind successful');
        }

        // Search for user
        if (($res_id = ldap_search($ldapconn, $ldap['basedn'], "uid=$username")) === false) {
            log_message('error', 'LDAP Auth: User ' . $username . ' not found in search');

            return false;
        }

        if (ldap_count_entries($ldapconn, $res_id) !== 1) {
            log_message('error', 'LDAP Auth: Failure, username ' . $username . 'found more than once');

            return false;
        }

        if (($entry_id = ldap_first_entry($ldapconn, $res_id)) === false) {
            log_message('error', 'LDAP Auth: Failure, entry of search result could not be fetched');

            return false;
        }

        if (($user_dn = ldap_get_dn($ldapconn, $entry_id)) === false) {
            log_message('error', 'LDAP Auth: Failure, user-dn could not be fetched');

            return false;
        }

        // User found, could not authenticate as user
        if (($link_id = ldap_bind($ldapconn, $user_dn, $password)) === false) {
            log_message('error', 'LDAP Auth: Failure, username/password did not match: ' . $user_dn);

            return false;
        }

        log_message('debug', 'LDAP Auth: Success ' . $user_dn . ' authenticated successfully');

        $this->userLdapDn = $user_dn;

        ldap_close($ldapconn);

        return true;
    }

    /**
     * Perform Library Authentication - Override this function to change the way the library is called.
     *
     * @param string $username The username to validate
     * @param string $password The password to validate
     *
     * @return bool
     */
    protected function performLibraryAuth($username = '', $password = null)
    {
        if (empty($username)) {
            log_message('error', 'Library Auth: Failure, empty username');

            return false;
        }

        $auth_library_class = strtolower($this->config->item('auth_library_class'));
        $auth_library_function = strtolower($this->config->item('auth_library_function'));

        if (empty($auth_library_class)) {
            log_message('debug', 'Library Auth: Failure, empty auth_library_class');

            return false;
        }

        if (empty($auth_library_function)) {
            log_message('debug', 'Library Auth: Failure, empty auth_library_function');

            return false;
        }

        if (is_callable([$auth_library_class, $auth_library_function]) === false) {
            $this->load->library($auth_library_class);
        }

        return $this->{$auth_library_class}->$auth_library_function($username, $password);
    }

    /**
     * Check if the user is logged in.
     *
     * @param string      $username The user's name
     * @param bool|string $password The user's password
     *
     * @return bool
     */
    protected function checkLogin($username = null, $password = false)
    {
        if (empty($username)) {
            return false;
        }

        $authSource = strtolower($this->config->item('auth_source'));
        $apiAuth = strtolower($this->config->item('api_auth'));
        $validLogins = $this->config->item('api_valid_logins');

        if (!$this->config->item('auth_source') && $apiAuth === 'digest') {
            // For digest we do not have a password passed as argument
            return md5($username . ':' . $this->config->item('api_realm') . ':' . (isset($validLogins[$username]) ? $validLogins[$username] : ''));
        }

        if ($password === false) {
            return false;
        }

        if ($authSource === 'ldap') {
            log_message('debug', "Performing LDAP authentication for $username");

            return $this->performLdapAuth($username, $password);
        }

        if ($authSource === 'library') {
            log_message('debug', "Performing Library authentication for $username");

            return $this->performLibraryAuth($username, $password);
        }

        if (array_key_exists($username, $validLogins) === false) {
            return false;
        }

        if ($validLogins[$username] !== $password) {
            return false;
        }

        return true;
    }

    /**
     * Check to see if the user is logged in with a PHP session key.
     *
     * @return void
     */
    protected function checkPhpSession()
    {
        // If whitelist is enabled it has the first chance to kick them out
        if ($this->config->item('api_ip_whitelist_enabled')) {
            $this->checkWhitelistAuth();
        }

        // Load library session of CodeIgniter
        $this->load->library('session');

        // Get the auth_source config item
        $key = $this->config->item('auth_source');

        // If false, then the user isn't logged in
        if (!$this->session->userdata($key)) {
            // Display an error response
            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_unauthorized'),
            ], HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * Prepares for basic authentication.
     *
     * @return void
     */
    protected function prepareBasicAuth()
    {
        // If whitelist is enabled it has the first chance to kick them out
        if ($this->config->item('api_ip_whitelist_enabled')) {
            $this->checkWhitelistAuth();
        }

        // Returns NULL if the SERVER variables PHP_AUTH_USER and HTTP_AUTHENTICATION don't exist
        $username = $this->input->server('PHP_AUTH_USER');
        $httpAuth = $this->input->server('HTTP_AUTHENTICATION') ?: $this->input->server('HTTP_AUTHORIZATION');

        $password = null;
        if ($username !== null) {
            $password = $this->input->server('PHP_AUTH_PW');
        } elseif ($httpAuth !== null) {
            // If the authentication header is set as basic, then extract the username and password from
            // HTTP_AUTHORIZATION e.g. my_username:my_password. This is passed in the .htaccess file
            if (strpos(strtolower($httpAuth), 'basic') === 0) {
                // Search online for HTTP_AUTHORIZATION workaround to explain what this is doing
                list($username, $password) = explode(':', base64_decode(substr($this->input->server('HTTP_AUTHORIZATION'), 6)));
            }
        }

        // Check if the user is logged into the system
        if ($this->checkLogin($username, $password) === false) {
            $this->forceLogin();
        }
    }

    /**
     * Prepares for digest authentication.
     *
     * @return void
     */
    protected function prepareDigestAuth()
    {
        // If whitelist is enabled it has the first chance to kick them out
        if ($this->config->item('api_ip_whitelist_enabled')) {
            $this->checkWhitelistAuth();
        }

        // We need to test which server authentication variable to use,
        // because the PHP ISAPI module in IIS acts different from CGI
        $digestString = $this->input->server('PHP_AUTH_DIGEST');
        if ($digestString === null) {
            $digestString = $this->input->server('HTTP_AUTHORIZATION');
        }

        $uniqueId = uniqid();

        // The $_SESSION['error_prompted'] variable is used to ask the password
        // again if none given or if the user enters wrong auth information
        if (empty($digestString)) {
            $this->forceLogin($uniqueId);
        }

        // We need to retrieve authentication data from the $digestString variable
        $matches = [];
        preg_match_all('@(username|nonce|uri|nc|cnonce|qop|response)=[\'"]?([^\'",]+)@', $digestString, $matches);
        $digest = (empty($matches[1]) || empty($matches[2])) ? [] : array_combine($matches[1], $matches[2]);

        // For digest authentication the library function should return already stored md5(username:apirealm:password) for that username see api.php::auth_library_function config
        $username = $this->checkLogin($digest['username'], true);
        if (isset($digest['username']) === false || $username === false) {
            $this->forceLogin($uniqueId);
        }

        $md5 = md5(strtoupper($this->request->method) . ':' . $digest['uri']);
        $validResponse = md5($username . ':' . $digest['nonce'] . ':' . $digest['nc'] . ':' . $digest['cnonce'] . ':' . $digest['qop'] . ':' . $md5);

        // Check if the string don't compare (case-insensitive)
        if (strcasecmp($digest['response'], $validResponse) !== 0) {
            // Display an error response
            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_invalid_credentials'),
            ], HttpStatus::UNAUTHORIZED);
        }
    }

    /** 
     * https://stackoverflow.com/questions/43406721/token-based-authentication-in-codeigniter-api-server-library
     * 
     * Check to see if the user is logged in with a token
     * 
     * @return object
     */
    protected function checkToken()
    {
        if (
            !empty($this->args[$this->config->item('api_token_name')])
            && $row = $this->api->db->where('token', $this->args[$this->config->item('api_token_name')])->get($this->config->item('api_tokens_table'))->row()
        ) {
            return $this->api_token = $row;
        } else {
            $this->response([
                $this->config->item('api_status_field_name') => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_unauthorized')
            ], HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * Checks if the client's ip is in the 'api_ip_blacklist' 
     * config and generates a 401 response.
     *
     * @return void
     */
    protected function checkBlacklistAuth()
    {
        // Match an ip address in a blacklist e.g. 127.0.0.0, 0.0.0.0
        $pattern = sprintf('/(?:,\s*|^)\Q%s\E(?=,\s*|$)/m', $this->input->ip_address());

        // Returns 1, 0 or false (on error only). Therefore implicitly convert 1 to true
        if (preg_match($pattern, $this->config->item('api_ip_blacklist'))) {
            // Display an error response
            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_ip_denied'),
            ], HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * Check if the client's ip is in the 'api_ip_whitelist' 
     * config and generates a 401 response.
     *
     * @return void
     */
    protected function checkWhitelistAuth()
    {
        $whitelist = explode(',', $this->config->item('api_ip_whitelist'));

        array_push($whitelist, '127.0.0.1', '0.0.0.0');

        foreach ($whitelist as &$ip) {
            // As $ip is a reference, trim leading and trailing whitespace, then store the new value
            // using the reference
            $ip = trim($ip);
        }

        if (in_array($this->input->ip_address(), $whitelist) === false) {
            $this->response([
                $this->config->item('api_status_field_name')  => false,
                $this->config->item('api_message_field_name') => $this->lang->line('text_api_ip_unauthorized'),
            ], HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * Force logging in by setting the WWW-Authenticate header.
     *
     * @param string $nonce A server-specified data string which should be uniquely generated
     *                      each time
     *
     * @return void
     */
    protected function forceLogin($nonce = '')
    {
        $apiAuth = strtolower($this->config->item('api_auth'));
        $apiRealm = $this->config->item('api_realm');
        if ($apiAuth === 'basic') {
            // See http://tools.ietf.org/html/rfc2617#page-5
            header('WWW-Authenticate: Basic realm="' . $apiRealm . '"');
        } elseif ($apiAuth === 'digest') {
            // See http://tools.ietf.org/html/rfc2617#page-18
            header(
                'WWW-Authenticate: Digest realm="' . $apiRealm
                    . '", qop="auth", nonce="' . $nonce
                    . '", opaque="' . md5($apiRealm) . '"'
            );
        }

        if ($this->config->item('strict_api_and_auth') === true) {
            $this->isValidRequest = false;
        }

        // Display an error response
        $this->response([
            $this->config->item('api_status_field_name')  => false,
            $this->config->item('api_message_field_name') => $this->lang->line('text_api_unauthorized'),
        ], HttpStatus::UNAUTHORIZED);
    }

    /**
     * Updates the log table with the total access time.
     *
     * @author Chris Kacerguis
     *
     * @return bool true log table updated; otherwise, false
     */
    protected function logAccessTime()
    {
        if ($this->insertId == '') {
            return false;
        }

        $payload['rtime'] = $this->end_rtime - $this->start_rtime;

        return $this->api->db->update(
            $this->config->item('api_logs_table'),
            $payload,
            [
                'id' => $this->insertId,
            ]
        );
    }

    /**
     * Updates the log table with HTTP response code.
     *
     * @author Justin Chen
     *
     * @param $httpCode int HTTP status code
     *
     * @return bool true log table updated; otherwise, false
     */
    protected function logResponseCode($httpCode)
    {
        if ($this->insertId == '') {
            return false;
        }

        $payload['response_code'] = $httpCode;

        return $this->api->db->update(
            $this->config->item('api_logs_table'),
            $payload,
            [
                'id' => $this->insertId,
            ]
        );
    }

    /**
     * Check to see if the API key has access to the controller and methods.
     *
     * @return bool true the API key has access; otherwise, false
     */
    protected function checkAccess()
    {
        // If we don't want to check access, just return true
        if ($this->config->item('api_enable_access') === false) {
            return true;
        }

        // Fetch controller based on path and controller name
        $controller = implode(
            '/',
            [
                $this->router->directory,
                $this->router->class,
            ]
        );

        // Remove any double slashes for safety
        $controller = str_replace('//', '/', $controller);

        //check if the key has all_access
        $accessRow = $this->api->db
            ->where('api_key', $this->api->key)
            ->where('controller', $controller)
            ->get($this->config->item('api_access_table'))->row_array();

        if (!empty($accessRow) && !empty($accessRow['all_access'])) {
            return true;
        }

        return false;
    }

    /**
     * Checks allowed domains, and adds appropriate headers for HTTP access control (CORS).
     *
     * @return void
     */
    protected function checkCORS()
    {
        // Convert the config items into strings
        $allowedHeaders = implode(', ', $this->config->item('allowed_cors_headers'));
        $allowedMethods = implode(', ', $this->config->item('allowed_cors_methods'));

        // If we want to allow any domain to access the API
        if ($this->config->item('allow_any_cors_domain') === true) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: ' . $allowedHeaders);
            header('Access-Control-Allow-Methods: ' . $allowedMethods);
        } else {
            // We're going to allow only certain domains access
            // Store the HTTP Origin header
            $origin = $this->input->server('HTTP_ORIGIN');
            if ($origin === null) {
                $origin = '';
            }

            // If the origin domain is in the allowed_cors_origins list, then add the Access Control headers
            if (in_array($origin, $this->config->item('allowed_cors_origins'))) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Headers: ' . $allowedHeaders);
                header('Access-Control-Allow-Methods: ' . $allowedMethods);
            }
        }

        // If there are headers that should be forced in the CORS check, add them now
        if (is_array($this->config->item('forced_cors_headers'))) {
            foreach ($this->config->item('forced_cors_headers') as $header => $value) {
                header($header . ': ' . $value);
            }
        }

        // If the request HTTP method is 'OPTIONS', kill the response and send it to the client
        if ($this->input->method() === 'options') {
            // Load DB if needed for logging
            if (!isset($this->api->db) && $this->config->item('api_enable_logging')) {
                $this->api->db = ($this->config->item('api_use_database'))
                    ? $this->load->database($this->config->item('api_database_group'), true)
                    : $this->load->database('default', true);
            }
            exit;
        }
    }
}
