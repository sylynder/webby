<?php

namespace Base\Http;

use Base\Http\CurlException;

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
class HttpCurl
{

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
     * Curl Connect Timeout
     * 
     * Maximum amount of time in seconds that is allowed 
     * to make the connection to the API server
     * @var int
     */
    public $curlConnectTimeout = 30;

    /**
     * Curl Timeout
     * 
     * Maximum amount of time in seconds to which the 
     * execution of cURL call will be limited
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

    /**
     * Constant Http Methods
     */
    public const GET    = 'GET';
    public const POST   = 'POST';
    public const PUT    = 'PUT';
    public const PATCH  = 'PATCH';
    public const DELETE = 'DELETE';

    /**
     * Contains the cURL response for debug
     *
     * @var string
     */
    protected $response = '';

    /**
     * Contains the cURL handler for a session
     *
     * @var \CurlHandle
     */
    protected $session;

    /**
     * URL of the session
     *
     * @var string
     */
    protected $url = '';

    /**
     * Gathers all curl_setopt_array
     *
     * @var array
     */
    protected $options = [];

    /**
     * Gathers all Http Headers
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Get Error code returned as an int
     *
     * @var int
     */
    protected $errorCode;

    /**
     * Get Error message returned as a string
     *
     * @var Error message returned as a string
     */
    protected $errorString;
    
    /**
     * Check Error Status
     *
     * @var bool
     */
    protected $hasError;
    
    /**
     * Get all curl request Information
     *
     * @var mixed
     */
    public $info;
    
    /**
     * Hold Http Status Code
     *
     * @var int
     */
    protected $status;

    /**
     * @param string 
     * @throws \Base\Http\CurlException if the library failed to initialize
     */

    public function __construct($url = '', $userAgent = '')
    {
        $this->userAgent = $userAgent;

        log_message('info', 'cURL Class Initialized');

        if (!$this->isEnabled()) {
            throw new CurlException('cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');
        }

        $url && $this->create($url);
        $this->baseUrl = $url;
    }

    /**
     * Start a session from a URL
     *
     * @param string $url
     * @return HttpCurl
     */
    public function create($url)
    {
        // If no protocol in URL, assume its a CI link
        if (!preg_match('!^\w+://! i', $url)) {
            //Using url function from ci_core_helper.php
            $url = url($url);
        }

        $this->baseUrl = $url;
        $this->session = curl_init($this->baseUrl);

        return $this;
    }

    /**
     * Get the Base Url from the Http Instance
     *
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * HttpCurl Request Method
     *
     * Quickly make a simple and easy cURL call with one line.
     * 
     * @param string $method
     * @param string $path
     * @param array $params
     * @param array $options
     * @return mixed
     */
    public function request($method, $path = '', array $params = [], $options = [])
    {
        $method = strtolower($method);

        // Get acts differently, as it doesnt accept 
        // parameters in the same way
        if ($method === 'get') {
            // If a URL is provided, create new session
            $this->get($path, $params);
        } else {
            // If a URL is provided, create new session
            $this->create($path);
            $this->{$method}($params);
        }

        // Add in the specific options provided
        $this->options($options);
        return $this->execute();
    }

    /**
     * HttpCurl Ftpget Method
     *
     * @param [type] $url
     * @param [type] $file_path
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function ftpget($url, $file_path, $username = '', $password = '')
    {
        // If there is no ftp:// or any protocol entered, add ftp://
        if (!preg_match('!^(ftp|sftp)://! i', $url)) {
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

        $file['file'] = new \CurlFile($file_path, mime_content_type($file_path));

        $this->option(CURLOPT_POST, true);
        $this->option(CURLOPT_POSTFIELDS, $file);
        // $this->option(CURLOPT_BINARYTRANSFER, true);
        $this->option(CURLOPT_VERBOSE, true);

        return $this->execute();
    }

    /*---------------------------------------------Advanced Usage -------------------------------*/

    /**
     * HttpCurl Get method
     * 
     * @param string $path
     * @param array $params
     * @return HttpCurl
     */
    public function get($path = '', $params = [])
    {

        if (empty($path) && !empty($this->getBaseUrl())) {
            $this->create($this->getBaseUrl());
        }

        if (!empty($path)) {
            $this->create($path);
        }

        $this->method(HttpCurl::GET);

        if (!empty($params)) {
            $params .= '?' . http_build_query($params, '', '&');

            // Add in the specific options provided
            $this->option(CURLOPT_POST, true);
            $this->option(CURLOPT_POSTFIELDS, $params);
        }

        return $this;
    }

    /**
     * HttpCurl Post Method
     *
     * @param string $path
     * @param array $params
     * @param array $options
     * @return HttpCurl
     */
    public function post($path = '', $params = [], $options = [])
    {
        $path = trim($path, '/');

        if (!empty($path)) {
            $this->create($this->baseUrl . $path);
        }

        // If it's an array (instead of a query string) 
        // then format it correctly
        if (is_array($params)) {
            $params = http_build_query($params, '', '&');
        }

        // Add in the specific options provided
        $this->options($options);
        $this->method(HttpCurl::POST);
        $this->option(CURLOPT_POST, true);
        $this->option(CURLOPT_POSTFIELDS, $params);

        return $this;
    }

    /**
     * HttpCurl Put Method
     *
     * @param string $path
     * @param array $params
     * @param array $options
     * @return HttpCurl
     */
    public function put($path = '', $params = [], $options = [])
    {
        $path = trim($path, '/');

        if (!empty($path)) {
            $this->create($this->baseUrl . $path);
        }

        // If its an array (instead of a query string) then format it correctly
        if (is_array($params)) {
            $params = http_build_query($params, '', '&');
        }

        // Add in the specific options provided
        $this->options($options);
        $this->method(HttpCurl::PUT);
        $this->option(CURLOPT_POSTFIELDS, $params);
        // Override method, I think this overrides $_POST with PUT data but... we'll see eh?
        $this->option(CURLOPT_HTTPHEADER, ['X-HTTP-Method-Override: PUT']);

        return $this;
    }

    /**
     * HttpCurl Patch Method
     *
     * @param string $path
     * @param array $params
     * @param array $options
     * @return HttpCurl
     */
    public function patch($path = '', $params = [], $options = [])
    {
        $path = trim($path, '/');

        if (!empty($path)) {
            $this->create($this->baseUrl . $path);
        }

        // If its an array (instead of a query string) then format it correctly
        if (is_array($params)) {
            $params = http_build_query($params, '', '&');
        }

        // Add in the specific options provided
        $this->options($options);
        $this->method(HttpCurl::PATCH);
        $this->option(CURLOPT_POSTFIELDS, $params);

        // Override method, I think this overrides $_POST with PATCH data but... we'll see eh?
        $this->option(CURLOPT_HTTPHEADER, ['X-HTTP-Method-Override: PATCH']);

        return $this;
    }

    /**
     * HttpCurl Delete Method
     *
     * @param string $path
     * @param array $params
     * @param array $options
     * @return HttpCurl
     */
    public function delete($path = '', $params = [], $options = [])
    {
        $path = trim($path, '/');

        if (!empty($path)) {
            $this->create($this->baseUrl . $path);
        }

        // If its an array (instead of a query string) then format it correctly
        if (is_array($params)) {
            $params = http_build_query($params, '', '&');
        }

        // Add in the specific options provided
        $this->options($options);
        $this->method(HttpCurl::DELETE);
        $this->option(CURLOPT_POSTFIELDS, $params);

        return $this;
    }

    /**
     * HttpCurl Set Cookie Method
     *
     * @param array $params
     * @return HttpCurl
     */
    public function setCookies($params = [])
    {
        if (is_array($params)) {
            $params = http_build_query($params, '', '&');
        }

        $this->option(CURLOPT_COOKIE, $params);
        return $this;
    }

    /**
     * Http Header Method
     *
     * @param string $header
     * @param string|array $content
     * @return HttpCurl
     */
    public function header($header, $content = null)
    {
        $this->headers[] = $content ? $header . ': ' . $content : $header;
        return $this;
    }

    /**
     * Http Method
     *
     * @param string $method
     * @return HttpCurl
     */
    public function method($method)
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
        return $this;
    }

    /**
     * Http Login
     *
     * @param string $username
     * @param string $password
     * @param string $type
     * @return HttpCurl
     */
    public function login($username = '', $password = '', $type = 'any')
    {
        $this->option(CURLOPT_HTTPAUTH, constant('CURLAUTH_' . strtoupper($type)));
        $this->option(CURLOPT_USERPWD, $username . ':' . $password);
        return $this;
    }

    /**
     * HttpCurl Proxy Method
     *
     * @param string $url
     * @param integer $port
     * @return HttpCurl
     */
    public function proxy($url = '', $port = 80)
    {
        $this->option(CURLOPT_HTTPPROXYTUNNEL, true);
        $this->option(CURLOPT_PROXY, $url . ':' . $port);
        return $this;
    }

    /**
     * HttpCurl Proxy Login Method
     *
     * @param string $username
     * @param string $password
     * @return HttpCurl
     */
    public function proxyLogin($username = '', $password = '')
    {
        $this->option(CURLOPT_PROXYUSERPWD, $username . ':' . $password);
        return $this;
    }

    /**
     * HttpCurl SSL Method
     *
     * @param boolean $verifyPeer
     * @param integer $verifyHost
     * @param mixed $pathToCert
     * @return HttpCurl
     */
    public function ssl($verifyPeer = true, $verifyHost = 2, $pathToCert = null)
    {
        if ($verifyPeer) {
            $this->option(CURLOPT_SSL_VERIFYPEER, true);
            $this->option(CURLOPT_SSL_VERIFYHOST, $verifyHost);
            if (isset($pathToCert)) {
                $pathToCert = realpath($pathToCert);
                $this->option(CURLOPT_CAINFO, $pathToCert);
            }
        } else {
            $this->option(CURLOPT_SSL_VERIFYPEER, false);
            $this->option(CURLOPT_SSL_VERIFYHOST, $verifyHost);
        }
        return $this;
    }

    /**
     * HttpCurl Options Method
     * 
     * Gathers all curl_setopt_arrays
     *
     * @param array $options
     * @return HttpCurl
     */
    public function options($options = [])
    {
        // Merge options in with the rest - done as array_merge() 
        // does not overwrite numeric keys
        foreach ($options as $option => $value) {
            $this->option($option, $value);
        }

        // Set all options provided
        curl_setopt_array($this->session, $this->options);

        return $this;
    }

    /**
     * HttpCurl Option Method
     *
     * Allows you to specify a curl option
     * 
     * @param string $option
     * @param string $value
     * @return HttpCurl
     */
    public function option($option, $value)
    {
        if (is_string($option) && !is_numeric($option)) {
            $option = constant('CURLOPT_' . strtoupper($option));
        }

        $this->options[$option] = $value;
        return $this;
    }

    /**
     * Execute a curl session and return results
     *
     * @return mixed
     */
    public function execute()
    {
        // Set two default options, and merge any extra ones in
        if (!isset($this->options[CURLOPT_CONNECTTIMEOUT])) {
            $this->options[CURLOPT_CONNECTTIMEOUT] = $this->curlConnectTimeout;
        }

        if (!isset($this->options[CURLOPT_TIMEOUT])) {
            $this->options[CURLOPT_TIMEOUT] = $this->curlTimeout;
        }

        if (!isset($this->options[CURLOPT_RETURNTRANSFER])) {
            $this->options[CURLOPT_RETURNTRANSFER] = true;
        }

        if (!isset($this->options[CURLOPT_FAILONERROR])) {
            $this->options[CURLOPT_FAILONERROR] = true;
        }

        if (!isset($this->options[CURLOPT_USERAGENT])) {
            $this->options[CURLOPT_USERAGENT] = $this->userAgent;
        }

        // Only set follow location if not running securely
        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            // Ok, follow location is not set already so lets set it to true
            if (!isset($this->options[CURLOPT_FOLLOWLOCATION])) {
                $this->options[CURLOPT_FOLLOWLOCATION] = true;
            }
        }

        if (!empty($this->headers)) {
            $this->option(CURLOPT_HTTPHEADER, $this->headers);
        }

        $this->options();

        // Execute the request & and hide all output
        $this->lastResponseRaw = curl_exec($this->session);
        $this->info = curl_getinfo($this->session);

        // Request failed
        if ($this->lastResponseRaw === false) {
            $errno = curl_errno($this->session);
            $error = curl_error($this->session);

            curl_close($this->session);
            $this->reset();

            $this->hasError = true;
            $this->errorCode = $errno;
            $this->errorString = $error;

            return false;
        }
        // Request successful
        else {
            curl_close($this->session);
            $this->lastResponse = $this->lastResponseRaw;
            $this->reset();
            $this->hasError = false;
            return $this->lastResponse;
        }
    }

    /**
     * Return raw response data from the last request
     * 
     * @return string|null Response data
     */
    public function getLastResponseRaw()
    {
        return $this->lastResponseRaw;
    }

    /**
     * Return decoded response data from the last request
     * 
     * @return string|array|null Response data
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Get Status Code
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->status;
    }

    /**
     * Checks whether curl has an error
     *
     * @return bool
     */
    public function hasError()
    {
        return $this->hasError;
    }

    /**
     * Get Curl Error Message
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return 'An error: ' . $this->errorString . ' with error number: ' . $this->errorCode;
    }

    /**
     * Get Curl Error String
     *
     * @return string
     */
    public function error()
    {
        return $this->errorString;
    }

    /**
     * Get Curl Error Code
     *
     * @return void
     */
    public function errorCode()
    {
        return $this->errorCode;
    }

    /**
     * Is Curl available
     *
     * @return bool
     */
    public function isEnabled()
    {
        return function_exists('curl_init');
    }

    /**
     * Curl Debugging
     *
     * @return void
     */
    public function debug()
    {
        echo "=============================================<br/>\n";
        echo "<h2>CURL Test</h2>\n";
        echo "=============================================<br/>\n";
        echo "<h3>Response</h3>\n";
        echo "<code>" . nl2br(htmlentities($this->lastResponseRaw)) . "</code><br/>\n\n";

        if ($this->errorString) {
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

    /**
     * Debug BaseUrl content
     *
     * @return array
     */
    public function debugRequest()
    {
        return [
            'url' => $this->baseUrl
        ];
    }

    /**
     * Reset already assigned properties
     *
     * @return HttpCurl
     */
    public function reset()
    {
        $this->lastResponseRaw = '';
        $this->headers = [];
        $this->options = [];
        $this->errorCode = null;
        $this->errorString = '';
        $this->session = null;

        return $this;
    }
}
