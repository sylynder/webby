<?php 
defined('COREPATH') or exit('No direct script access allowed');

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
	 * List of loaded actions
	 *
	 * @var array
	 * @access protected
	 */
	protected $_webby_actions = [];

	/**
	 * List of paths to load actions from
	 *
	 * @var array
	 * @access protected
	 */
	protected $_webby_action_paths = [];

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
	 * List of loaded forms
	 *
	 * @var array
	 * @access protected
	 */
	protected $_webby_forms = [];

	/**
	 * List of paths to load forms from
	 *
	 * @var array
	 * @access protected
	 */
	protected $_webby_form_paths = [];
	
    /**
     * Constructor
     *
     * Set the path to the Service files
     */
    public function __construct()
    {

        parent::__construct();

        load_class('Service', 'core'); // Load service core class
		load_class('Action', 'core'); // Load action core class

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
		list($path, $_model) = Modules::find($model, $this->_module, 'Models/');
        
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
	 * Action Loader
	 *
	 * This function lets users load and instantiate actions.
	 * It is designed to be called in a module's controllers.
	 *
	 *
	 * @param string $action the name of the class
	 * @return void
	 */
	public function action($action)
	{

		if (is_array($action)) return $this->actions($action);

		$_action = basename($action);

		if (isset($this->_webby_actions[$_action]) && $_alias = $this->_webby_actions[$_action]) {
			return $this;
		}

		if ($action == '' or isset($this->_webby_actions[$_action])) {
			return false;
		}

		$subdir = '';

		// Is the action in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($action, '/')) !== false) {
			// The path is in front of the last slash
			$subdir = substr($action, 0, $last_slash + 1);

			// And the action name behind it
			$action = substr($action, $last_slash + 1);
		}

		// Quick fix for PHP8.1
		$_alias = $action;

		$action_path = $subdir . $action . PHPEXT;

		list($path, $_action) = Modules::find($action_path, $this->_module, 'Actions/');

		if (!file_exists($path . $_action)) {
			show_error($_action . ' was not found, Are you sure the action file exists?');
		}

		Modules::load_file($_action, $path);

		$action = ucfirst($action);
		CI::$APP->$_alias = new $action;

		$this->_webby_actions[$action] = $_alias;

		return $this;
	}

	/**
	 * Load an array of actions
	 *
	 * @param array $actions
	 * @return mixed
	 */
	public function actions(array $services)
	{
		foreach ($services as $service => $alias) {
			(is_int($service)) ? $this->service($alias) : $this->service($service, null, $alias);
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
	public function service($service, $params = null, $object_name = null)
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

		// Quick fix for PHP8.1
		$object_name = !is_null($object_name) ? $object_name : '';

		($_alias = strtolower($object_name)) OR $_alias = $service;

		$service_path = $subdir . $service . PHPEXT;
		
		list($path, $_service) = Modules::find($service_path, $this->_module, 'Services/');
		
		// load service config file as params 
		if ($params == null)
		{
			list($path2, $file) = Modules::find($_alias, $this->_module, 'Config/');
			($path2) && $params = Modules::load_file($file, $path2, 'config');
		}

		if (!file_exists($path.$_service)) {
			show_error($_service . ' was not found, Are you sure the service file exists?');
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
		
		list($path, $_rule) = Modules::find($rule, $this->_module, 'Rules/');

		if ($path === false) /*return parent::helper($rule);*/

		show_error($_rule. 'was not found, Are you sure the rule file exists');

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

	/**
	 * Form Loader
	 *
	 * This function lets users load forms
	 * That can used when validating forms 
	 * 
	 * It works the same as the rule method
	 * It is designed to be called from a user's app
	 * It can be controllers or models
	 *
	 * @param string $form
	 * @return mixed
	 */
	public function form($form = [])
	{
		if (is_array($form)) return $this->forms($form);

		if (isset($this->_webby_forms[$form]))	return;

		list($path, $_form) = Modules::find($form, $this->_module, 'Forms/');

		if ($path === false)

		show_error($_form. 'was not found, Are you sure the form file exists');

		Modules::load_file($_form, $path);

		$this->_webby_forms[$_form] = true;

		return $this;
	}

	/**
	 * Load an array of forms
	 *
	 * @param array $forms
	 * @return mixed
	 */
	public function forms($forms = [])
	{
		foreach ($forms as $_form) $this->form($_form);
		return $this;
	}

}
/* end of file Base_Loader.php */
