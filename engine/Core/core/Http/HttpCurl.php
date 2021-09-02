<?php 

namespace Base\Http;

use Base\Http\CurlException;
use Base\CodeIgniter\Instance;

/**
 * An Easy Curl Library
 * 
 * Serving as an http client to work with remote servers
 * Built to easily use than the native PHP cURL bindings
 * Borrowed some ideas from Philsturgeon's CodeIgniter-Curl library
 *
 * @package    HttpCurl
 * @author     Kwame Oteng Appiah-Nti <me@developerkwame.com>
 * @author     Philip Sturgeon
 * @license    http://philsturgeon.co.uk/code/dbad-license dbad-license
 */
class HttpCurl {

    /**
     * Http Base URL
     * 
     * @var string
     */
    public $baseUrl = '';

    /**
     * User Agent
     * 
     * @var string
     */
    public $userAgent = 'An API Agent';

    /**
     * Maximum amount of time in seconds that is allowed to make the connection to the API server
     * @var int
     */
    public $curlConnectTimeout = 30;

    /**
     * Maximum amount of time in seconds to which the execution of cURL call will be limited
     * @var int
     */
    public $curlTimeout = 30;

    /**
     * Last response raw
     *
     * @var string
     */
    private $lastResponseRaw;

    /**
     * Last response
     *
     * @var string
     */
    private $lastResponse;

    const GET    = 'GET';
    const POST   = 'POST';
    const PUT    = 'PUT';
    const PATCH  = 'PATCH';
    const DELETE = 'DELETE';

    protected $ci;                  // CodeIgniter instance
    protected $response = '';       // Contains the cURL response for debug
    protected $session;             // Contains the cURL handler for a session
    protected $url;                 // URL of the session
    protected $options = [];        // Populates curl_setopt_array
    protected $headers = [];        // Populates extra HTTP headers
    public $errorCode;              // Error code returned as an int
    public $errorString;            // Error message returned as a string
    public $info;                   // Returned after request (elapsed time, etc)

    /**
     * @param string 
     * @throws \Base\Http\CurlException if the library failed to initialize
     */

    public function __construct($url = '')
    {
        $this->ci = Instance::create();

        log_message('info', 'cURL Class Initialized');

        if ( ! $this->isEnabled()) {
            throw new CurlException('cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');
        }

        $url && $this->create($url);
        $this->baseUrl = $url;
    }

    /**
     * Start a session from a URL
     *
     * @param string $url
     * @return self
     */
    public function create($url)
    {
        // If no protocol in URL, assume its a CI link
        if ( ! preg_match('!^\w+://! i', $url)) {
            //Using url function from ci_core_helper.php
            $url = url($url);
        }

        $this->url = $url;
        $this->session = curl_init($this->url);

        return $this;
    }

    /**
     * Simple curlCall
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (
            in_array(
                $method, ['curlGet','curlPost','curlPut','curlDelete','curlPatch']
            )
        ) {
            // Take off the "curl" and pass 
            // get/post/put/delete/patch to curlRequest
            $verb = strtolower($method);
            $verb = str_replace('curl', '', $method);
            array_unshift($arguments, $verb);
            return call_user_func_array([$this, 'curlRequest'], $arguments);
        }
    }

    /**
	* Get the Base Url from the Http Instance
	*
	* @return string [This is the base URL that is on the class instance]
	*/
    protected function getBaseUrl()
    {
    	return $this->baseUrl;    
    }

    /**
     * Set to change the default baseUrl
     *
     * @param  string $url the base url path
     * @return self
     */
	protected function setBaseUrl($url)
    {
    	$this->baseUrl = $url;
		return $this;
    }

    /* =================================================================================
     * Curl METHODS
     * Using these methods you can make a quick and easy cURL call with one line.
     * ================================================================================= */

    public function curlRequest($method, $path, $params = [], $options = [])
    {
        // Get acts differently, as it doesnt accept parameters in the same way
        if ($method === 'get')
        {
            // If a URL is provided, create new session
            $this->create($path.($params ? '?'.http_build_query($params, null, '&') : ''));
            
        } else {
            // If a URL is provided, create new session
            $this->create($path);
            $this->{$method}($params);
        }

        $path = trim($path, '/');

        if (!empty($params)) {
            // If a URL is provided, create new session
            $this->create($path.($params ? '?'.http_build_query($params, '', '&') : ''));
        }

        // Add in the specific options provided
        $this->options($options);

        return $this->execute();
    }

    public function curlFtpGet($url, $file_path, $username = '', $password = '')
    {
        // If there is no ftp:// or any protocol entered, add ftp://
        if ( ! preg_match('!^(ftp|sftp)://! i', $url)) {
            $url = 'ftp://' . $url;
        }

        // Use an FTP login
        if ($username != '') {
            $auth_string = $username;

            if ($password != '') {
                $auth_string .= ':' . $password;
            }

            // Add the user auth string after the protocol
            $url = str_replace('://', '://' . $auth_string . '@', $url);
        }

        // Add the filepath
        $url .= $file_path;

        $this->option(CURLOPT_BINARYTRANSFER, TRUE);
        $this->option(CURLOPT_VERBOSE, TRUE);

        return $this->execute();
    }

    /* =================================================================================
     * ADVANCED METHODS
     * Use these methods to build up more complex queries
     * ================================================================================= */

    // Added by Ivan Tcholakov, 08-AUG-2015.
    public function get()
    {
        // Do nothing, just support method chaining.
        return $this;
    }
    //

    public function post($params = [], $options = [])
    {
        // If its an array (instead of a query string) then format it correctly
        if (is_array($params))
        {
            $params = http_build_query($params, null, '&');
        }

        // Add in the specific options provided
        $this->options($options);

        $this->httpMethod('post');

        $this->option(CURLOPT_POST, TRUE);
        $this->option(CURLOPT_POSTFIELDS, $params);

        return $this;
    }

    public function put($params = [], $options = [])
    {
        // If its an array (instead of a query string) then format it correctly
        if (is_array($params))
        {
            $params = http_build_query($params, null, '&');
        }

        // Add in the specific options provided
        $this->options($options);

        $this->httpMethod('put');
        $this->option(CURLOPT_POSTFIELDS, $params);

        // Override method, I think this overrides $_POST with PUT data but... we'll see eh?
        $this->option(CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));

        return $this;
    }

    public function patch($params = [], $options = [])
    {
        // If its an array (instead of a query string) then format it correctly
        if (is_array($params))
        {
            $params = http_build_query($params, null, '&');
        }

        // Add in the specific options provided
        $this->options($options);

        $this->httpMethod('patch');
        $this->option(CURLOPT_POSTFIELDS, $params);

        // Override method, I think this overrides $_POST with PATCH data but... we'll see eh?
        $this->option(CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PATCH'));

        return $this;
    }

    public function delete($params, $options = [])
    {
        // If its an array (instead of a query string) then format it correctly
        if (is_array($params))
        {
            $params = http_build_query($params, null, '&');
        }

        // Add in the specific options provided
        $this->options($options);

        $this->httpMethod('delete');

        $this->option(CURLOPT_POSTFIELDS, $params);

        return $this;
    }

    public function setCookies($params = [])
    {
        if (is_array($params))
        {
            $params = http_build_query($params, null, '&');
        }

        $this->option(CURLOPT_COOKIE, $params);
        return $this;
    }

    public function httpHeader($header, $content = null)
    {
        $this->headers[] = $content ? $header . ': ' . $content : $header;
        return $this;
    }

    public function httpMethod($method)
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
        return $this;
    }

    public function httpLogin($username = '', $password = '', $type = 'any')
    {
        $this->option(CURLOPT_HTTPAUTH, constant('CURLAUTH_' . strtoupper($type)));
        $this->option(CURLOPT_USERPWD, $username . ':' . $password);
        return $this;
    }

    public function proxy($url = '', $port = 80)
    {
        $this->option(CURLOPT_HTTPPROXYTUNNEL, TRUE);
        $this->option(CURLOPT_PROXY, $url . ':' . $port);
        return $this;
    }

    public function proxyLogin($username = '', $password = '')
    {
        $this->option(CURLOPT_PROXYUSERPWD, $username . ':' . $password);
        return $this;
    }

    public function ssl($verify_peer = TRUE, $verify_host = 2, $path_to_cert = null)
    {
        if ($verify_peer)
        {
            $this->option(CURLOPT_SSL_VERIFYPEER, TRUE);
            $this->option(CURLOPT_SSL_VERIFYHOST, $verify_host);
            if (isset($path_to_cert)) {
                $path_to_cert = realpath($path_to_cert);
                $this->option(CURLOPT_CAINFO, $path_to_cert);
            }
        }
        else
        {
            $this->option(CURLOPT_SSL_VERIFYPEER, FALSE);
            $this->option(CURLOPT_SSL_VERIFYHOST, $verify_host);
        }
        return $this;
    }

    public function curlOptions($options = [])
    {
        // Merge options in with the rest - done as array_merge() 
        // does not overwrite numeric keys
        foreach ($options as $option => $value) {
            $this->curlOption($option, $value);
        }

        // Set all options provided
        curl_setopt_array($this->session, $this->options);

        return $this;
    }

    public function curlOption($option, $value)
    {
        if (is_string($option) && !is_numeric($option)) {
            $option = constant('CURLOPT_' . strtoupper($option));
        }

        $this->options[$option] = $value;
        return $this;
    }

    // End a session and return the results
    public function execute()
    {
        // Set two default options, and merge any extra ones in
        if ( ! isset($this->options[CURLOPT_TIMEOUT]))
        {
            $this->options[CURLOPT_TIMEOUT] = 30;
        }
        if ( ! isset($this->options[CURLOPT_RETURNTRANSFER]))
        {
            $this->options[CURLOPT_RETURNTRANSFER] = TRUE;
        }
        if ( ! isset($this->options[CURLOPT_FAILONERROR]))
        {
            $this->options[CURLOPT_FAILONERROR] = TRUE;
        }

        // Only set follow location if not running securely
        if ( ! ini_get('safe_mode') && ! ini_get('open_basedir'))
        {
            // Ok, follow location is not set already so lets set it to true
            if ( ! isset($this->options[CURLOPT_FOLLOWLOCATION]))
            {
                $this->options[CURLOPT_FOLLOWLOCATION] = TRUE;
            }
        }

        if ( ! empty($this->headers))
        {
            $this->option(CURLOPT_HTTPHEADER, $this->headers);
        }

        $this->options();

        // Execute the request & and hide all output
        $this->response = curl_exec($this->session);
        $this->info = curl_getinfo($this->session);

        // Request failed
        if ($this->response === FALSE)
        {
            $errno = curl_errno($this->session);
            $error = curl_error($this->session);

            curl_close($this->session);
            $this->setDefaults();

            $this->errorCode = $errno;
            $this->errorString = $error;

            return FALSE;
        }

        // Request successful
        else
        {
            curl_close($this->session);
            $this->lastResponse = $this->response;
            $this->setDefaults();
            return $this->lastResponse;
        }
    }

    public function isEnabled()
    {
        return function_exists('curl_init');
    }

    public function debug()
    {
        echo "=============================================<br/>\n";
        echo "<h2>CURL Test</h2>\n";
        echo "=============================================<br/>\n";
        echo "<h3>Response</h3>\n";
        echo "<code>" . nl2br(htmlentities($this->lastResponse)) . "</code><br/>\n\n";

        if ($this->errorString)
        {
            echo "=============================================<br/>\n";
            echo "<h3>Errors</h3>";
            echo "<strong>Code:</strong> " . $this->errorCode . "<br/>\n";
            echo "<strong>Message:</strong> " . $this->errorString . "<br/>\n";
        }

        echo "=============================================<br/>\n";
        echo "<h3>Info</h3>";
        echo "<pre>";
        print_r($this->info);
        echo "</pre>";
    }

    public function debugRequest()
    {
        return array(
            'url' => $this->url
        );
    }

    public function setDefaults()
    {
        $this->response = '';
        $this->headers = [];
        $this->options = [];
        $this->errorCode = null;
        $this->errorString = '';
        $this->session = null;

        return $this;
    }

}
