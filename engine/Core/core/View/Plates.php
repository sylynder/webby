<?php

/**
 * A Template engine for Webby
 * 
 * It is based on Laravel's Plates templating system 
 * Initially developed by Gustavo Martins and named Slice as
 * a CodeIgniter Library.
 * 
 * @author		Gustavo Martins <gustavo_martins92@hotmail.com>
 * @link		https://github.com/GustMartins/Slice-Library
 * 
 * Expanded to work efficiently with Webby 
 * 
 * @author  Oteng Kwame Appiah-Nti <developerkwame@gmail.com>
 * @license MIT
 * @version 0.1.0
 */

namespace Base\View;

class Plates {

    /**
	 *  The file extension for the plates template
	 *
	 *  @var   string
	 */
	public $plate_ext		= '.php';

	/**
	 *  The amount of time to keep the file in cache
	 *
	 *  @var   integer
	 */
	public $cache_time		= 3600;

	/**
	 *  Autoload CodeIgniter Libraries and Helpers
	 *
	 *  @var   boolean
	 */
	public $enable_autoload	= false;

	/**
	 *  Default language
	 *
	 *  @var   string
	 */
	public $locale			= 'english';

	// --------------------------------------------------------------------------

	/**
	 *  Reference to CodeIgniter instance
	 *
	 *  @var   object
	 */
	protected $ci;

	/**
	 *  Global array of data for Plates Template
	 *
	 *  @var   array
	 */
	protected $_data		= array();

	/**
	 *  The content of each section
	 *
	 *  @var   array
	 */
	protected $sections	= array();

	/**
	 *  The stack of current sections being buffered
	 *
	 *  @var   array
	 */
	protected $buffer		= array();

	/**
	 *  Custom compile functions by the user
	 *
	 *  @var   array
	 */
	protected $directives = array();

	/**
	 *  Libraries to autoload
	 *
	 *  @var   array
	 */
	protected $libraries = array();

	/**
	 *  Helpers to autoload
	 *
	 *  @var   array
	 */
	protected $helpers = array();

	/**
	 *  Language strings to use with translation
	 *
	 *  @var   array
	 */
	protected $language	= array();

	/**
	 *  List of languages loaded
	 *
	 *  @var   array
	 */
	protected $i18n_loaded = array();

	// --------------------------------------------------------------------------

    /**
	 *  All of the compiler methods used by Plates to simulate
	 *  Laravel Plates Template
	 *
	 *  @var   array
	 */
	private $compilers = array(
	    'directive',
		'comment',
		'ternary',
		'preserved',
		'echo',
		'variable',
		'forelse',
		'empty',
		'endforelse',
		'opening_statements',
		'else',
		'continueIf',
		'continue',
		'breakIf',
		'break',
		'closing_statements',
		'each',
		'unless',
		'endunless',
		'includeIf',
		'include',
		'extends',
		'yield',
		'show',
		'opening_section',
		'closing_section',
		'php',
		'endphp',
		'lang',
		'choice'
	);

    // --------------------------------------------------------------------------

	/**
	 *  Plates Class Constructor
	 *
	 *  @param   array   $params = array()
	 *  @return	 void
	 */
	public function __construct(array $params = array())
	{
		// Set the super object to a local variable for use later
		$this->ci = ci();
		$this->ci->benchmark->mark('plate_execution_time_start');	//	Start the timer

		$this->ci->load->driver('cache');	//	Load ci cache driver
		
		if (config_item('enable_helper')) {
			$this->ci->load->helper('plate');	//	Load Plates Helper
		}

		$this->initialize($params);

		//	Autoload Libraries and Helpers
		if ($this->enable_autoload === true) {
			//	Autoload Libraries
			empty($this->libraries) OR $this->ci->load->library($this->libraries);

			//	Autoload Helpers
			empty($this->helpers) OR $this->ci->load->helper($this->helpers);
		}

		log_message('info', 'Plates Template Class Initialized');
	}

    // --------------------------------------------------------------------------

	/**
	 *  __set magic method
	 *
	 *  Handles writing to the data property
	 *
	 *  @param   string   $name
	 *  @param   mixed    $value
	 */
	public function __set($name, $value)
	{
		$this->_data[$name] = $value;
	}

	// --------------------------------------------------------------------------

	/**
	 *  __unset magic method
	 *
	 *  Handles unseting to the data property
	 *
	 *  @param   string   $name
	 */
	public function __unset($name)
	{
		unset($this->_data[$name]);
	}

	// --------------------------------------------------------------------------

	/**
	 *  __get magic method
	 *
	 *  Handles reading of the data property
	 *
	 *  @param    string   $name
	 *  @return   mixed
	 */
	public function __get($name)
	{
		if (key_exists($name, $this->_data)) {
			return $this->_data[$name];
		}

		return $this->ci->$name;
	}

	// --------------------------------------------------------------------------

	/**
	 * Initializes preferences
	 *
	 * @param	array	$params
	 * @return	Plates
	 */
	public function initialize(array $params = array())
	{
		$this->clear();

		foreach ($params as $key => $val) {
			if (isset($this->$key)) {
				$this->$key = $val;
			}
		}

		return $this;
	}

    // --------------------------------------------------------------------------

	/**
	 * Initializes some important variables
	 *
	 * @return	Plates
	 */
	public function clear()
	{
		$this->plate_ext		= config_item('plate_ext');
		$this->cache_time		= config_item('cache_time');
		$this->enable_autoload	= config_item('enable_autoload');
		$this->locale			= config_item('language');
		$this->libraries	    = config_item('libraries');
		$this->helpers		    = config_item('helpers');
		$this->_data			= array();

		return $this;
	}

    // --------------------------------------------------------------------------

	/**
	 *  Sets one single data to Plates Template
	 *
	 *  @param    string   $name
	 *  @param    mixed    $value
	 *  @return   Plates
	 */
	public function with($name, $value = '')
	{
		$this->_data[$name] = $value;
		return $this;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Sets one or more data to Plates Template
	 *
	 *  @param   mixed   $data
	 *  @param   mixed   $value
	 *  @return  Plates
	 */
	public function set($data, $value = '')
	{
		if (is_array($data))
		{
			$this->_data = array_merge($this->_data, $data);
		}
		else
		{
			$this->_data[$data] = $value;
		}

		return $this;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Appends or concatenates a value to a data in Plates Template
	 *
	 *  If data type is array it will append
	 *  If data type is string it will concatenate
	 *
	 *  @param    string   $name
	 *  @param    mixed    $value
	 *  @return   Plates
	 */
	public function append($name, $value)
	{
		if (is_array($this->_data[$name]))
		{
			$this->_data[$name][] = $value;
		}
		else
		{
			$this->_data[$name] .= $value;
		}

		return $this;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Outputs template content
	 *
	 *  @param    string    $template
	 *  @param    array     $data
	 *  @param    boolean   $return
	 *  @return   string
	 */
	public function view($template, $data = null, $return = false)
	{
		if (isset($data))
		{
			$this->set($data);
		}

		//	Compile and execute the template
		$content = $this->run($this->compile($template), $this->_data);

		if ( ! $return)
		{
			$this->ci->output->append_output($content);
		}

		return $content;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Verifies if a file exists!
	 *
	 *  This function verifies if a file exists evven if you are using
	 *  Modular Extensions
	 *
	 *  @param    string    $filename
	 *  @param    boolean   $show_error
	 *  @return   mixed
	 */
	public function exists($filename, $show_error = false)
	{
		$view_name = preg_replace('/([a-z]\w+)\./', '$1/', $filename);

		//	The default path to the file
		$default_path = VIEWPATH.$view_name.$this->plate_ext;

		//	If you are using Modular Extensions it will be detected
		if (method_exists($this->ci->router, 'fetch_module'))
		{
			$module = $this->ci->router->fetch_module();
			list($path, $view) = \Modules::find($view_name . $this->plate_ext, $module, 'views/');

			if ($path)
			{
				$default_path = $path . $view;
			}
		}

		//	Verify if the page really exists
		if (is_file($default_path))
		{
			if ($show_error === true)
			{
				return $default_path;
			}
			else
			{
				return true;
			}
		}
		else
		{
			if ($show_error === true)
			{
				show_error('Sorry! We couldn\'t find the view: '.$view_name.$this->plate_ext);
			}
			else
			{
				return false;
			}
		}
	}

	// --------------------------------------------------------------------------

	/**
	 *  Alters the language to use with translation strings
	 *
	 *  @param    string   $locale
	 *  @return   Plates
	 */
	public function locale($locale)
	{
		$this->locale = (string) $locale;
		return $this;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Sets custom compilation function
	 *
	 *  @param    string   $compilator
	 *  @return   Plates
	 */
	public function directive($compilator)
	{
		$this->directives[] = $compilator;
		return $this;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Compiles a template and saves it in the cache
	 *
	 *  @param    string   $template
	 *  @return   string
	 */
	protected function compile($template)
	{
		$view_path	= $this->exists($template, true);
		$cache_name	= 'plate-'.md5($view_path);
        
        // Save cached files to cache/web folder
        $this->ci->config->set_item('cache_path', WEB_CACHE_PATH);

		//	Verifies if exists a cached version of the file
		if ($cached_version = $this->ci->cache->file->get($cache_name))
		{
			if (ENVIRONMENT == 'production')
			{
				return $cached_version;
			}

			$cached_meta = $this->ci->cache->file->get_metadata($cache_name);

			if ($cached_meta['mtime'] > filemtime($view_path))
			{
				return $cached_version;
			}
		}

		$content = file_get_contents($view_path);

		//	Compile the content
		foreach ($this->compilers as $compiler)
		{
			$method = "compile_{$compiler}";
			$content = $this->$method($content);
		}

		//	Store in the cache
		$this->ci->cache->file->save($cache_name, $content, $this->cache_time);

		return $content;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Runs the template with its data
	 *
	 *  @param    string   $template
	 *  @param    array    $data
	 *  @return   string
	 */
	protected function run($template, $data = null)
	{
		if (is_array($data))
		{
			extract($data);
		}

		ob_start();
		eval(' ?>'.$template.'<?php ');

		$content = ob_get_clean();

		$this->ci->benchmark->mark('plate_execution_time_end');	//	Stop the timer

		return $content;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Returns a protected variable
	 *
	 *  @param    string   $variable
	 *  @return   string
	 */
	protected function untouch($variable)
	{
		return '{{'.$variable.'}}';
	}

	// --------------------------------------------------------------------------

	/**
	 *  Gets the content of a template to use inside the current template
	 *  It will inherit all the Global data
	 *
	 *  @param    string   $template
	 *  @param    array    $data
	 *  @return   string
	 */
	protected function include($template, $data = null)
	{
		$data = isset($data) ? array_merge($this->_data, $data) : $this->_data;

		//	Compile and execute the template
		return $this->run($this->compile($template), $data);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Gets the content of a section
	 *
	 *  @param    string   $section
	 *  @param    string   $default
	 *  @return   string
	 */
	protected function yield($section, $default = '')
	{
		return isset($this->sections[$section]) ? $this->sections[$section] : $default;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Starts buffering the content of a section
	 *
	 *  If the param $value is different of null it will be the content of
	 *  the current section
	 *
	 *  @param    string   $section
	 *  @param    mixed    $value
	 */
	protected function opening_section($section, $value = null)
	{
		array_push($this->buffer, $section);

		if ($value !== null)
		{
			$this->closing_section($value);
		}
		else
		{
			ob_start();
		}
	}

	// --------------------------------------------------------------------------

	/**
	 *  Stops buffering the content of a section
	 *
	 *  If the param $value is different of null it will be the
	 *  content of the current section
	 *
	 *  @param    mixed    $value
	 *  @return   string
	 */
	protected function closing_section($value = null)
	{
		$last_section = array_pop($this->buffer);

		if ($value !== null)
		{
			$this->extend_section($last_section, $value);
		}
		else
		{
			$this->extend_section($last_section, ob_get_clean());
		}

		return $last_section;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Retrieves a line from the language file loaded
	 *
	 *  @param    string    $line        String line to load
	 *  @param    array     $params      Place-holders to parse in the string
	 *  @return   string
	 */
	public function i18n($line, $params = array())
	{
		list($file, $string) = array_pad(explode('.', $line), 2, null);

		//	Here tries to get the string with the $file variable...
		$line = isset($this->language[$file]) ? $this->language[$file] : $file;

		if ($string !== null)
		{
			if ( ! isset($this->i18n_loaded[$file]) OR $this->i18n_loaded[$file] !== $this->locale)
			{
				//	Load the file into the language array
				$this->language = array_merge($this->language, $this->ci->lang->load($file, $this->locale, true));
				//	Save the loaded file and idiom
				$this->i18n_loaded[$file] = $this->locale;
			}

			//	... and here, the variable used is $string
			$line = isset($this->language[$string]) ? $this->language[$string] : $string;
		}

		//	Deals with the place-holders for the string
		if ( ! empty($params) && is_array($params))
		{
			foreach ($params as $name => $content)
			{
				$line = (strpos($line, ':'.strtoupper($name)) !== false)
					? str_replace(':'.strtoupper($name), strtoupper($content), $line)
					: $line;

				$line = (strpos($line, ':'.ucfirst($name)) !== false)
					? str_replace(':'.ucfirst($name), ucfirst($content), $line)
					: $line;

				$line = (strpos($line, ':'.$name) !== false)
					? str_replace(':'.$name, $content, $line)
					: $line;
			}
		}

		return $line;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Retrieves a line from the language file loaded in singular or plural form
	 *
	 *  @param    string          $line
	 *  @param    integer|array   $number
	 *  @param    array           $params
	 *  @return   string
	 */
	public function inflector($line, $number, $params = array())
	{
		$lines = explode('|', $this->i18n($line, $params));

		if (is_array($number))
		{
			$number = count($number);
		}

		foreach ($lines as $string)
		{
			//	Searches for a given amount
			preg_match_all('/\{([0-9]{1,})\}/', $string, $matches);
			list($str, $count) = $matches;

			if (isset($count[0]) && $count[0] == $number)
			{
				return str_replace('{'.$count[0].'} ', '', $string);
			}

			//	Searches for a range interval
			preg_match_all('/\[([0-9]{1,}),\s?([0-9*]{1,})\]/', $string, $matches);
			list($str, $start, $end) = $matches;

			if (isset($end[0]) && $end[0] !== '*')
			{
				if (in_array($number, range($start[0], $end[0])))
				{
					return preg_replace('/\[.*?\]\s?/', '', $string);
				}
			}
			elseif (isset($end[0]) && $end[0] === '*')
			{
				if ($number >= $start[0])
				{
					return preg_replace('/\[.*?\]\s?/', '', $string);
				}
			}
		}

		return ($number > 1) ? $lines[1] : $lines[0];
	}

	// --------------------------------------------------------------------------

	/**
	 *  Iterates through a variable to include content
	 *
	 *  @param    string   $template
	 *  @param    array    $variable
	 *  @param    string   $label
	 *  @param    string   $default
	 *  @return   string
	 */
	protected function each($template, $variable, $label, $default = null)
	{
		$content = '';

		if (count($variable) > 0)
		{
			foreach ($variable as $val[$label])
			{
				$content .= $this->include($template, $val);
			}
		}
		else
		{
			$content .= ($default !== null) ? $this->include($default) : '';
		}

		return $content;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites custom directives defined by the user
	 *
	 *  @param    string   $value
	 *  @return   string
	 */
	protected function compile_directive($value)
	{
		foreach ($this->directives as $compilator)
		{
			$value = call_user_func($compilator, $value);
		}

		return $value;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates comment into PHP comment
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_comment($content)
	{
		$pattern = '/\{\{--(.+?)(--\}\})?\n/';
		$return_pattern = '/\{\{--((.|\s)*?)--\}\}/';

		$content = preg_replace($pattern, "<?php // $1 ?>", $content);

		return preg_replace($return_pattern, "<?php /* $1 */ ?>\n", $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates conditional echo statement into PHP echo statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_ternary($content)
	{
		$pattern = '/\{\{\s\$(.\w*)\sor.[\'"]([^\'"]+)[\'"]\s\}\}/';

		preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

		foreach ($matches as $var)
		{
			$content = isset($this->_data[$var[1]]) ? str_replace($var[0], "<?php echo \$$var[1]; ?>", $content) : str_replace($var[0], "<?php echo '$var[2]'; ?>", $content);
		}
		return $content;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Preserves an expression to be displayed in the browser
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_preserved($content)
	{
		$pattern = '/@(\{\{(.+?)\}\})/';

		return preg_replace($pattern, '<?php echo $this->untouch("$2"); ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates echo statement into PHP echo statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_echo($content)
	{
		$pattern = '/\{\{(.+?)\}\}/';

		return preg_replace($pattern, '<?php echo $1; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates variable handling function into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_variable($content)
	{
		$pattern = '/(\s*)@(isset|empty)(\s*\(.*\))/';

		return preg_replace($pattern, '$1<?php if ($2$3): ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates forelse statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_forelse($content)
	{
		$pattern = '/(\s*)@forelse(\s*\(.*\))(\s*)/';

		preg_match_all($pattern, $content, $matches);

		foreach ($matches[0] as $forelse)
		{
			$variable_pattern = '/\$[^\s]*/';

			preg_match($variable_pattern, $forelse, $variable);

			$if_statement = "<?php if (count({$variable[0]}) > 0): ?>";
			$search_pattern = '/(\s*)@forelse(\s*\(.*\))/';
			$replacement = '$1'.$if_statement.'<?php foreach $2: ?>';

			$content = str_replace($forelse, preg_replace($search_pattern, $replacement, $forelse), $content);
		}

		return $content;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates empty statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_empty($content)
	{
		return str_replace('@empty', '<?php endforeach; ?><?php else: ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates endforelse statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_endforelse($content)
	{
		return str_replace('@endforelse', '<?php endif; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates opening structures into PHP opening structures
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_opening_statements($content)
	{
		$pattern = '/(\s*)@(if|elseif|foreach|for|while)(\s*\(.*\))/';

		return preg_replace($pattern, '$1<?php $2$3: ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates else statement into PHP else statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_else($content)
	{
		$pattern = '/(\s*)@(else)(\s*)/';

		return preg_replace($pattern, '$1<?php $2: ?>$3', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates continue() statement into PHP continue statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_continueIf($content)
	{
		$pattern = '/(\s*)@(continue)(\s*\(.*\))/';

		return preg_replace($pattern, '$1<?php if $3: ?>$1<?php $2; ?>$1<?php endif; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates continue statement into PHP continue statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_continue($content)
	{
		$pattern = '/(\s*)@(continue)(\s*)/';

		return preg_replace($pattern, '$1<?php $2; ?>$3', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates break() statement into PHP break statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_breakIf($content)
	{
		$pattern = '/(\s*)@(break)(\s*\(.*\))/';

		return preg_replace($pattern, '$1<?php if $3: ?>$1<?php $2; ?>$1<?php endif; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates break statement into PHP break statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_break($content)
	{
		$pattern = '/(\s*)@(break)(\s*)/';

		return preg_replace($pattern, '$1<?php $2; ?>$3', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates closing structures into PHP closing structures
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_closing_statements($content)
	{
		$pattern = '/(\s*)@(endif|endforeach|endfor|endwhile)(\s*)/';

		return preg_replace($pattern, '$1<?php $2; ?>$3', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates each statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_each($content)
	{
		$pattern = '/(\s*)@each(\s*\(.*?\))(\s*)/';

		return preg_replace($pattern, '$1<?php echo $this->each$2; ?>$3', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates unless statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_unless($content)
	{
		$pattern = '/(\s*)@unless(\s*\(.*\))/';

		return preg_replace($pattern, '$1<?php if ( ! ($2)): ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates endunless, endisset and endempty statements into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_endunless($content)
	{
		$pattern = '/(\s*)@(endunless|endisset|endempty)/';

		return preg_replace($pattern, '<?php endif; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @includeIf statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_includeIf($content)
	{
		$pattern = "/(\s*)@includeIf\s*(\('(.*?)'.*\))/";

		return preg_replace($pattern, '$1<?php echo ($this->exists("$3", false) === true) ? $this->include$2 : ""; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @include statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_include($content)
	{
		$pattern = '/(\s*)@include(\s*\(.*\))/';

		return preg_replace($pattern, '$1<?php echo $this->include$2; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @extends statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_extends($content)
	{
		$pattern = '/(\s*)@extends(\s*\(.*\))/';

		// Find and if there is none, just return the content
		if ( ! preg_match_all($pattern, $content, $matches, PREG_SET_ORDER))
		{
			return $content;
		}

		$content = preg_replace($pattern, '', $content);

		// Layouts are included in the end of template
		foreach ($matches as $include)
		{
			$content .= $include[1].'<?php echo $this->include'.$include[2]."; ?>";
		}

		return $content;
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @yield statement into Section statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_yield($content)
	{
		$pattern = '/(\s*)@yield(\s*\(.*\))/';

		return preg_replace($pattern, '<?php echo $this->yield$2; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates Show statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_show($content)
	{
		return str_replace('@show', '<?php echo $this->yield($this->closing_section()); ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @usesection statement as Section statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_opening_section($content)
	{
		$pattern = '/(\s*)@usesection(\s*\(.*\))/';

		return preg_replace($pattern, '<?php $this->opening_section$2; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @endsection statement into Section statement
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_closing_section($content)
	{
		return str_replace('@endsection', '<?php $this->closing_section(); ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @php statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_php($content)
	{
		return str_replace('@php', '<?php', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @endphp statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_endphp($content)
	{
		return str_replace('@endphp', '?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @lang statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_lang($content)
	{
		$pattern = '/(\s*)@lang(\s*\(.*\))/';

		return preg_replace($pattern, '<?php echo $this->i18n$2; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Rewrites Plates @choice statement into valid PHP
	 *
	 *  @param    string   $content
	 *  @return   string
	 */
	protected function compile_choice($content)
	{
		$pattern = '/(\s*)@choice(\s*\(.*\))/';

		return preg_replace($pattern, '<?php echo $this->inflector$2; ?>', $content);
	}

	// --------------------------------------------------------------------------

	/**
	 *  Stores the content of a section
	 *  It also replaces the Plates @parent statement with the previous section
	 *
	 *  @param    string   $section
	 *  @param    string   $content
	 */
	private function extend_section($section, $content)
	{
		if (isset($this->sections[$section]))
		{
			$this->sections[$section] = str_replace('@parent', $content, $this->sections[$section]);
		}
		else
		{
			$this->sections[$section] = $content;
		}
	}
    
}