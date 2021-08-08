<?php defined('COREPATH') OR exit('No direct script access allowed');

/* load the MX_Loader class */
require_once ENGINEPATH . "/MX/Loader.php";

class Base_Loader extends MX_Loader {

	/**
     * List of loaded services
     *
     * @var array
     * @access protected
     */
    protected $_ci_services = [];

    /**
     * List of paths to load services from
     *
     * @var array
     * @access protected
     */
    protected $_ci_service_paths = [];


	/**
     * List of loaded rules
     *
     * @var array
     * @access protected
     */
    protected $_ci_rules = [];

	/**
     * List of rules arrays
     *
     * @var array
     * @access protected
     */
    public $rules = [];

	/**
     * List of paths to load rules from
     *
     * @var array
     * @access protected
     */
    protected $_ci_rules_paths = [];
	
    /**
     * Constructor
     *
     * Set the path to the Service files
     */
    public function __construct()
    {

        parent::__construct();
        load_class('Service', 'core');
        // $this->_ci_service_paths = [COREPATH];
    }

    /**
     * Overriding module model function
     *
     * @param string|array $model
     * @param string $object_name
     * @param bool $connect
     * @return object
     */
	public function model($model, $object_name = null, $connect = false)
	{
		if (is_array($model)) {
            return $this->models($model);
        } 

		($_alias = $object_name) OR $_alias = basename($model);

		if (in_array($_alias, $this->_ci_models, true)) {
			return $this;
        }

		// Check module
		// This line allows CamelCasing names for models in modules
		list($path, $_model) = Modules::find($model, $this->_module, 'models/');
        
        /*
		 * Compare the two and know the differences. If you want to revert back use the one below
		*/
		// list($path, $_model) = Modules::find(strtolower($model), $this->_module, 'models/');

		if ($path == false) {
			// check corepath & packages and default locations 
			parent::model($model, $object_name, $connect);
		} else {
			class_exists('CI_Model', false) OR load_class('Model', 'core');

			if ($connect !== false && ! class_exists('CI_DB', false))
			{
				if ($connect === true) $connect = '';
				$this->database($connect, false, true);
			}

			Modules::load_file($_model, $path);

			$model = ucfirst($_model);
			CI::$APP->$_alias = new $model();

			$this->_ci_models[] = $_alias;
        }
        
		return $this;
	}

	/**
	 * Service Loader
     *
     * This function lets users load and instantiate services.
     * It is designed to be called a module's controllers.
     *
	 *
	 * @param string $service the name of the class
	 * @param mixed $params the optional parameters
	 * @param string $object_name an optional object name
	 * @return void
	 */
	public function service($service, $params = NULL, $object_name = NULL)
	{
		
		if (is_array($service)) return $this->services($service);
		
		$_service = basename($service);
		
		if (isset($this->_ci_services[$_service]) && $_alias = $this->_ci_services[$_service]) {
			return $this;
		}

		if ($service == '' or isset($this->_ci_services[$_service])) {
			return false;
		}

		if (!is_null($params) && !is_array($params)) {
			$params = null;
		}

		$subdir = '';
		
		// Is the service in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($service, '/')) !== false) {
			// The path is in front of the last slash
			$subdir = substr($service, 0, $last_slash + 1);

			// And the service name behind it
			$service = substr($service, $last_slash + 1);
		}

		($_alias = strtolower($object_name)) OR $_alias = $service;

		$service_path = $subdir . $service . PHPEXT;
		
		list($path, $_service) = Modules::find($service_path, $this->_module, 'services/');
		
		// load service config file as params 
		if ($params == NULL)
		{
			list($path2, $file) = Modules::find($_alias, $this->_module, 'config/');
			($path2) && $params = Modules::load_file($file, $path2, 'config');
		}

		if (!file_exists($path.$_service)) {
			show_error('Sorry! We couldn\'t find the service: '.$_service);
		}

		Modules::load_file($_service, $path);

		$service = ucfirst($service);
		CI::$APP->$_alias = new $service($params);

		$this->_ci_services[$service] = $_alias;
		return $this;
	}

	/**
	 * Load an array of services
	*
	* @param array $services
	* @return mixed
	*/
	public function services(array $services)
	{
		foreach ($services as $service => $alias) 
		{
			(is_int($service)) ? $this->service($alias) : $this->service($service, null, $alias);
		}
		return $this;
	}

	/**
	 * Rule Loader
     *
     * This function lets users load rules.
	 * That can used when validating forms 
     * It is designed to be called from a user's app
	 * It can be controllers or models
     *
	 * @param string $rule
	 * @return mixed
	 */
	public function rule($rule = [], $return_array = false)
	{
		if (is_array($rule)) return $this->rules($rule);

		if (isset($this->_ci_rules[$rule]))	return;
		
		list($path, $_rule) = Modules::find($rule, $this->_module, 'rules/');

		if ($path === false) /*return parent::helper($rule);*/
		show_error('Sorry! We couldn\'t find the rule: '.$_rule);

		Modules::load_file($_rule, $path);

		$this->_ci_rules[$_rule] = true;
		
		if ($return_array === true) {
			include ($path.$_rule.PHPEXT);
			$this->rules = $rules;
		}

		return $this;
	}

	/**
	 * Load an array of rules
	 *
	 * @param array $rules
	 * @return mixed
	 */
	public function rules($rules = [])
	{
		foreach ($rules as $_rule) $this->rule($_rule);
		return $this;
	}

}
/* end of file Base_Loader.php */