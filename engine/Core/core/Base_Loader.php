<?php defined('COREPATH') OR exit('No direct script access allowed');

/* load the MX_Loader class */
require_once ENGINEPATH . "/MX/Loader.php";

class Base_Loader extends MX_Loader {

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

}
/* end of file Base_Loader.php */