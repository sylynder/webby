<?php

/**
 * Intelligent, Elegant routing for Webby
 *
 * This implementation by Jamie Rumblelow is great so I decided to 
 * implement it and made much modification to work with Webby
 * 
 * @author Kwame Oteng Appiah-Nti (Developer Kwame)
 * 
 * Initially deprecated and not maintained by the author
 * @link http://github.com/jamierumbelow/pigeon
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 * 
 */

namespace Base\Route;

use Base\Helpers\Inflector;

class Route
{

	/**
	 * Routes array
	 *
	 * @var array
	 */
	public static $routes = [];

	/**
	 * Router array
	 *
	 * @var array
	 */
	public static $router = [];

	/**
	 * Temporary routes array
	 *
	 * @var array
	 */
	public static $temporaryRoutes = [];

	/**
	 * Default Routes array
	 *
	 * @var array
	 */
	public static $defaultRoutes = [];

	/**
	 * Available Routes array
	 *
	 * @var array
	 */
	public static $availableRoutes = [];

	/**
	 * Api Routes array
	 *
	 * @var array
	 */
	public static $apiRoutes = [];

	/**
	 * Route Regex variable
	 *
	 * @var string
	 */
	public static $routeRegex = '([a-zA-Z0-9\-_]+)';

	/**
	 * Route Namespace variable
	 *
	 * @var string
	 */
	public static $namespace = '';

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
	public function __construct($namespace = false)
	{
		if ($namespace) {
			static::$namespace = $namespace;
		}
	}

	// --------------------------- Utility functions ----------------------------------

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
	public function to($uri = '')
	{
		$uri = $this->toSlash($uri);

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

		if (!empty($uri)) {
			$uri = site_url($uri);
		}

		$referer = $uri;

		return redirect($referer);
	}

	/**
	 * Set Referrer
	 *
	 * @param string $value
	 * @return void
	 * 
	 * @Todo To be implemented
	 */
	public function setReferrer($value)
	{
		$value = $this->toSlash($value);

		$_SESSION['_webby_previous_url'] = $value;

		$this->refferer = $_SESSION['_webby_previous_url'];

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
	 *
	 * @return void
	 * 
	 * @Todo work on grabbing input
	 */
	public function withInput()
	{
		// $input = ci()->input();
		// $this->with($input);

		// return ci()->input();
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
	 * Group routes
	 *
	 * @param string $from
	 * @param string $to
	 * 
	 * @Todo To be implemented
	 */
	private static function group($namespace, /*Closure*/ $callable = null)
	{
		static::$namespace = $namespace;

		$mainRoutes = [
			self::CONSOLE_ROUTE,
			self::WEB_ROUTE,
			self::RESTFUL_ROUTE
		];

		if (in_array($namespace, $mainRoutes)) {
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

		// Do we have a nesting function?
		if ($nested && is_callable($nested)) {
			$nestedRoute = new Route($from);
			call_user_func_array($nested, array(&$nestedRoute));
			static::$temporaryRoutes = array_merge(static::$temporaryRoutes, $nestedRoute->temporaryRoutes);
		}

		static::$routes = static::$temporaryRoutes;
	}

	public static function any($from, $to, $nested = false)
	{
		static::route($from, $to, $nested);
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
	public static function get($from, $to)
	{
		if (static::methodIs('GET')) {
			static::route($from, $to);
		}
	}

	/**
	 * Post route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function post($from, $to)
	{
		if (static::methodIs('POST')) {
			static::route($from, $to);
		}
	}

	/**
	 * Put route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function put($from, $to)
	{
		if (static::methodIs('PUT')) {
			static::route($from, $to);
		}
	}

	/**
	 * Delete route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function delete($from, $to)
	{
		if (static::methodIs('DELETE')) {
			static::route($from, $to);
		}
	}

	/**
	 * Patch route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function patch($from, $to)
	{
		if (static::methodIs('PATCH')) {
			static::route($from, $to);
		}
	}

	/**
	 * Head route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function head($from, $to)
	{
		if (
			isset($_SERVER['REQUEST_METHOD']) &&
			$_SERVER['REQUEST_METHOD'] == 'HEAD'
		) {
			static::route($from, $to);
		}
	}

	/**
	 * Options route
	 *
	 * @param string $from
	 * @param string $to
	 * @return void
	 */
	public static function options($from, $to)
	{
		if (
			isset($_SERVER['REQUEST_METHOD']) &&
			$_SERVER['REQUEST_METHOD'] == 'OPTIONS'
		) {
			static::route($from, $to);
		}
	}

	/**
	 * Web Resource method
	 * Creates resource routes
	 *
	 * @param string $name
	 * @param boolean $hasController
	 * @return void
	 */
	public static function webResource($name, $hasController = true)
	{
		$name = str_replace('/', '.', $name);

		list($module, $controller) = explode('.', $name);

		$moc = ucfirst($module) . '/' . ucfirst($controller);

		if ($hasController) {
			$controller = ucfirst(Inflector::singularize($controller)) . "Controller";
			$moc = ucfirst($module) . '/' . $controller;
		}

		static::get($name . '/list', $moc . '/index');
		static::get($name . '/show/(:any)', $moc . '/show/$1');
		static::get($name . '/create', $moc . '/create');
		static::post($name . '/save', $moc . '/save');
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

	/* --------------------------------------------------------------
     * UTILITY FUNCTIONS
     * ------------------------------------------------------------ */

	/**
	 * Clear out the routing table
	 * @return mixed
	 */
	public static function clear()
	{
		static::$routes = [];
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
	 * Extract the URL parameters 
	 * from $from and copy to $to
	 *
	 * @param string $from
	 * @param string $to
	 * @return string
	 */
	public static function parameterfy($from, $to)
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
	 * strictly true or not
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
}
