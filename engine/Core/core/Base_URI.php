<?php
class Base_URI extends CI_URI
{

	public function __construct()
	{
		parent::__construct();
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
        if ($str != '' AND $this->config->item('permitted_uri_chars') != '')
        {
            if ( ! preg_match("|^[".preg_quote($this->config->item('permitted_uri_chars'))."]+$|i", $str))
            {
                $this->app_error_view();
            }
        }
            
        return $str;
	}

    public function app_error_view($heading = "", $message = "", $status_code = 404, $log_error = true)
    {
        $template = config_item('app_error_view');
        $ext = '.php';
		
        if (empty($template)) {
			$template = VIEWPATH.'errors'.DIRECTORY_SEPARATOR.'error404'.$ext;
		} else {
            $template = VIEWPATH.$template.$ext;
        }

        set_status_header($status_code);
        // $message = '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>';
        // $template = 'html'.DIRECTORY_SEPARATOR.$template;
		
		if (ob_get_level() > ob_get_level() + 1)
		{
			ob_end_flush();
		}

		ob_start();

		include($template);
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
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
	 * @param Integer $n The number of the segment to retrieve
	 * @param Array $default Array of default values
	 * @return Array
	 */
	function segment_to_assoc($n = 3, $default = array())
	{
		return $this->_segment_to_assoc($n, $default);
	}
	
	/**
	 * Identical to segment_to_assoc() only it uses the re-routed segment
	 *
	 * @access 	public
	 * @param Integer $n The number of the segment to retrieve
	 * @param Array $default Array of default values
	 * @return Array
	 *
	 */
	function rsegment_to_assoc($n = 3, $default = array())	
	{
		return $this->_segment_to_assoc($n, $default, 'rsegment');
	}
	
	/**
	 * Converts any special parameters for a given segment, or rsegment into an associated array.
	 * Use a semi-colon as an argument separator if using multiple arguments
	 *
	 * @access private
	 * @param Integer $n The number of the segment to retrieve
	 * @param Array $default Array of default values
	 * @param String $which 'segment' or 'rsegment', used internally
	 * @return Array
	 */
	function _segment_to_assoc($n = 3, $default = array(), $which = 'segment')
	{
		//get the requested segment
		$segment = ($which == 'segment') ? $this->segment($n, $default) : $this->rsegment($n, $default);
		//return if there isn't a segment here
		if($segment === FALSE) return FALSE;
		
		$return_params = array();
		//separate the arguments
		$parts = explode(';', $segment);
		foreach($parts as $part)
		{
			if($part != '')
			{
				$new_part = explode('=', $part);
				//if we had an =, separate key from value and put in new array
				if(count($new_part) == 2)
				{
					$return_params[$new_part[0]] = $new_part[1];
				}
			}
		}
		
		return $return_params;
	}
}