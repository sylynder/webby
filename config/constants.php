<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
| This file contains constants for making Webby work great
| Don't change any defined "constant name" else it will result
| in an error or may brake the application
|
| Add your constants at the section "Your constants here"
|
 */

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your Webby root. Typically this will be your base URL,
| WITH a trailing slash:
|
|   http://example.com/
|
| If this is not set then Webby will try guess the protocol, domain
| and path to your installation. However, you should always configure this
| explicitly and never rely on auto-guessing, especially in production
| environments.
|
 */
$base_url = '';

if ( ! defined('STDIN')) {

    $base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

}

define('APP_BASE_URL', getenv('app.baseURL') ?: $base_url);

/*
|--------------------------------------------------------------------------
| Encryption Key
| IMPORTANT: Don't change this EVER
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| http://codeigniter.com/user_guide3/libraries/encryption.html
|
| Auto updated added on install
 */

define('APP_ENCRYPTION_KEY', getenv('app.encryptionKey'));

/*
|--------------------------------------------------------------------------
| Database credentials - Auto added
|--------------------------------------------------------------------------
|
 */

// Database Driver
define('APP_DB_DRIVER', getenv('database.default.DBDriver'));

/* The hostname of your database server. */
define('APP_DB_HOSTNAME', getenv('database.default.hostname'));
/* The username used to connect to the database */
define('APP_DB_USERNAME', getenv('database.default.username'));
/* The password used to connect to the database */
define('APP_DB_PASSWORD', getenv('database.default.password'));
/* The name of the database you want to connect to */
define('APP_DB_NAME', getenv('database.default.database'));
/* The name of the database if you want to use a seperate 
*  authentication database
*/
define('AUTH_DB', getenv('database.default.auth_database'));

/*
|--------------------------------------------------------------------------
| Postgres SQL Configuration and Credentials
|--------------------------------------------------------------------------
|
*/

/* The dsn of your database server. */
define('PGSQL_DB_DSN', getenv('database.pgsql.dsn'));
/* The hostname of your database server. */ //PGSQL_DB_DSN
define('PGSQL_DB_HOSTNAME', getenv('database.pgsql.hostname'));
//The database Driver to user to the database
define('PGSQL_DB_DRIVER', getenv('database.pgsql.DBDriver'));
/* The username used to connect to the database */
define('PGSQL_DB_USERNAME', getenv('database.pgsql.username'));
/* The password used to connect to the database */
define('PGSQL_DB_PASSWORD', getenv('database.pgsql.password'));
/* The name of the database you want to connect to */
define('PGSQL_DB_NAME', getenv('database.pgsql.database'));
/* The port number of database engine */
define('PGSQL_DB_PORT', getenv('database.pgsql.port'));


/*
|--------------------------------------------------------------------------
| Site Maintenance view file path and Enable/Disable
|--------------------------------------------------------------------------
|
 */

define('SITE_ON', false);

define('SITE_MAINTENANCE_VIEW', '');

/*
|--------------------------------------------------------------------------
| Log Configurations
|--------------------------------------------------------------------------
|
 */

define('LOG_PATH', ROOTPATH . 'writable/logs/system/');
define('APP_LOG_PATH', ROOTPATH . 'writable/logs/app/');

/*
|   Log Threshold for Webby logging
|    0 = Disables logging, Error logging TURNED OFF
|    1 = User Messages (Log messages based on user activities)
|    2 = App Messages (Log messages based on your application)
|    3 = Error Messages (including PHP errors)
|    4 = Informational Messages
|    5 = Debug Messages
|    6 = All Messages
 */

define('LOG_LEVEL', 3);

/*
|   Log permission for Webby logging
|   integer notation (i.e. 0700, 0644, etc.)
|
 */

define('LOG_PERMISSION', 0644);

/*
|   Log date format for Webby logging
|   You can use PHP date codes to set your own date formatting
 */

define('LOG_DATE_FORMAT', 'Y-m-d H:i:s');

/*
|   Log file extension
|   The default filename extension for log files. The default 'php' allows for
|   protecting the log files via basic scripting, when they are to be stored
|   under a publicly accessible directory.
|
|   Note: Leaving it blank will default to 'php'.
|
 */
define('LOG_FILE_EXTENSION', '');

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| By default cache path is set in writable/cache/ directory. You can relocate it
| based on your preference
| Use a full server path with trailing slash.
|
 */

define('CACHE_PATH', WRITABLEPATH . 'cache/');

/*
|--------------------------------------------------------------------------
| Web Cache Directory Path
|--------------------------------------------------------------------------
|
| Cache path for web views
|
 */

define('WEB_CACHE_PATH', CACHE_PATH . 'web/');

/*
|
| Session handler driver
| By default the database driver will be used.
|
| The Constants below have been made to control the values
| of the $config['sess_|'] array variables in the engine/config/config.php
|
| For files session use this config:
| define('SESS_DRIVER','files');
| define('SESS_SAVE_PATH',NULL);
| In case you are having problem with the SESS_SAVE_PATH consult with your hosting provider to set "session.save_path" value to php.ini
|
 */

define('SESSION_SAVE_PATH', getenv('app.sessionSavePath') ?: ROOTPATH . 'writable/session');
define('SESSION_DRIVER', getenv('app.sessionDriver') ?: 'files');
define('SESSION_COOKIE_NAME', getenv('app.sessionCookieName') ?: 'i_');
define('SESSION_EXPIRATION', getenv('app.sessionExpiration') ?: 7200);
define('SESSION_MATCH_IP', getenv('app.sessionMatchIP') ?: false);
define('SESSION_TIME_TO_UPDATE', getenv('app.sessionTimeToUpdate') ?: 300);
define('SESSION_REGENERATE_DESTROY', getenv('app.sessionRegenerateDestroy') ?: false);

/*
|
|  Cookie Related Variables
|
|  The Constants below have been made to control the values
|  of the $config['sess|'] array variables in the engine/config/config.php
|
|  'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
|  'cookie_domain'   = Set to .your-domain.com for site-wide cookies
|  'cookie_path'     = Typically will be a forward slash
|  'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
|  'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
|  'cookie_samesite' = Identify whether or not to allow a cookie to be accessed. 
|					  SameSite attribute include 'Strict', 'Lax', or 'None' (The first character must be an uppercase letter)
|
|    				  'Lax' enables only first-party cookies to be sent/accessed
|					  'Strict' is a subset of 'lax' and won’t fire if the incoming link is from an external site
|    				  'None' signals that the cookie data can be shared with third parties/external sites
|
|  Note: These settings (with the exception of 'cookie_prefix' and
|       'cookie_httponly') will also affect sessions.
|
 */

define('COOKIE_PREFIX', getenv('app.cookiePrefix') ?: 'i_');
define('COOKIE_DOMAIN', getenv('app.cookieDomain') ?: '');
define('COOKIE_PATH', getenv('app.cookiePath') ?: '/');
define('COOKIE_SECURE', getenv('app.cookieSecure') ?: false);
define('COOKIE_HTTPONLY', getenv('app.cookieHTTPOnly') ?: true);
define('COOKIE_SAMESITE', getenv('app.cookieSameSite') ?: 'Lax');

/*
|
|  Cross Site Request Forgery
|
|  Enables a CSRF cookie token to be set. When set to TRUE, token will be
|  checked on a submitted form. If you are accepting user data, it is strongly
|  recommended CSRF protection be enabled.
|
|  'csrf_token_name' = The token name
|  'csrf_cookie_name' = The cookie name
|  'csrf_expire' = The number in seconds the token should expire.
|  'csrf_regenerate' = Regenerate token on every submission
|  'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
 */

define('CSRF_PROTECTION', getenv('app.CSRFProtection') ?: false);
define('CSRF_TOKEN_NAME', getenv('app.CSRFTokenName') ?: 'csrf_app_token');
define('CSRF_COOKIE_NAME', getenv('app.CSRFCookieName') ?: 'csrf_app');
define('CSRF_EXPIRE', getenv('app.CSRFExpire') ?: 7200);
define('CSRF_REGENERATE', getenv('app.CSRFRegenerate') ?: false);
define('CSRF_EXCLUDE_URIS', getenv('app.CSRFExcludeURIs') ?: []);

/*
| These constants are defined to help make some
| work arounds simple
 */

if ( ! defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// TimeZone and Dates
define('DATETIME', date('Y-m-d H:i:s', time()));
define('TIME', date('H:i:s', time()));
define('DATE', date('Y-m-d'));
define('TIMESTAMP', strtotime(date('Y-m-d') . ' ' . date('H:i:s')));
define('TODAY', date('Y-m-d'));
define('DEFAULT_TIMEZONE', 'Africa/Accra');

!empty(getenv('app.timezone')) 
        ? date_default_timezone_set(getenv('app.timezone'))  
        : date_default_timezone_set(DEFAULT_TIMEZONE);

define('TIMEZONE', date_default_timezone_get());

/*
| These definitions are for characters 
| and symbols e.g.(s, a, c, ., @, #)
 */

define('BREAK', '<br/>');
define('ADD_S', 's');
define('DOT', '.');
define('AT', '@');
define('HASH', '#');
define('PERCENT', '%');

/*
|--------------------------------------------------------------------------
| Your Constants Here
|--------------------------------------------------------------------------
|
 */