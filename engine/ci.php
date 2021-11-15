<?php
/**
 * An Instance of CodeIgniter For Console Implementation
 *
 * 
 * @author     Kwame Oteng Appiah-Nti <https://github.com/otengkwame>
 * @license    MIT License
 * @copyright  2021 Kwame Oteng Appiah-Nti
 * @link       https://github.com/kenjis/codeigniter-cli
 *
 * Based on Kenji Suzuki's Implementation on https://github.com/kenjis/codeigniter-cli
 * Based on http://codeinphp.github.io/post/codeigniter-tip-accessing-codeigniter-instance-outside/
 * Thanks!
 */

$cwd = getcwd();
chdir(__DIR__);

$public_dir = __DIR__ . '/../public';

define('FCPATH', $public_dir . '/');

require_once __DIR__ . '/paths.php';
require_once __DIR__ . '/bootstrap.php';

define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : $_ENV['app.env']);

require(CIPATH . 'core/Common.php');

if (file_exists(COREPATH . 'config/' . ENVIRONMENT . '/constants.php')) {
    require(COREPATH . 'config/' . ENVIRONMENT . '/constants.php');
} else {
    require(COREPATH . 'config/constants.php');
}

$charset = strtoupper(config_item('charset'));
ini_set('default_charset', $charset);

if (extension_loaded('mbstring')) {
    define('MB_ENABLED', true);
    // mbstring.internal_encoding is deprecated starting with PHP 5.6
    // and it's usage triggers E_DEPRECATED messages.
    @ini_set('mbstring.internal_encoding', $charset);
    // This is required for mb_convert_encoding() to strip invalid characters.
    // That's utilized by CI_Utf8, but it's also done for consistency with iconv.
    mb_substitute_character('none');
} else {
    define('MB_ENABLED', false);
}

// There's an ICONV_IMPL constant, but the PHP manual says that using
// iconv's predefined constants is "strongly discouraged".
if (extension_loaded('iconv')) {
    define('ICONV_ENABLED', true);
    // iconv.internal_encoding is deprecated starting with PHP 5.6
    // and it's usage triggers E_DEPRECATED messages.
    @ini_set('iconv.internal_encoding', $charset);
} else {
    define('ICONV_ENABLED', false);
}

$GLOBALS['CFG'] =& load_class('Config', 'core');
$GLOBALS['UNI'] =& load_class('Utf8', 'core');
$GLOBALS['SEC'] =& load_class('Security', 'core');

load_class('Loader', 'core');
load_class('Router', 'core');
load_class('Input', 'core');
load_class('Lang', 'core');

chdir($cwd);

function &get_instance()
{
    return \CI_Controller::get_instance();
}

$CI = new \CI_Controller();
