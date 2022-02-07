<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| HTTP protocol
|--------------------------------------------------------------------------
|
| Set to force the use of HTTPS for API calls
|
*/
$config['force_https'] = false;

/*
|--------------------------------------------------------------------------
| API Output Format
|--------------------------------------------------------------------------
|
| The default format of the response
|
| 'array':      Array data structure
| 'csv':        Comma separated file
| 'json':       Uses json_encode(). Note: If a GET query string
|               called 'callback' is passed, then jsonp will be returned
| 'html'        HTML using the table library in CodeIgniter
| 'php':        Uses var_export()
| 'serialized':  Uses serialize()
| 'xml':        Uses simplexml_load_string()
|
*/
$config['api_default_format'] = 'json';

/*
|--------------------------------------------------------------------------
| API Supported Output Formats
|--------------------------------------------------------------------------
|
| The following setting contains a list of the supported/allowed formats.
| You may remove those formats that you don't want to use.
| If the default format $config['api_default_format'] is missing within
| $config['api_supported_formats'], it will be added silently during
| ApiController initialization.
|
*/
$config['api_supported_formats'] = [
    'json',
    'array',
    'csv',
    'html',
    'jsonp',
    'php',
    'serialized',
    'xml',
];

/*
|--------------------------------------------------------------------------
| API Status Field Name
|--------------------------------------------------------------------------
|
| The field name for the status inside the response
|
*/
$config['api_status_field_name'] = 'status';

/*
|--------------------------------------------------------------------------
| API Message Field Name
|--------------------------------------------------------------------------
|
| The field name for the message inside the response
|
*/
$config['api_message_field_name'] = 'error';

/*
|--------------------------------------------------------------------------
| Enable Emulate Request
|--------------------------------------------------------------------------
|
| Should we enable emulation of the request (e.g. used in Mootools request)
|
*/
$config['enable_emulate_request'] = true;

/*
|--------------------------------------------------------------------------
| API Realm
|--------------------------------------------------------------------------
|
| Name of the password protected API displayed on login dialogs
|
| e.g: My Secret REST API
|
*/
$config['api_realm'] = 'REST API';

/*
|--------------------------------------------------------------------------
| API Login
|--------------------------------------------------------------------------
|
| Set to specify the API requires to be logged in
|
| false     No login required
| 'basic'   Unsecured login
| 'digest'  More secured login
| 'session' Check for a PHP session variable. See 'auth_source' to set the
|           authorization key
| 'token'   Check for token authorization
|
*/
$config['api_auth'] = false;

/*
|--------------------------------------------------------------------------
| API Login Source
|--------------------------------------------------------------------------
|
| Is login required and if so, the user store to use
|
| ''        Use config based users or wildcard testing
| 'ldap'    Use LDAP authentication
| 'library' Use a authentication library
|
| Note: If 'api_auth' is set to 'session' then change 'auth_source' to the name of the session variable
|
*/
$config['auth_source'] = 'ldap';

/*
|--------------------------------------------------------------------------
| Allow Authentication and API Keys
|--------------------------------------------------------------------------
|
| Where you wish to have Basic, Digest or Session login, 
| but also want to use API Keys (for limiting
| requests etc), set to true;
|
*/
$config['allow_auth_and_keys'] = false;
$config['strict_api_and_auth'] = false; // force the use of both api and auth before a valid api request is made

/*
|--------------------------------------------------------------------------
| API Login Class and Function
|--------------------------------------------------------------------------
|
| If library authentication is used define the class and function name
|
| The function should accept two parameters: class->function($username, $password)
| In other cases override the function performLibraryAuth in your controller
|
| For digest authentication the library function should return already a stored
| md5(username:apirealm:password) for that username
|
| e.g: md5('admin:REST API:1234') = '1e957ebc35631ab22d5bd6526bd14ea2'
|
*/
$config['auth_library_class'] = '';
$config['auth_library_function'] = '';

/*
|--------------------------------------------------------------------------
| Override auth types for specific class/method
|--------------------------------------------------------------------------
|
| Set specific authentication types for methods within a class (controller)
|
| Set as many config entries as needed.  Any methods not set will use the default 'api_auth' config value.
|
| e.g:
|
|           $config['auth_override_class_method']['deals']['view'] = 'none';
|           $config['auth_override_class_method']['deals']['insert'] = 'digest';
|           $config['auth_override_class_method']['accounts']['user'] = 'basic';
|           $config['auth_override_class_method']['dashboard']['*'] = 'none|digest|basic';
|
| Here 'deals', 'accounts' and 'dashboard' are controller names, 'view', 'insert' and 'user' are methods within. An asterisk may also be used to specify an authentication method for an entire classes methods. Ex: $config['auth_override_class_method']['dashboard']['*'] = 'basic'; (NOTE: leave off the '_get' or '_post' from the end of the method name)
| Acceptable values are; 'none', 'digest' and 'basic'.
|
*/
// $config['auth_override_class_method']['deals']['view'] = 'none';
// $config['auth_override_class_method']['deals']['insert'] = 'digest';
// $config['auth_override_class_method']['accounts']['user'] = 'basic';
// $config['auth_override_class_method']['dashboard']['*'] = 'basic';

// ---Uncomment list line for the wildard unit test
// $config['auth_override_class_method']['wildcard_test_cases']['*'] = 'basic';

/*
|--------------------------------------------------------------------------
| Override auth types for specific 'class/method/HTTP method'
|--------------------------------------------------------------------------
|
| example:
|
|            $config['auth_override_class_method_http']['deals']['view']['get'] = 'none';
|            $config['auth_override_class_method_http']['deals']['insert']['post'] = 'none';
|            $config['auth_override_class_method_http']['deals']['*']['options'] = 'none';
*/

// ---Uncomment list line for the wildard unit test
// $config['auth_override_class_method_http']['wildcard_test_cases']['*']['options'] = 'basic';

/*
|--------------------------------------------------------------------------
| API Login Usernames
|--------------------------------------------------------------------------
|
| Array of usernames and passwords for login, if ldap is configured this is ignored
|
*/
$config['api_valid_logins'] = ['{dummy}' => '{dummy}'];

/*
|--------------------------------------------------------------------------
| Global IP White-listing
|--------------------------------------------------------------------------
|
| Limit connections to your API server to White-listed IP addresses
|
| Usage:
| 1. Set to true and select an auth option for extreme security (client's IP
|    address must be in white-list and they must also log in)
| 2. Set to true with auth set to false to allow White-listed IPs access with no login
| 3. Set to false but set 'auth_override_class_method' to 'white-list' to
|    apirict certain methods to IPs in your white-list
|
*/
$config['api_ip_whitelist_enabled'] = false;

/*
|--------------------------------------------------------------------------
| API Handle Exceptions
|--------------------------------------------------------------------------
|
| Handle exceptions caused by the controller
|
*/
$config['api_handle_exceptions'] = true;

/*
|--------------------------------------------------------------------------
| API IP White-list
|--------------------------------------------------------------------------
|
| Limit connections to your API server with a comma separated
| list of IP addresses
|
| e.g: '123.456.789.0, 987.654.32.1'
|
| 127.0.0.1 and 0.0.0.0 are allowed by default
|
*/
$config['api_ip_whitelist'] = '';

/*
|--------------------------------------------------------------------------
| Global IP Blacklisting
|--------------------------------------------------------------------------
|
| Prevent connections to the API server from blacklisted IP addresses
|
| Usage:
| 1. Set to true and add any IP address to 'api_ip_blacklist'
|
*/
$config['api_ip_blacklist_enabled'] = false;

/*
|--------------------------------------------------------------------------
| API IP Blacklist
|--------------------------------------------------------------------------
|
| Prevent connections from the following IP addresses
|
| e.g: '123.456.789.0, 987.654.32.1'
|
*/
$config['api_ip_blacklist'] = '';

/*
|--------------------------------------------------------------------------
| API Database Group
|--------------------------------------------------------------------------
|
| Connect to a database group for keys, logging, etc. It will only connect
| if you have any of these features enabled
|
*/
$config['api_use_database'] = true; // You need to set to true to use a database
$config['api_database_group'] = 'default'; // You can choose a different db group to use
$config['api_database_path']  = 'default'; // You can set this in database/config.php file else You have to set this in an HMVC Config folder

/*
|--------------------------------------------------------------------------
| API Keys Table Name
|--------------------------------------------------------------------------
|
| The table name in your database that stores API keys
|
*/
$config['api_keys_table'] = 'api_keys';

/*
|--------------------------------------------------------------------------
| API Enable Keys
|--------------------------------------------------------------------------
|
| When set to true, the API will look for a column name called 'key'.
| If no key is provided, the request will result in an error. To override the
| column name see 'api_key_column'
|
| Default table schema:
|   CREATE TABLE `api_keys` (
|       `id` INT(11) NOT NULL AUTO_INCREMENT,
|       `user_id` VARCHAR(40) NOT NULL,
|       `api_key` VARCHAR(40) NOT NULL,
|       `level` INT(2) NOT NULL,
|       `ignore_limits` TINYINT(1) NOT NULL DEFAULT '0',
|       `is_private_key` TINYINT(1)  NOT NULL DEFAULT '0',
|       `ip_addresses` TEXT NULL DEFAULT NULL,
|       `date_created` DATE NOT NULL,
|       PRIMARY KEY (`id`)
|   );
|
*/
$config['api_enable_keys'] = false;

/*
|--------------------------------------------------------------------------
| API Tokens
|--------------------------------------------------------------------------
| https://stackoverflow.com/questions/43406721/token-based-authentication-in-codeigniter-api-server-library
| 
| Default table schema:
| CREATE TABLE `api_tokens` (
|    `api_token_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
|    `user_id` VARCHAR(40) NOT NULL,
|    `token` VARCHAR(50) NOT NULL,
|    `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
|    PRIMARY KEY (`api_token_id`)
|  );
|
*/
$config['api_enable_token'] = false;
$config['api_token_name'] = 'X-Auth-Token';
$config['api_tokens_table'] = 'api_tokens';

/*
|--------------------------------------------------------------------------
| API Table Key Column Name
|--------------------------------------------------------------------------
|
| If not using the default table schema in 'api_enable_keys', specify the
| column name to match e.g. my_key
|
*/
$config['api_key_column'] = 'api_key';

/*
|--------------------------------------------------------------------------
| API Limits method
|--------------------------------------------------------------------------
|
| Specify the method used to limit the API calls
|
| Available methods are :
| $config['api_limits_method'] = 'IP_ADDRESS'; // Put a limit per ip address
| $config['api_limits_method'] = 'API_KEY'; // Put a limit per api key
| $config['api_limits_method'] = 'METHOD_NAME'; // Put a limit on method calls
| $config['api_limits_method'] = 'ROUTED_URL';  // Put a limit on the routed URL
|
*/
$config['api_limits_method'] = 'ROUTED_URL';

/*
|--------------------------------------------------------------------------
| API Key Length
|--------------------------------------------------------------------------
|
| Length of the created keys. Check your default database schema on the
| maximum length allowed
|
| Note: The maximum length is 120
|
*/
$config['api_key_length'] = 120;

/*
|--------------------------------------------------------------------------
| API Key Variable
|--------------------------------------------------------------------------
|
| Custom header to specify the API key

| Note: Custom headers with the X- prefix are deprecated as of
| 2012/06/12. See RFC 6648 specification for more details
|
| A huge read-up come be found here 
| https://stackoverflow.com/questions/3561381/custom-http-headers-naming-conventions
|
*/
$config['api_key_name'] = 'X-API-KEY';

/*
|--------------------------------------------------------------------------
| API Enable Logging
|--------------------------------------------------------------------------
|
| When set to true, the API will log actions based on the column names 'key', 'date',
| 'time' and 'ip_address'. This is a general rule that can be overridden in the
| $this->method array for each controller
|
| Default table schema:
|   CREATE TABLE `api_logs` (
|       `id` INT(11) NOT NULL AUTO_INCREMENT,
|       `uri` VARCHAR(255) NOT NULL,
|       `method` VARCHAR(6) NOT NULL,
|       `params` TEXT DEFAULT NULL,
|       `api_key` VARCHAR(40) NOT NULL,
|       `ip_address` VARCHAR(45) NOT NULL,
|       `time` INT(11) NOT NULL,
|       `rtime` FLOAT DEFAULT NULL,
|       `authorized` VARCHAR(1) NOT NULL,
|       `response_code` smallint(3) DEFAULT '0',
|       PRIMARY KEY (`id`)
|   );
|
*/
$config['api_enable_logging'] = false;

/*
|--------------------------------------------------------------------------
| API Logs Table Name
|--------------------------------------------------------------------------
|
| If not using the default table schema in 'api_enable_logging', specify the
| table name to match e.g. my_logs
|
*/
$config['api_logs_table'] = 'api_logs';

/*
|--------------------------------------------------------------------------
| API Method Access Control
|--------------------------------------------------------------------------
| When set to true, the API will check the access table to see if
| the API key can access that controller. 'api_enable_keys' must be enabled
| to use this
|
| Default table schema:
|   CREATE TABLE `api_access` (
|       `id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
|       `api_key` VARCHAR(40) NOT NULL DEFAULT '',
|       `all_access` TINYINT(1) NOT NULL DEFAULT '0',
|       `controller` VARCHAR(50) NOT NULL DEFAULT '',
|       `date_created` DATETIME DEFAULT NULL,
|       `date_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
|       PRIMARY KEY (`id`)
|    );
|
*/
$config['api_enable_access'] = false;

/*
|--------------------------------------------------------------------------
| API Access Table Name
|--------------------------------------------------------------------------
|
| If not using the default table schema in 'api_enable_access', specify the
| table name to match e.g. my_access
|
*/
$config['api_access_table'] = 'api_access';

/*
|--------------------------------------------------------------------------
| API Param Log Format
|--------------------------------------------------------------------------
|
| When set to true, the API log parameters will be stored in the database as JSON
| Set to false to log as serialized PHP
|
*/
$config['api_logs_json_params'] = false;

/*
|--------------------------------------------------------------------------
| API Enable Limits
|--------------------------------------------------------------------------
|
| When set to true, the API will count the number of uses of each method
| by an API key each hour. This is a general rule that can be overridden in the
| $this->method array in each controller
|
| Default table schema:
|   CREATE TABLE `api_limits` (
|       `id` INT(11) NOT NULL AUTO_INCREMENT,
|       `uri` VARCHAR(255) NOT NULL,
|       `count` INT(10) NOT NULL,
|       `hour_started` INT(11) NOT NULL,
|       `api_key` VARCHAR(40) NOT NULL,
|       PRIMARY KEY (`id`)
|   );
|
| To specify the limits within the controller's __construct() method, add per-method
| limits with:
|
|       $this->methods['METHOD_NAME']['limit'] = [NUM_REQUESTS_PER_HOUR];
|
| See application/controllers/api/example.php for examples
*/
$config['api_enable_limits'] = false;

/*
|--------------------------------------------------------------------------
| API Limits Table Name
|--------------------------------------------------------------------------
|
| If not using the default table schema in 'api_enable_limits', specify the
| table name to match e.g. my_limits
|
*/
$config['api_limits_table'] = 'api_limits';

/*
|--------------------------------------------------------------------------
| API Ignore HTTP Accept
|--------------------------------------------------------------------------
|
| Set to true to ignore the HTTP Accept and speed up each request a little.
| Only do this if you are using the $this->api_format or /format/xml in URLs
|
*/
$config['api_ignore_http_accept'] = false;

/*
|--------------------------------------------------------------------------
| API AJAX Only
|--------------------------------------------------------------------------
|
| Set to true to allow AJAX requests only. Set to false to accept HTTP requests
|
| Note: If set to true and the request is not AJAX, a 505 response with the
| error message 'Only AJAX requests are accepted.' will be returned.
|
| Hint: This is good for production environments
|
*/
$config['api_ajax_only'] = false;

/*
|--------------------------------------------------------------------------
| API Language File
|--------------------------------------------------------------------------
|
| Language file to load from the language directory
|
*/
$config['api_language'] = 'english';

/*
|--------------------------------------------------------------------------
| CORS Check
|--------------------------------------------------------------------------
|
| Set to true to enable Cross-Origin Resource Sharing (CORS). Useful if you
| are hosting your API on a different domain from the application that
| will access it through a browser
|
*/
$config['check_cors'] = false;

/*
|--------------------------------------------------------------------------
| CORS Allowable Headers
|--------------------------------------------------------------------------
|
| If using CORS checks, set the allowable headers here
|
*/
$config['allowed_cors_headers'] = [
    'Origin',
    'X-Requested-With',
    'Content-Type',
    'Accept',
    'Access-Control-Request-Method',
    'Authorization',
    'X-API-KEY'
];

/*
|--------------------------------------------------------------------------
| CORS Allowable Methods
|--------------------------------------------------------------------------
|
| If using CORS checks, you can set the methods you want to be allowed
|
*/
$config['allowed_cors_methods'] = [
    'GET',
    'POST',
    'OPTIONS',
    'PUT',
    'PATCH',
    'DELETE',
];

/*
|--------------------------------------------------------------------------
| CORS Allow Any Domain
|--------------------------------------------------------------------------
|
| Set to true to enable Cross-Origin Resource Sharing (CORS) from any
| source domain
|
*/
$config['allow_any_cors_domain'] = false;

/*
|--------------------------------------------------------------------------
| CORS Allowable Domains
|--------------------------------------------------------------------------
|
| Used if $config['check_cors'] is set to true and $config['allow_any_cors_domain']
| is set to false. Set all the allowable domains within the array
|
| e.g. $config['allowed_origins'] = ['http://www.example.com', 'https://spa.example.com']
|
*/
$config['allowed_cors_origins'] = [];

/*
|--------------------------------------------------------------------------
| CORS Forced Headers
|--------------------------------------------------------------------------
|
| If using CORS checks, always include the headers and values specified here
| in the OPTIONS client preflight.
| Example:
| $config['forced_cors_headers'] = [
|   'Access-Control-Allow-Credentials' => 'true'
| ];
|
| Added because of how Sencha Ext JS framework requires the header
| Access-Control-Allow-Credentials to be set to true to allow the use of
| credentials in the API Proxy.
| See documentation here:
| http://docs.sencha.com/extjs/6.5.2/classic/Ext.data.proxy.Rest.html#cfg-withCredentials
|
*/
$config['forced_cors_headers'] = [
    // 'Access-Control-Allow-Credentials' => 'true', // Enable only when use case above is true
];
