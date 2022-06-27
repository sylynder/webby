<?php 
defined('COREPATH') or exit('No direct script access allowed');

class Base_URI extends \CI_URI
{

	public function __construct()
	{
		parent::__construct();
		$this->maintenanceMode();
	}

	/**
	 * Filter URI
	 *
	 * Filters segments for malicious characters.
	 *
	 * @param	string	$str
	 * @return	void
	 */
	public function filter_uri(&$str)
	{
		if (!empty($str) && !empty($this->_permitted_uri_chars) && !preg_match('/^[' . $this->_permitted_uri_chars . ']+$/i' . (UTF8_ENABLED ? 'u' : ''), $str)) {
			$this->uriFiltering($str);
		}
	}

	/**
	 * Converts any special parameters for a given segment into an associated array.
	 * Use a semi-colon as an argument separator if using multiple arguments
	 * 
	 * Example with 2 arguments: http://www.yoursite.com/users/list/page=5;limit=50
	 *          print_r($this->uri->segment_to_assoc(3)) would produce:
	 * array (
	 *   [page]  => 5,
	 *   [limit] => 50
	 * );
	 * 
	 * Note: In order for this to work, you must include the following 2 characters in $config['permitted_uri_chars']: ";" and "="
	 * 
	 * @access public
	 * @param integer $n The number of the segment to retrieve
	 * @param array $default Array of default values
	 * @return array
	 */
	public function segment_to_assoc($n = 3, $default = [])
	{
		return $this->_segment_to_assoc($n, $default);
	}

	/**
	 * Identical to segment_to_assoc() only it uses the re-routed segment
	 *
	 * @access 	public
	 * @param integer $n The number of the segment to retrieve
	 * @param array $default Array of default values
	 * @return array
	 *
	 */
	public function rsegment_to_assoc($n = 3, $default = [])
	{
		return $this->_segment_to_assoc($n, $default, 'rsegment');
	}

	/**
	 * Converts any special parameters for a given segment, or rsegment into an associated array.
	 * Use a semi-colon as an argument separator if using multiple arguments
	 *
	 * @access private
	 * @param integer $n The number of the segment to retrieve
	 * @param array $default Array of default values
	 * @param string $which 'segment' or 'rsegment', used internally
	 * @return array
	 */
	public function _segment_to_assoc($n = 3, $default = [], $which = 'segment')
	{
		//get the requested segment
		$segment = ($which == 'segment') ? $this->segment($n, $default) : $this->rsegment($n, $default);
		//return if there isn't a segment here
		if ($segment === false) return false;

		$return_params = [];
		//separate the arguments
		$parts = explode(';', $segment);
		foreach ($parts as $part) {
			if ($part != '') {
				$new_part = explode('=', $part);
				//if we had an =, separate key from value and put in new array
				if (count($new_part) == 2) {
					$return_params[$new_part[0]] = $new_part[1];
				}
			}
		}

		return $return_params;
	}

	/**
	 * Set to filter all uris 
	 * for non-permitted characters
	 *
	 * @param string $str non-permitted character
	 * @return void
	 */
	private function uriFiltering($str)
	{
		$http_protocol  = 'http://';
		$secured_http_protocol = 'https://';
		$error_route = $this->config->item('app_error_route');

		log_message('error', 'A non-permitted character {' . $str . '} was passed through a url from this ip address: ' . $this->getVisitIP());

		if (
			$_SERVER['REMOTE_ADDR'] === '127.0.0.1'
			|| $_SERVER['SERVER_NAME'] === 'localhost'
		) {
			$url = $http_protocol . $_SERVER['HTTP_HOST'] . '/';
			header('Location: ' . $url . $error_route);
		} else {
			$url = $secured_http_protocol . $_SERVER['HTTP_HOST'] . '/';
			header('Location: ' . $url . $error_route);
		}

		exit;
	}

	/**
	 * Set app maintenance mode
	 *
	 * @return void
	 */
	private function maintenanceMode()
	{
		if (is_cli()) {
			$this->config->set_item('maintenance_mode', true);
		}

		if (
			$this->config->item('maintenance_mode') === "false" 
			|| $this->config->item('app_status') === false
		) {

			$maintenance_view = $this->config->item('maintenance_view');

			log_message('app', 'Accessing maintenance mode from this ip address: ' . $this->getVisitIP());
			
			(is_cli()) ? exit('In Maintenance Mode') :

			http_response_code(503); // Set response code
			header('Retry-After: 3600'); // Set retry time

			if (file_exists(APP_MAINTENANCE_PATH . $maintenance_view)) {
				include_once(APP_MAINTENANCE_PATH . $maintenance_view);
			} else {
				show_error('Please make sure the maintenance view exists and that you have added a file extension e.g(.html,.php) to maintenance view', 500);
			}

			exit;
		} 
	}

	/**
	 * Get Client IP
	 *
	 * @return string
	 */
	private function getVisitIP(): string
	{
		$keys = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		];

		foreach ($keys as $key) {
			if (!empty($_SERVER[$key]) && filter_var($_SERVER[$key], FILTER_VALIDATE_IP)) {
				return $_SERVER[$key];
			}
		}

		if (is_cli()) {
			return "which is from Webby Cli";
		}

		return "UNKNOWN";
	}
}
/* end of file Base_URI.php */
