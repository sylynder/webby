<?php

/**
 * Intelligent, Elegant routing for Webby
 *
 * Inspired by Jamie Rumblelow's Pigeon Route and Bonfire Route
 * 
 * I decided to implement it and made
 * much modification to work with Webby
 * 
 * @author Kwame Oteng Appiah-Nti (Developer Kwame)
 * 
 */

namespace Base\Route;

use Closure;
use Base\Helpers\Inflector;

class Route
{

	/**
	 * Routes array
	 *
	 * @var array
	 */
	protected static $routes = [];

	/**
	 * Router array
	 *
	 * @var array
	 */
	protected static $router = [];

	/**
	 * Temporary routes array
	 *
	 * @var array
	 */
	protected static $temporaryRoutes = [];

	/**
	 * Default Routes array
	 *
	 * @var array
	 */
	protected static $defaultRoutes = [];

	/**
	 * Available Routes array
	 *
	 * @var array
	 */
	protected static $availableRoutes = [];

	/**
	 * Api Routes array
	 *
	 * @var array
	 */
	protected static $apiRoutes = [];

	/**
	 * Route Regex variable
	 *
	 * @var string
	 */
	protected static $routeRegex = '([a-zA-Z0-9\-_]+)';

	/**
	 * Route Namespace variable
	 *
	 * @var string
	 */
	protected static $namespace = '';

	/**
	 * Route Prefix variable
	 *
	 * @var string
	 */
	protected static $prefix = null;

	/**
	 * Named routes
	 *
	 * @var array
	 */
	protected static $namedRoutes  = [];

	/**
	 * Nested Group variable
	 *
	 * @var string
	 */
	protected static $nestedGroup = '';

	/**
	 * Nested Depth variable
	 *
	 * @var integer
	 */
	protected static $nestedDepth  = 0;

	/**
	 * Set Http status
	 *
	 * @var boolean
	 */
	public static $trueHttp = false;

	/**
	 * Constants for route files
	 */
	const WEB_ROUTE = 'web';
	const RESTFUL_ROUTE = 'api';
	const CONSOLE_ROUTE = 'console';

	/**
	 * Uri variable
	 *
	 * @var string
	 */
	public $uri = '';

	/**
	 * refer to this class
	 *
	 * @var object
	 */
	protected static $self = null;

	/**
	 * Constructor function
	 *
	 * @param boolean $namespace
	 */
	public function __construct($namespace = null)
	{
		if ($namespace) {
			static::$namespace = $namespace;
		}
	}

	// --------------------------- Utility functions ----------------------------------

	/**
	 * Get path to display Route:view()
	 *
	 * @return string
	 */
	private static function routeView()
	{
		return $GLOBALS['CFG']->config['view']['route_views_through'];
	}

	/**
	 * Replace dot to slash
	 *
	 * @param string $string
	 * @return string
	 */
	public static function toSlash($string): string
	{
		$string = is_array($string) ? $string : dot2slash($string);

		if (strstr($string, '.')) {
			$string = str_replace('.', '/', $string);
		}

		return $string;
	}

	/**
	 * Get CodeIgniter Router Instance
	 *
	 * @return object
	 */
	public static function getRouter()
	{
		return static::$router = ci()->router;
	}

	/**
	 * Get Uri
	 *
	 * @return self
	 */
	private function getUri()
	{
		return $this->uri;
	}

	/**
	 * Set route
	 *
	 * @param mixed $uri
	 * @return self
	 */
	public function setRoute($uri = null)
	{
		$uri = $this->toSlash($uri);

		if (!empty($uri)) {
			$this->uri = ci()->config->site_url($uri);
		}

		if ($uri === null) {
			$this->uri = ci()->config->site_url('');
		}

		return $this;
	}

	/**
	 * To method
	 *
	 * @param string $uri
	 * @return mixed
	 */
	public function to($uri = '', $param = '')
	{
		$uri = $this->toSlash($uri);

		if (!empty($param)) {
			$uri = $uri . '/' . $param;
		}

		$this->uri = ci()->config->site_url($uri);

		if (empty($this->uri) || is_null($this->uri)) {
			return $this->uri = '';
		}

		return $this;
	}

	/**
	 * Back method
	 *
	 * @param string $uri
	 * @return mixed
	 */
	public function back($uri = '')
	{
		$uri = $this->toSlash($uri);

		$referer = $_SESSION['_webby_previous_url'] ?? ci()->input->server('HTTP_REFERER', FILTER_SANITIZE_URL);

		$referer = $referer ?? site_url('/');

		if (empty($uri)) {
			$this->uri = $referer;
			return $this;
		}

		$referer = site_url($uri);

		return redirect($referer);
	}

	/**
	 * Set Referrer
	 *
	 * @param string $value
	 * @return mixed
	 * 
	 * @Todo To be implemented
	 */
	public function setReferrer($value)
	{
		$value = $this->toSlash($value);

		$_SESSION['_webby_previous_url'] = $value;

		return $_SESSION['_webby_previous_url'];

		// if () {

		// } 

	}

	/**
	 * Redirect routes
	 *
	 * @return self
	 */
	public function redirect()
	{
		if (!empty($this->getUri())) {
			redirect($this->getUri());
		}

		return $this;
	}

	/**
	 * Get a route with a given name
	 *
	 * @return static
	 */
	public function named($name = '')
	{
		return !empty($name) ? static::name($name) : '';
	}

	/**
	 * With method
	 *
	 * @param string $key
	 * @param string $value
	 * @return mixed
	 */
	public function with($key, $value = null)
	{

		ci('load')->library('session');

		if (is_array($key)) {
			ci()->session->set_flashdata($key);
		}

		if (!is_null($value) && is_string($key)) {
			ci()->session->set_flashdata($key, $value);
		}

		if (!empty($this->getUri())) {
			return $this->redirect();
		}
	}

	/**
	 * With Success
	 *
	 * @param string $message
	 * @return string
	 */
	public function withSuccess($message)
	{
		return $this->with('success_message', $message);
	}

	/**
	 * With Error
	 *
	 * @param string $message
	 * @return string
	 */
	public function withError($message)
	{
		return $this->with('error_message', $message);
	}

	/**
	 * With Input
	 * Grab all input fields and
	 * set to session to be accessed again
	 * 
	 * @return void
	 * 
	 */
	public function withInput($post = [])
	{
		ci('load')->library('session');

		if (empty($post)) {
			$post = ci()->input->post();
		}

		ci()->session->set_tempdata('old', $post, 10);
		ci()->session->set_tempdata('form_error', form_error_array(), 10);
		
		if (!empty($this->getUri())) {
			return $this->redirect();
		}

	}

	// ---------------------------- Route Energized -------------------------------

	/**
	 * Get all defined routes
	 *
	 * @return string
	 */
	public function allRoutes()
	{
		return self::getRouter()->routes;
	}

	/**
	 * Default routes
	 *
	 * @return mixed
	 */
	public static function defaultRoutes()
	{
		return static::$defaultRoutes = $GLOBALS['default_routes'];
	}

	/**
	 * Available routes
	 *
	 * @return mixed
	 */
	public static function availableRoutes()
	{
		return static::$availableRoutes = $GLOBALS['available_routes'];
	}

	/**
	 * API routes
	 *
	 * @return mixed
	 */
	public static function apiRoutes()
	{
		return static::$apiRoutes = $GLOBALS['api_routes'];
	}

	/* --------------------------------------------------------------
     * BASIC ROUTING
     * ------------------------------------------------------------ */

	/**
	 * Create and Generate All Routes
	 *
	 * @param string $from
	 * @param string $to
	 * @param array $options
	 * @param boolean $nested
	 * @return void
	 */
	protected static function createRoute($from, $to, $options = [], $nested = false)
	{
		$parameterfy = false;

		// Allow for array based routes and other symbol routes
		if (!is_array($to) && strstr($to, '.')) {
			$to = str_replace('.', '/', $to);
		}

		if (is_array($to)) {
			$to = $to[0] . '/' . strtolower($to[1]);
			$parameterfy = true;
		} elseif (
			preg_match('/^([a-zA-Z\_\-0-9\/]+)->([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)
		) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		} elseif (
			preg_match('/^([a-zA-Z\_\-0-9\/]+)::([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)
		) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		} elseif (
			preg_match('/^([a-zA-Z\_\-0-9\/]+)@([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)
		) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		}

		// Do we have a namespace?
		if (static::$namespace) {
			$from = static::$namespace . '/' . $from;
		}

		// Account for parameters in the URL if we need to
		if ($parameterfy) {
			$to = static::parameterfy($from, $to);
		}

		// Apply our routes
		static::$temporaryRoutes[$from] = $to;

		$prefix = is_null(static::$prefix) ? '' : static::$prefix . '/';

		$from = static::$nestedGroup . $prefix . $from;

		// Are we saving the name for this one?
		if (isset($options['as']) && !empty($options['as'])) {
			static::$namedRoutes[$options['as']] = $from;
		}

		static::$routes[$from] = $to;

		// Do we have a nested function?
		if ($nested && is_callable($nested) && static::$nestedDepth === 0) {
			static::$nestedGroup    .= rtrim($from, '/') . '/';
			static::$nestedDepth     += 1;
			call_user_func($nested);

			static::$nestedGroup = '';
		}
	}

	/**
	 * Static Route method
	 *
	 * @param string $from
	 * @param string $to
	 * @param boolean $nested
	 * @return void
	 */
	public static function route($from, $to, $nested = false)
	{
		$parameterfy = false;

		// Allow for array based routes and other symbol routes
		if (!is_array($to) && strstr($to, '.')) {
			$to = str_replace('.', '/', $to);
		}

		if (is_array($to)) {
			$to = $to[0] . '/' . strtolower($to[1]);
			$parameterfy = true;
		} elseif (
			preg_match('/^([a-zA-Z\_\-0-9\/]+)->([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)
		) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		} elseif (
			preg_match('/^([a-zA-Z\_\-0-9\/]+)::([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)
		) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		} elseif (
			preg_match('/^([a-zA-Z\_\-0-9\/]+)@([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)
		) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		}

		// Do we have a namespace?
		if (static::$namespace) {
			$from = static::$namespace . '/' . $from;
		}

		// Account for parameters in the URL if we need to
		if ($parameterfy) {
			$to = static::parameterfy($from, $to);
		}

		// Apply our routes
		static::$temporaryRoutes[$from] = $to;

		$prefix = is_null(static::$prefix) ? '' : static::$prefix . '/';

		$from = static::$nestedGroup . $prefix . $from;

		static::$routes[$from] = $to;

		// Do we have a nested function?
		if ($nested && is_callable($nested) && static::$nestedDepth === 0) {
			static::$nestedGroup    .= rtrim($from, '/') . '/';
			static::$nestedDepth     += 1;
			call_user_func($nested);

			static::$nestedGroup = '';
		}
	}

	public static function any($from, $to, $options = [], $nested = false)
	{
		static::createRoute($from, $to, $options, $nested);
	}

	/* --------------------------------------------------------------
     * HTTP VERB ROUTING
     * ------------------------------------------------------------ */

	/**
	 * Get route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function get($from, $to, $options = [], $nested = false)
	{
		if (static::methodIs('GET')) {
			static::createRoute($from, $to, $options, $nested);
		}
	}

	/**
	 * Post route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function post($from, $to, $options = [], $nested = false)
	{
		if (static::methodIs('POST')) {
			static::createRoute($from, $to, $options, $nested);
		}
	}

	/**
	 * Put route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function put($from, $to, $options = [], $nested = false)
	{
		if (static::methodIs('PUT')) {
			static::createRoute($from, $to, $options, $nested);
		}
	}

	/**
	 * Delete route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function delete($from, $to, $options = [], $nested = false)
	{
		if (static::methodIs('DELETE')) {
			static::createRoute($from, $to, $options, $nested);
		}
	}

	/**
	 * Patch route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function patch($from, $to, $options = [], $nested = false)
	{
		if (static::methodIs('PATCH')) {
			static::createRoute($from, $to, $options, $nested);
		}
	}

	/**
	 * Head route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function head($from, $to, $options = [], $nested = false)
	{
		if (
			isset($_SERVER['REQUEST_METHOD']) &&
			$_SERVER['REQUEST_METHOD'] == 'HEAD'
		) {
			static::createRoute($from, $to, $options, $nested);
		}
	}

	/**
	 * Options route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function options($from, $to, $options = [], $nested = false)
	{
		if (
			isset($_SERVER['REQUEST_METHOD']) &&
			$_SERVER['REQUEST_METHOD'] == 'OPTIONS'
		) {
			static::createRoute($from, $to, $options, $nested);
		}
	}

	/**
	 * Cli route
	 *
	 * @param string $from
	 * @param string $to
	 * @param array $options
	 * @param boolean $nested
	 * @return void
	 */
	public static function cli($from, $to, $options = [], $nested = false)
	{
		if (is_cli()) {
			static::createRoute($from, $to, $options, $nested);
		}
	}

	/**
	 * Simple route to get views
	 * from the Views folder
	 *
	 * @param  $name  view name to use as route
	 * @return void
	 */
	public static function view($name = '')
	{
		static::any($name, static::routeView().$name);
	}

	/**
	 * Web Resource method
	 * Creates resource routes
	 *
	 * @param string $name i.e. module/controller name
	 * @param boolean $hasController
	 * @return void
	 */
	public static function webResource($name, $hasController = true)
	{
		$name = str_replace('/', '.', $name);
		$name = explode('.', $name);
		$module = $name[0];
		$controller = !isset($name[1]) ? $module : $name[1];

		$moc = static::setMOC($module, $controller, $hasController);

		$name = str_replace('.', '/', implode('.', $name));

		static::get($name . '/list', $moc . '/index');
		static::get($name . '/show/(:any)', $moc . '/show/$1');
		static::get($name . '/create', $moc . '/create');
		static::post($name . '/save', $moc . '/store');
		static::get($name . '/edit/(:any)', $moc . '/edit/$1');
		static::put($name . '/update/(:any)', $moc . '/update/$1');
		static::delete($name . '/delete/(:any)', $moc . '/delete/$1');
	}

	/**
	 * Alias to method above
	 *
	 * @param string $name
	 * @param boolean $hasController
	 * @return void
	 */
	public static function uselinks($name, $hasController = true)
	{
		static::webResource($name, $hasController);
	}

	/**
	 * Alias to method above
	 *
	 * @param string $name
	 * @param boolean $hasController
	 * @return void
	 */
	public static function web($name, $hasController = true)
	{
		static::webResource($name, $hasController);
	}

	/**
	 * Send routes outside of application
	 *
	 * @param string $name
	 * @param string $to
	 * @param string $route
	 * @return void
	 */
	public static function outside($name, $to = '', $route = '')
	{

		$parameterfy = false;

		if (is_array($to)) {
			$to = $to[0] . '/' . strtolower($to[1]);
			$parameterfy = true;
		} elseif (preg_match('/^([a-zA-Z\_\-0-9\/]+)->([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		} elseif (preg_match('/^([a-zA-Z\_\-0-9\/]+)::([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		} elseif (preg_match('/^([a-zA-Z\_\-0-9\/]+)@([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)) {
			$to = $matches[1] . '/' . $matches[2];
			$parameterfy = true;
		}

		// Account for parameters in the URL if we need to
		if ($parameterfy) {
			$to = static::parameterfy($name, $to);
		}

		if (empty($route)) {
			$route = config_item('default_outside_route');
		}

		// Apply our routes
		static::$temporaryRoutes[$name] = $to;
		
		static::$routes[$name] = $route .'/'. $to;

	}

	/**
	 * Api Resource method
	 * Creates resource routes
	 *
	 * @param string $name i.e. module/controller name
	 * @param boolean $hasController
	 * @return void
	 */
	public static function apiResource($name, $hasController = true)
	{
		$name = str_replace('/', '.', $name);
		$name = explode('.', $name);
		$module = $name[0];
		$controller = !isset($name[1]) ? $module : $name[1];

		$moc = static::setMOC($module, $controller, $hasController);

		$name = str_replace('.', '/', implode('.', $name));

		static::get($name . '/list', $moc . '/index');
		static::get($name . '/show/(:any)', $moc . '/show/$1');
		static::get($name . '/create', $moc . '/create');
		static::post($name . '/save', $moc . '/store');
		static::get($name . '/edit/(:any)', $moc . '/edit/$1');
		static::put($name . '/update/(:any)', $moc . '/update/$1');
		static::delete($name . '/delete/(:any)', $moc . '/delete/$1');
	}

	/**
	 * Alias to method above
	 *
	 * @param string $name
	 * @param boolean $hasController
	 * @return void
	 */
	public static function api($name, $hasController = true)
	{
		static::apiResource($name, $hasController);
	}

	/**
	 * Partial Web Resource which 
	 * Creates partial resource routes
	 *
	 * @param string $name
	 * @param array $method
	 * @param boolean $hasController
	 * @return void
	 */
	public static function partial($name, $method = [], $hasController = true)
	{
		$name = str_replace('/', '.', $name);
		$name = explode('.', $name);
		$module = $name[0];
		$controller = !isset($name[1]) ? $module : $name[1];

		$moc = static::setMOC($module, $controller, $hasController);

		$name = str_replace('.', '/', implode('.', $name));

		static::setRouteSignature($name, $method, $moc);
	}

	/**
	 * Unique Route Signature
	 *
	 * @param string $route
	 * @param string $signature
	 * @param boolean $hasController
	 * @return void
	 */
	public static function unique($route, $signature, $hasController = true)
	{
		[$name, $as] = $route;

		$name = str_replace('/', '.', $name);
		$name = explode('.', $name);
		$module = $name[0];
		$controller = !isset($name[1]) ? $module : $name[1];

		$moc = static::setMOC($module, $controller, $hasController);

		$name = str_replace('.', '/', implode('.', $name));

		static::any($name . $as, $moc . $signature);
	}

	/**
	 * Set True http routes
	 *
	 * @param string $route
	 * @param string $httpMethod
	 * @param string $signature
	 * @return void
	 */
	public static function http($httpMethod, $route, $signature)
	{
		static::setRouteHttpMethod($route, $httpMethod, $signature);
	}

	/**
	 * Creates Semi HTTP-verb based routing for a module/controller.
	 *
	 * @param  string $name The name of the controller to route to.
	 * @param  array $options A list of possible ways to customize the routing.
	 */
	public static function resources($name, $options = [], $nested = false, $hasController = true)
	{
		if (empty($name)) {
			return;
		}

		$nestOffset = '';

		// In order to allow customization of the route the
		// resources are sent to, we need to have a new name
		// to store the values in.
		$givenName = $name;

		// If a new controller is specified, then we replace the
		// $name value with the name of the new controller.
		if (isset($options['controller'])) {
			$givenName = $options['controller'];
		}

		// If a new module was specified, simply put that path
		// in front of the controller.
		if (isset($options['module'])) {
			$givenName = $options['module'] . '/' . $givenName;
		}

		// In order to allow customization of allowed id values
		// we need someplace to store them.
		$id = static::$routeRegex;

		if (isset($options['constraint'])) {
			$id = $options['constraint'];
		}

		// If the 'offset' option is passed in, it means that all of our
		// parameter placeholders in the $to ($1, $2, etc), need to be
		// offset by that amount. This is useful when we're using an API
		// with versioning in the URL.
		$offset = isset($options['offset']) ? (int)$options['offset'] : 0;

		if (static::$nestedDepth) {
			$nestOffset = '/$1';
			$offset++;
		}

		$newName = str_replace('/', '.', $givenName);
		$newName = explode('.', $newName);
		$module = $newName[0];
		$controller = !isset($newName[1]) ? $module : $newName[1];

		$moc = static::setMOC($module, $controller, $hasController);

		$newName = str_replace('.', '/', implode('.', $newName));

		static::get($name, $moc . '/index' . $nestOffset, null, $nested);
		static::get($name    . '/create', $moc . '/create' . $nestOffset, null, $nested);
		static::get($name    . '/' . '(:any)' . '/edit', $moc . '/edit' . $nestOffset . '/$' . (1 + $offset), null, $nested);
		static::get($name    . '/' . '(:any)', $moc . '/show' . $nestOffset . '/$' . (1 + $offset), null, $nested);
		static::post($name   . '/save', $moc . '/store' . $nestOffset, null, $nested);
		static::put($name    . '/' . '(:any)' . '/update', $moc . '/update' . $nestOffset . '/$' . (1 + $offset), null, $nested);
		static::delete($name . '/' . '(:any)' . '/delete', $moc . '/delete' . $nestOffset . '/$' . (1 + $offset), null, $nested);
	}

	/* --------------------------------------------------------------
     * UTILITY FUNCTIONS
     * ------------------------------------------------------------ */

	/**
	 * Set MoC (Module on Controller)
	 *
	 * @param  string $module
	 * @param string $controller
	 * @param boolean $hasController
	 * @return string
	 */
	private static function setMOC($module, $controller, $hasController)
	{
		$moc = ucfirst($module) . '/' . ucfirst($controller);

		if ($hasController && $controller) {
			$controller = ucfirst(Inflector::singularize($controller)) . "Controller";
			$moc = ucfirst($module) . '/' . $controller;
		}

		return $moc;
	}

	/**
	 * Set Route Signature
	 * Used for special cases
	 *
	 * @param $name
	 * @param mixed $method
	 * @param mixed $moc
	 * @return void
	 */
	private static function setRouteSignature($name, $method, $moc)
	{
		if (in_array('index', $method)) {
			static::get($name . '/list', $moc . '/index');
		}

		if (in_array('show', $method)) {
			static::get($name . '/show/(:any)', $moc . '/show/$1');
		}

		if (in_array('create', $method)) {
			static::get($name . '/create', $moc . '/create');
		}

		if (in_array('store', $method)) {
			static::post($name . '/save', $moc . '/store');
		}

		if (in_array('edit', $method)) {
			static::get($name . '/edit/(:any)', $moc . '/edit/$1');
		}

		if (in_array('update', $method)) {
			static::put($name . '/update/(:any)', $moc . '/update/$1');
		}

		if (in_array('delete', $method)) {
			static::delete($name . '/delete/(:any)', $moc . '/delete/$1');
		}
	}

	/**
	 * Set Route Using HTTP Method
	 * Used to mimic old $routes with HTTP Methods
	 *
	 * Example : $route['some-route-here']['GET'] = 'Module/Controller/method/parameter'
	 * 
	 * @param $name
	 * @param mixed $method
	 * @param mixed $signature
	 * @return void
	 */
	private static function setRouteHttpMethod($name, $httpMethod, $signature)
	{
		$httpMethods = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];
		$httpMethod = strtoupper($httpMethod);

		if (in_array($httpMethod, $httpMethods)) {
			static::{strtolower($httpMethod)}($name, $signature);
		}

	}

	/**
	 * Prefix routes
	 *
	 * @param  string  $name  The prefix to add to the routes.
	 * @param  Closure $callback
	 */
	protected static function prefix($name, Closure $callback)
	{
		static::$prefix = $name;
		call_user_func($callback);
		static::$prefix = null;
	}

	/**
	 * Group routes
	 *
	 * @param string $from
	 * @param string $to
	 * 
	 */
	public static function group($name, Closure $callable = null)
	{
		static::prefix($name, $callable);
	}

	/**
	 * Group Module routes
	 *
	 * @param string $from
	 * @param string $to
	 * 
	 */
	public static function module($name, Closure $callable = null)
	{
		static::prefix($name, $callable);
	}

	/**
	 * Set a name for defined route
	 * 
	 * @param string $name
	 * @return string|mixed
	 */
	public static function name($name)
	{
		if (isset(self::$namedRoutes[$name])) {
			return self::$namedRoutes[$name];
		}

		return null;
	}

	/**
	 * Easily block access to any number of routes by setting
	 * that route to an empty path ('').
	 *
	 * Example:
	 *     Route::block('posts', 'photos/(:num)');
	 *
	 *     // Same as...
	 *     $route['posts']          = '';
	 *     $route['photos/(:num)']  = '';
	 */
	public static function block()
	{
		$paths = func_get_args();

		if (!is_array($paths)) {
			return;
		}

		foreach ($paths as $path) {
			static::createRoute($path, '');
		}
	}

	/**
	 * Clear out the routing table
	 * @return mixed
	 */
	public static function clear()
	{
		static::$routes = [];
	}

	/**
	 * Resets the class to a first-load state. Mainly useful during testing.
	 *
	 * @return void
	 */
	public static function reset()
	{
		static::$routes = [];
		static::$namedRoutes     = [];
		static::$nestedDepth     = 0;
	}

	/**
	 * Return the routes array
	 *
	 * Used as a helper in HMVC Routing
	 * 
	 * @param array $route
	 * @return array
	 */
	public static function build(array $route = [])
	{

		if (empty($route)) {
			$route = static::availableRoutes();
		}

		return array_merge(
			$route,
			static::$routes,
		);
	}

	/**
	 * Alias to above function
	 *
	 * @param array $route
	 * @return array
	 */
	public static function include(array $route = [])
	{
		return static::build($route);
	}

	/**
	 * Extract the URL parameters 
	 * from $from and copy to $to
	 *
	 * @param string $from
	 * @param string $to
	 * @return string
	 */
	private static function parameterfy($from, $to)
	{
		if (preg_match_all('/\/\((.*?)\)/', $from, $matches)) {

			$params = '';

			foreach ($matches[1] as $i => $match) {
				$i = $i + 1;
				$params .= "/\$$i";
			}

			$to .= $params;
		}

		return $to;
	}

	/**
	 * Verify Http Method
	 * 
	 * And check whether it is to be 
	 * strictly true http method or not
	 *
	 * @param string $method
	 * @return mixed
	 */
	protected static function methodIs($method)
	{
		return (static::$trueHttp === false)
			? $method
			: (isset($_SERVER['REQUEST_METHOD']) &&
				($_SERVER['REQUEST_METHOD'] == $method ||
					($_SERVER['REQUEST_METHOD'] == 'POST' &&
						isset($_POST['_method']) &&
						strtolower($_POST['_method']) == strtolower($method))));
	}

	/**
	 * Include other route files
	 *
	 * @param string $routeFile
	 * @return void
	 */
	public static function import(string $routeFile, $outsourced = false): void
    {
		if (!$outsourced) {
        	include_once(ROOTPATH .'routes'.DS.$routeFile.EXT);
		}

		if ($outsourced) {
        	include_once($routeFile);
		}
		
    }

}
