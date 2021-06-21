<?php

/**
 * CodeIgniter Object and Instance
 *
 * Greatly inspired by CoreIgniter and Rougin/SparkPlug
 *
 * Had to expand on it due to Webby's work around
 *
 * I think this wil be useful :)
 *
 * @author  Rougin Gutib <rougingutib@gmail.com>
 * @author  Oteng Kwame Appiah-Nti <developerkwame@gmail.com>
 * @license MIT
 * @version 0.1
 */

namespace Base\CodeIgniter;
use Exception;

class CodeIgniter {

    /**
     * Version of this library
     */
    const VERSION = '0.2';

    /**
     * Internal storage of CodeIgniter 
     * super object instance
     * 
     * @static
     * @access protected
     */
    protected static $instance;

    /**
     * @var array
     */
    protected $constants = array();

    /**
     * @var array
     */
    protected $globals = array();

    /**
     * @var array
     */
    protected $server = array();

    /**
     * @param array       $globals
     * @param array       $server
     * @param string|null $path
     */
    public function __construct(array &$globals, array $server)
    {
        $this->globals =& $globals;

        $this->server = $server;

        $this->constants['COREPATH'] = $this->globals['core_directory'];

        $this->constants['CIPATH'] = $this->globals['ci_directory'];

        $this->constants['ENVIRONMENT'] = $this->server['app.env'];

        $this->constants['COMPOSERPATH'] = $this->globals['composer_directory'];

        $this->constants['VIEWPATH'] = $this->globals['view_directory'];

    }

    /**
     * Returns the Codeigniter singleton.
     *
     * @return \CI_Controller
     */
    public function instance()
    {
        $this->paths();

        $this->environment($this->constants['ENVIRONMENT']);

        $this->constants();

        $this->common();

        $this->config();

        $instance = \CI_Controller::get_instance();

        empty($instance) && $instance = new \CI_Controller;

        return $instance;
    }

    /**
     * Sets the constant with a value.
     *
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $this->constants[$key] = $value;

        $same = $key === 'COREPATH';

        $path = $this->constants[$key] . '/views/';

        $same && $this->constants['VIEWPATH'] = $path;

        return $this;
    }

    /**
     * Sets the base path.
     *
     * @return void
     */
    protected function basepath()
    {
        if (!is_dir(CIPATH)) {
            throw new Exception('Supplied base path is not a directory');
        } 

        ! defined('CIPATH') && define('CIPATH', $this->constants['CIPATH']);
    }

    /**
     * Sets up important charset-related stuff.
     *
     * @return void
     */
    protected function charset()
    {
        ini_set('default_charset', $charset = strtoupper(config_item('charset')));

        defined('MB_ENABLED') || define('MB_ENABLED', extension_loaded('mbstring'));

        $encoding = 'mbstring.internal_encoding';

        ! is_php('5.6') && ! ini_get($encoding) && ini_set($encoding, $charset);

        $this->iconv();
    }

    /**
     * Loads the Common and the Base Controller class.
     *
     * @return void
     */
    protected function common()
    {
        $exists = class_exists('CI_Controller');

        require CIPATH . 'core/Common.php';

        $exists || require CIPATH . 'core/Controller.php';

        $this->charset();
    }

    /**
     * Sets global configurations.
     *
     * @return void
     */
    protected function config()
    {
        $this->globals['CFG'] =& load_class('Config', 'core');

        $this->globals['UNI'] =& load_class('Utf8', 'core');

        $this->globals['SEC'] =& load_class('Security', 'core');

        $this->core();
    }

    /**
     * Loads the framework constants.
     *
     * @return void
     */
    protected function constants()
    {
        $config = COREPATH . 'config/';

        $constants = $config . ENVIRONMENT . '/constants.php';

        $filename = $config . 'constants.php';

        file_exists($constants) && $filename = $constants;

        defined('FILE_READ_MODE') || require $filename;
    }

    /**
     * Loads the CodeIgniter's core classes.
     *
     * @return void
     */
    protected function core()
    {
        load_class('Loader', 'core');

        load_class('Router', 'core');

        load_class('Input', 'core');

        load_class('Lang', 'core');
        
        load_class('Output', 'core');
    }

    /**
     * Sets up the current environment.
     *
     * @return void
     */
    protected function environment($value = 'development')
    {
        // isset($this->server['CI_ENV']) && $value = $this->server['CI_ENV'];
        isset($this->server['app.env']) && $value = $this->server['app.env'];

        defined('ENVIRONMENT') || define('ENVIRONMENT', $value);
    }

    /**
     * Sets the ICONV constants.
     *
     * @param  boolean $enabled
     * @return void
     */
    protected function iconv($enabled = false)
    {
        mb_substitute_character('none') && $enabled = defined('ICONV_ENABLED');

        $enabled || define('ICONV_ENABLED', extension_loaded('iconv'));
    }

    /**
     * Sets up the COREPATH, COMPOSERPATH, and CIPATH constants.
     *
     * @return void
     */
    protected function paths()
    {
        $paths = array('COREPATH' => $this->constants['COREPATH']);

        $paths['COMPOSERPATH'] = $this->constants['COMPOSERPATH'];

        $paths['VIEWPATH'] = $this->constants['VIEWPATH'];

        foreach ((array) $paths as $key => $value) {
            $defined = defined($key);

            $defined || define($key, $value);
        }

        defined('CIPATH') || $this->basepath();
    }

}
