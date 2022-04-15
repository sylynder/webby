<?php
defined('COREPATH') or exit('No direct script access allowed');

class Base_Exceptions extends \CI_Exceptions
{

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

		if ($status_code == 404) {
			include($templates_path . $template . config_item('plate_extension'));
		} else {
			include($templates_path . $template . '.php');
		}

		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}
/* end of file Base_Exceptions.php */
