<?php
defined('COREPATH') or exit('No direct script access allowed');

class Base_Exceptions extends \CI_Exceptions
{

	/**
	 * List of available error levels
	 *
	 * @var	array
	 */
	public $levels = [
		E_ERROR			=>	'Error',
		E_WARNING		=>	'Warning',
		E_PARSE			=>	'Parsing Error',
		E_NOTICE		=>	'Notice',
		E_CORE_ERROR		=>	'Core Error',
		E_CORE_WARNING		=>	'Core Warning',
		E_COMPILE_ERROR		=>	'Compile Error',
		E_COMPILE_WARNING	=>	'Compile Warning',
		E_USER_ERROR		=>	'User Error',
		E_USER_WARNING		=>	'User Warning',
		E_USER_NOTICE		=>	'User Notice',
		E_STRICT		=>	'Runtime Notice',
		E_DEPRECATED => "Deprecated"
	];

	public function __construct()
	{
		parent::__construct();
	}

	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		$templates_path = config_item('error_views_path');

		if (empty($templates_path)) {
			$templates_path = VIEWPATH . 'errors' . DIRECTORY_SEPARATOR;
		}

		if (is_cli()) {
			$message = "\t" . (is_array($message) ? implode("\n\t", $message) : $message);
			$template = 'cli' . DIRECTORY_SEPARATOR . $template;
		} else {
			set_status_header($status_code);
			$message = '<p>' . (is_array($message) ? implode('</p><p>', $message) : $message) . '</p>';
			$template = 'html' . DIRECTORY_SEPARATOR . $template;

			if ($status_code == 404) {
				list($main, $sub, $file) = explode('/', config_item('app_error_view'));
				$template = $sub . DIRECTORY_SEPARATOR . $file;
			}
		}

		if (ob_get_level() > $this->ob_level + 1) {
			ob_end_flush();
		}

		ob_start();

		if (!is_cli() && $status_code == 404) {
			include($templates_path . $template . config_item('plate_extension'));
		} else {
			include($templates_path . $template . '.php');
		}

		$buffer = ob_get_contents();

		ob_end_clean();
		
		return $buffer;
	}

	public function show_exception($exception)
	{
		$evaluated = false;

		$templates_path = config_item('error_views_path');

		if (empty($templates_path)) {
			$templates_path = VIEWPATH . 'errors' . DIRECTORY_SEPARATOR;
		}

		if (strpos($exception->getFile(), "eval()'d code") !== false) {
			$evaluated = true;
		}

		// @Todo
		$currentClass = $currentMethod = $source = '';
		
		if (isset($GLOBALS['CI']) && isset($GLOBALS['method'])) {
			$currentClass = $GLOBALS['CI'];
			$currentMethod = $GLOBALS['method'];
		}

		if (!is_string($currentMethod) && $currentMethod == 'handle' && get_class($currentClass) == 'Error') {
			show_404();
		}

		if (!is_string($currentClass) && get_class($currentClass) == 'Error') {
			show_404();
		}

		$line = $exception->getLine();
		$location = str_replace('../', '', get_instance()->router->directory);
		$message = $exception->getMessage();

		if (empty($message)) {
			$message = '(null)';
		}

		if (is_cli()) {
			$templates_path .= 'cli' . DIRECTORY_SEPARATOR;
		} else {
			$templates_path .= 'html' . DIRECTORY_SEPARATOR;
		}

		if (ob_get_level() > $this->ob_level + 1) {
			ob_end_flush();
		}

		ob_start();

		include($templates_path . 'error_exception.php');

		$buffer = ob_get_contents();

		ob_end_clean();

		echo $buffer;
	}

	// --------------------------------------------------------------------

	/**
	 * Native PHP error handler
	 *
	 * @param	int	$severity	Error level
	 * @param	string	$message	Error message
	 * @param	string	$filepath	File path
	 * @param	int	$line		Line number
	 * @return	void
	 */
	public function show_php_error($severity, $message, $filepath, $line)
	{
		$evaluated = false;

		$templates_path = config_item('error_views_path');

		if (empty($templates_path)) {
			$templates_path = VIEWPATH . 'errors' . DIRECTORY_SEPARATOR;
		}

		$location = str_replace('../', '', get_instance()->router->directory);
		$filelocation = $filepath;
		$severity = isset($this->levels[$severity]) ? $this->levels[$severity] : $severity;

		if (strpos($filepath, "eval()'d code") !== false) {
			$evaluated = true;
		}

		// For safety reasons we don't show the full file path in non-CLI requests
		if (!is_cli()) {

			$filepath = str_replace('\\', '/', $filepath);

			if (false !== strpos($filepath, '/')) {
				$x = explode('/', $filepath);
				$filepath = $x[count($x) - 2] . '/' . end($x);
			}

			$template = 'html' . DIRECTORY_SEPARATOR . 'error_php';

		} else {
			$template = 'cli' . DIRECTORY_SEPARATOR . 'error_php';
		}

		if (ob_get_level() > $this->ob_level + 1) {
			ob_end_flush();
		}
		
		ob_start();

		include($templates_path . $template . '.php');

		$buffer = ob_get_contents();

		ob_end_clean();
		
		echo $buffer;
	}

}
/* end of file Base_Exceptions.php */
