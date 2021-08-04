<?php

/**
 * Intelligent, elegant routing for CodeIgniter
 *
 * @link http://github.com/jamierumbelow/pigeon
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 * 
 * Initially deprecated and not maintained by the author
 * 
 * This implementation by Jamie Rumblelow is great so I decided to 
 * implement it and make a little modification to work with Webby
 * 
 * @author Kwame Oteng Appiah-Nti (Developer Kwame)
 */

namespace Base\Route;

class Route 
{

	/**
     * Routes array
     *
     * @var array
     */
	// public $routes = [];

    /**
     * Temporary routes array
     *
     * @var array
     */
	// public $temporary_routes = [];

    /**
     * Route namespace
     *
     * @var string
     */
	// public $namespace = '';


	public static $routes = [];

	public static $router = [];

	public static $temporary_routes = [];

	public static $defaultRoutes = [];

	public static $availableRoutes = [];

	public static $apiRoutes = [];

	public static $routeRegex = '([a-zA-Z0-9\-_]+)';

	public static $namespace = '';

	public static $trueHttp = false;

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

    public function __construct($namespace = false)
	{
		if ($namespace) {
			static::$namespace = $namespace;
		}
	}

	public static function getRouter()
	{
		return static::$router = ci()->router;
	}

    private function getUri() 
	{
		return $this->uri;
	}
    
    public function setRoute($uri = null)
	{
		if ( ! empty($uri)) {
			$this->uri = ci()->config->site_url($uri);
		} 

		if ($uri === null) {
			$this->uri = ci()->config->site_url('');
		}

		return $this;
	}

    public function to($uri = '') 
	{
		$this->uri = ci()->config->site_url($uri);

		if (empty($this->uri) || is_null($this->uri)) {
			return $this->uri = '';
		}
		
		return $this;
	}

	public function back($uri = '')
	{

		$referer = $_SESSION['_webby_previous_url'] ?? ci()->input->server('HTTP_REFERER', FILTER_SANITIZE_URL);

		$referer = $referer ?? site_url('/');

		if (empty($uri)) {
			$this->uri = $referer;
			return $this;
		}

		if ( ! empty($uri)) {
			$uri = site_url($uri);
		}

		$referer = $uri;
		
		return redirect($referer);

	}

	// public function setReferrer($value)
	// {
	// 	$_SESSION['_webby_previous_url'] = $value;
		
	// 	$this->refferer = $_SESSION['_webby_previous_url'];

	// 	if () {

	// 	} 

	// }

	public function redirect() 
	{

		if ( ! empty($this->getUri())) {
			redirect($this->getUri());
		}

		return $this;
	}

	public function with($key, $value=null) 
	{

		ci('load')->library('session');

		if (is_array($key)) {
            ci()->session->set_flashdata($key);
        }

        if ( ! is_null($value) && is_string($key)) {
            ci()->session->set_flashdata($key, $value);
        }

		if ( ! empty($this->getUri())) {
			return $this->redirect();
		}
	}

	// @Todo work on grabbing input
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

	public static function defaultRoutes()
	{
		return static::$defaultRoutes = $GLOBALS['default_routes'];
	}

	public static function availableRoutes()
	{
		return static::$availableRoutes = $GLOBALS['available_routes'];
	}

	public static function apiRoutes()
	{
		return static::$apiRoutes = $GLOBALS['api_routes'];
	}

	/* --------------------------------------------------------------
     * BASIC ROUTING
     * ------------------------------------------------------------ */
	// @Todo To be implemented
	private static function prefix($namespace, /*Closure*/ $callable = null) 
	{
		static::$namespace = $namespace;

		$main_routes = [
			self::CONSOLE_ROUTE, 
			self::WEB_ROUTE, 
			self::RESTFUL_ROUTE
		];

		if (in_array($namespace, $main_routes)) {

		}

	}

	public static function route($from, $to, $nested = false)
	{
		$parameterfy = false;

		// Allow for array based routes and hashrouters
		if (is_array($to)) {
			$to = strtolower($to[0]) . '/' . strtolower($to[1]);
			$parameterfy = true;
		} elseif (
			preg_match('/^([a-zA-Z\_\-0-9\/]+)->([a-zA-Z\_\-0-9\/]+)$/m', $to, $matches)
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
		static::$temporary_routes[$from] = $to;

		// Do we have a nesting function?
		if ($nested && is_callable($nested)) {
			$nested_route = new Route($from);
			call_user_func_array($nested, array( &$nested_route ));
			static::$temporary_routes = array_merge(static::$temporary_routes, $nested_route->temporary_routes);
		}

		static::$routes = static::$temporary_routes;
	}

	public static function any($from, $to, $nested = false)
	{
		static::route($from, $to, $nested);
	}

	/* --------------------------------------------------------------
     * HTTP VERB ROUTING
     * ------------------------------------------------------------ */
	public static function get($from, $to)
	{
		if (static::methodIs('GET')) {
			static::route($from, $to);
		}
	}

	public static function post($from, $to)
	{
		if (static::methodIs('POST')) {
			static::route($from, $to);
		}
	}

	public static function put($from, $to)
	{
		if (static::methodIs('PUT')) {
			static::route($from, $to);
		}
	}

	public static function delete($from, $to)
	{
		if (static::methodIs('DELETE')) {
			static::route($from, $to);
		}
	}

	public static function patch($from, $to)
	{
		if (static::methodIs('PATCH')) {
			static::route($from, $to);
		}
	}

	public static function head($from, $to)
	{
		if (
			isset($_SERVER['REQUEST_METHOD']) && 
			$_SERVER['REQUEST_METHOD'] == 'HEAD'
		) {
			static::route($from, $to);
		}
	}

	public static function options($from, $to)
	{
		if (
			isset($_SERVER['REQUEST_METHOD']) && 
			$_SERVER['REQUEST_METHOD'] == 'OPTIONS'
		) {
			static::route($from, $to);
		}
	}

	/* --------------------------------------------------------------
     * RESTFUL ROUTING
     * ------------------------------------------------------------ */

	public static function resources($name, $nested = false, $html_friendly = false)
    {
        static::get($name, $name . '->index');
        static::get($name . '/new', $name . '->create_new');
        static::get($name . '/'. static::$routeRegex.'/edit', $name . '->edit');
        static::get($name . '/'. static::$routeRegex, $name . '->show');
        static::post($name, $name . '->create');

        if ($html_friendly) {
            static::post($name . '/'. static::$routeRegex, $name . '->update');
            static::get($name . '/'. static::$routeRegex.'/delete', $name . '->delete');
        } else {
            static::put($name . '/'. static::$routeRegex, $name . '->update');
            static::delete($name . '/'. static::$routeRegex, $name . '->delete');   
        }
        
		if ($nested && is_callable($nested)) {
			$nested_route = new Route($name . '/'. static::$routeRegex);
			call_user_func_array($nested, array( &$nested_route ));
			static::$temporary_routes = array_merge(
				static::$temporary_routes, 
				$nested_route::$temporary_routes
			);
		}
	}

	public static function resource($name, $nested = false)
	{
		static::get($name, $name . '/show');
		static::get($name . '/new', $name . '/create_new');
		static::get($name . '/edit', $name . '/edit');
		static::post($name, $name . '/create');
		static::put($name, $name . '/update');
		static::delete($name, $name . '/delete');

		if ($nested && is_callable($nested)) {
			$nested_route = new Route($name);
			call_user_func_array($nested, [&$nested_route]);
			static::$temporary_routes = array_merge(
				static::$temporary_routes, 
				$nested_route::$temporary_routes
			);
		}
	}

	/* --------------------------------------------------------------
     * UTILITY FUNCTIONS
     * ------------------------------------------------------------ */

	/**
	 * Clear out the routing table
	 */
	public static function clear()
	{
		static::$routes = [];
	}

	/**
	 * Return the routes array
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
	 * Extract the URL parameters from $from and copy to $to
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
