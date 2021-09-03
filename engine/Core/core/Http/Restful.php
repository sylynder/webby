<?php

namespace Base\Http;

use Base\Http\Request;
use Base\Http\Response;
use Base\Http\HttpStatus;
use Base\Controllers\Controller;

/**
 * Restful Controller
 * 
 * @author  Nick Tsai <myintaer@gmail.com>
 * @version 1.6.1
 * @link    https://github.com/yidas/codeigniter-rest/
 * 
 * Modified by Kwame Oteng Appiah-Nti
 * To integrate it into Webby for Restful Controllers
 * 
 */
class Restful extends Controller
{
    /**
     * Restful resource routes
     * 
     * public function index() {}
     * protected function store($requestData=null) {}
     * protected function show($resourceID) {}
     * protected function update($resourceID, $requestData=null) {}
     * protected function delete($resourceID=null) {}
     * 
     * @var array Restful API table of routes & actions
     */
    protected $routes = [
        'index' => 'index',
        'store' => 'store',
        'show' => 'show',
        'update' => 'update',
        'delete' => 'delete',
    ];

    /**
     * Behaviors of actions
     *
     * @var array
     */
    private $behaviors = [
        'index' => null,
        'store' => null,
        'show' => null,
        'update' => null,
        'delete' => null,
    ];

    /**
     * Pre-setting format
     * 
     * @var string Base\Http\Response format
     */
    protected $format;

    /**
     * Body Format usage switch
     * 
     * @var bool Default $bodyFormat for json()
     */
    protected $bodyFormat = false;

    /**
     * @var object Base\Http\Request;
     */
    protected $request;

    /**
     * @var object Base\Http\Response;
     */
    protected $response;
    
    function __construct() 
    {
        parent::__construct();
        
        // Request initialization
        $this->request = new Request;
        // Response initialization
        $this->response = new Response;

        // Response setting
        if ($this->format) {
		    $this->response->setFormat($this->format);
        }
    }

    /**
     * Route bootstrap
     * 
     * For Codeigniter route setting to implement RESTful API
     * 
     * Without routes setting, `resource/{route-alias}` URI pattern is a limitation which CI3 would 
     * first map `controller/action` URI into action() instead of index($action)
     * 
     * @param int|string Resource ID
     */
    public function route($resourceID=null)
    {
        switch ($this->request->getMethod()) {
            case 'POST':
                if (!$resourceID) {
                    return $this->action(['store', $this->request->getBodyParams()]);
                }
                break;
            case 'PATCH':
                // PATCH could only allow single element
                if (!$resourceID) {
                    return $this->defaultAction();
                }
            case 'PUT':
                return $this->action(['update', $resourceID, $this->request->getBodyParams()]);
                break;
            case 'DELETE':
                return $this->action(['delete', $resourceID, $this->request->getBodyParams()]);
                break;
            case 'GET':
            default:
                if ($resourceID) {
                    return $this->action(['show', $resourceID]);
                } else {
                    return $this->action(['index']);
                }
                break;
        }
    }

    /**
     * Alias of route()
     *
     * `resource/api` URI pattern
     */
    public function api($resourceID=null)
    {
        return $this->route($resourceID);
    }

    /**
     * Alias of route()
     *
     * `resource/ajax` URI pattern
     */
    public function ajax($resourceID=null)
    {
        return $this->route($resourceID);
    }

    /**
     * Output by JSON format with optinal body format
     * 
     * @param array|mixed Callback data body, false will remove body key
     * @param bool Enable body format
     * @param int HTTP Status Code
     * @param string Callback message
     * @return string Response body data
     * 
     * @example
     *  json(false, true, 401, 'Login Required', 'Unauthorized');
     */
    protected function json($data=[], $bodyFormat=null, $statusCode=null, $message=null)
    {
        // Check default Body Format setting if not assigning
        $bodyFormat = ($bodyFormat!==null) ? $bodyFormat : $this->bodyFormat;
        
        if ($bodyFormat) {
            // Pack data
            $data = $this->format($statusCode, $message, $data);
        } else {
            // JSON standard of RFC4627
            $data = is_array($data) ? $data : [$data];
        }

        return $this->response->json($data, $statusCode);
    }

    /**
     * Format Response Data
     * 
     * @param int Callback status code
     * @param string Callback status text
     * @param array|mixed|bool Callback data body, false will remove body key 
     * @return array Formated array data
     */
    protected function format($statusCode=null, $message=null, $body=false)
    {
        $format = [];
        // Status Code field is necessary
        $format['code'] = ($statusCode) 
            ?: $this->response->getStatusCode();
        // Message field
        if ($message) {
            $format['message'] = $message;
        }
        // Body field
        if ($body !== false) {
            $format['data'] = $body;
        }
        
        return $format;
    }

    /**
     * Pack array data into body format
     * 
     * You could override this method for your application standard
     * 
     * @param array|mixed $data Original data
     * @param int HTTP Status Code
     * @param string Callback message
     * @return array Packed data
     * @example
     *  $packedData = pack(['bar'=>'foo], 401, 'Login Required');
     */
    protected function pack($data, $statusCode=HttpStatus::OK, $message=null)
    {
        $packBody = [];

        // Status Code
        if ($statusCode) {
            $packBody['code'] = $statusCode;
        }
        // Message
        if ($message) {
            $packBody['message'] = $message;
        }
        // Data
        if (is_array($data) || is_string($data)) {
            $packBody['data'] = $data;
        }
        
        return $packBody;
    }

    /**
     * Default Action
     */
    protected function defaultAction()
    {
        /* Response sample code */
        // $response->data = ['foo'=>'bar'];
		// $response->setStatusCode(401);
        
        // Codeigniter 404 Error Handling
        show_404();
    }

    /**
     * Set behavior to a action before route
     *
     * @param String $action
     * @param Callable $function
     * @return boolean Result
     */
    protected function setBehavior($action, Callable $function)
    {
        if (array_key_exists($action, $this->behaviors)) {

            $this->behaviors[$action] = $function;
            return true;
        }

        return false;
    }

    /**
     * Action processor for route
     * 
     * @param array Elements contains method for first and params for others 
     */
    private function action($params)
    {
        // Shift and get the method
        $method = array_shift($params);

        // Behavior
        if ($this->behaviors[$method]) {
            $this->behaviors[$method]();
        }

        if (!isset($this->routes[$method])) {
            $this->defaultAction();
        }

        // Get corresponding method name
        $method = $this->routes[$method];

        if (!method_exists($this, $method)) {
            $this->defaultAction();
        }

        return call_user_func_array([$this, $method], $params);
    }
}
