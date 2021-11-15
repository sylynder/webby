<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|    ['dsn']      The full DSN string describe a connection to the database.
|    ['hostname'] The hostname of your database server.
|    ['username'] The username used to connect to the database
|    ['password'] The password used to connect to the database
|    ['database'] The name of the database you want to connect to
|    ['dbdriver'] The database driver. e.g.: mysqli.
|            Currently supported:
|                 cubrid, ibase, mssql, mysql, mysqli, oci8,
|                 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|    ['dbprefix'] You can add an optional prefix, which will be added
|                 to the table name when using the  Query Builder class
|    ['pconnect'] true/false - Whether to use a persistent connection
|    ['db_debug'] true/false - Whether database errors should be displayed.
|    ['cache_on'] true/false - Enables/disables query caching
|    ['cachedir'] The path to the folder where cache files should be stored
|    ['char_set'] The character set used in communicating with the database
|    ['dbcollat'] The character collation used in communicating with the database
|                 NOTE: For MySQL and MySQLi databases, this setting is only used
|                  as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|                 (and in table creation queries made with DB Forge).
|                  There is an incompatibility in PHP with mysql_real_escape_string() which
|                  can make your site vulnerable to SQL injection if you are using a
|                  multi-byte character set and are running versions lower than these.
|                  Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|    ['swap_pre'] A default table prefix that should be swapped with the dbprefix
|    ['encrypt']  Whether or not to use an encrypted connection.
|
|            'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept true/false
|            'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|                'ssl_key'    - Path to the private key file
|                'ssl_cert'   - Path to the public key certificate file
|                'ssl_ca'     - Path to the certificate authority file
|                'ssl_capath' - Path to a directory containing trusted CA certificates in PEM format
|                'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|                'ssl_verify' - true/false; Whether verify the server certificate or not ('mysqli' only)
|
|    ['compress'] Whether or not to use client compression (MySQL only)
|    ['stricton'] true/false - forces 'Strict Mode' connections
|                            - good for ensuring strict SQL while developing
|    ['ssl_options']    Used to set various SSL options that can be used when making SSL connections.
|    ['failover'] array - A array with 0 or more data for connections if the main should fail.
|    ['save_queries'] true/false - Whether to "save" all executed queries.
|                 NOTE: Disabling this will also effectively disable both
|                 $this->db->last_query() and profiling of DB queries.
|                 When you run a query, with this setting set to true (default),
|                 CodeIgniter will store the SQL statement for debugging purposes.
|                 However, this may cause high memory usage, especially if you run
|                 a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
 */

$active_group = 'default';
$query_builder = true;

//DB constants found in config/constants.php file
//It is configured to use .env file as a quick setup

$db['default'] = [
    'dsn' => '',
    'hostname' => APP_DB_HOSTNAME,
    'username' => APP_DB_USERNAME,
    'password' => APP_DB_PASSWORD,
    'database' => APP_DB_NAME,
    'dbdriver' => defined('APP_DB_DRIVER') ? APP_DB_DRIVER : 'mysqli',
    'dbprefix' => '',
    'pconnect' => false,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => false,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt' => false,
    'compress' => false,
    'stricton' => false,
    'failover' => [],
    'save_queries' => true,
]; 

$db['test'] = [
    'dsn' => '',
    'hostname' => TEST_DB_HOSTNAME,
    'username' => TEST_DB_USERNAME,
    'password' => TEST_DB_PASSWORD,
    'database' => TEST_DB_NAME,
    'dbdriver' => defined('APP_DB_DRIVER') ? TEST_DB_DRIVER : 'mysqli',
    'dbprefix' => '',
    'pconnect' => false,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => false,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt' => false,
    'compress' => false,
    'stricton' => false,
    'failover' => [],
    'save_queries' => true,
];

$db['auth_db'] = [
    'dsn' => '',
    'hostname' => APP_DB_HOSTNAME,
    'username' => APP_DB_USERNAME,
    'password' => APP_DB_PASSWORD,
    'database' => APP_AUTH_DB,
    'dbdriver' => defined('APP_DB_DRIVER') ? APP_DB_DRIVER : 'mysqli',
    'dbprefix' => '',
    'pconnect' => false,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => false,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt' => false,
    'compress' => false,
    'stricton' => false,
    'failover' => [],
    'save_queries' => true,
];

$db['pgsql'] = [
    'dsn' => PGSQL_DB_DSN,
    'hostname' => PGSQL_DB_HOSTNAME,
    'username' => PGSQL_DB_USERNAME,
    'password' => PGSQL_DB_PASSWORD,
    'database' => PGSQL_DB_NAME,
    'port'     => PGSQL_DB_PORT,
    'dbdriver' => defined('PGSQL_DB_DRIVER') ? PGSQL_DB_DRIVER : 'pdo',
    'dbprefix' => '',
    'pconnect' => false,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => false,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt' => false,
    'compress' => false,
    'stricton' => false,
    'failover' => [],
    'save_queries' => true,
];
