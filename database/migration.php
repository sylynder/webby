<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Declare Migrate Array Variable
|--------------------------------------------------------------------------
|
| Migrate array variable to hold all configurations
| Do not edit the variable below in anyway
| Only modify the values of the $migrate array
|
*/
$migrate = [];

/*
|--------------------------------------------------------------------------
| Enable/Disable Migrations
|--------------------------------------------------------------------------
|
| Migrations are disabled by default for security reasons.
| You should enable migrations whenever you intend to do a schema migration
| and disable it back when you're done.
|
*/
$migrate['migration_enabled'] = true;

/*
|--------------------------------------------------------------------------
| Migration Type
|--------------------------------------------------------------------------
|
| Migration file names may be based on a sequential identifier or on
| a timestamp. Options are:
|
|   'sequential' = Sequential migration naming (001_add_blog.php)
|   'timestamp'  = Timestamp migration naming (20121031104401_add_blog.php)
|                  Use timestamp format YYYYMMDDHHIISS.
|
| Note: If this configuration value is missing the Migration library
|       defaults to 'sequential' for backward compatibility with CI2.
|
*/
$migrate['migration_type'] = 'timestamp';

/*
|--------------------------------------------------------------------------
| Migrations table
|--------------------------------------------------------------------------
|
| This is the name of the table that will store the current migrations state.
| When migrations runs it will store in a database table which migration
| level the system is at. It then compares the migration level in this
| table to the $config['migration_version'] if they are not the same it
| will migrate up. This must be set.
|
*/
$migrate['migration_table'] = 'migrations';

/*
|--------------------------------------------------------------------------
| Auto Migrate To Latest
|--------------------------------------------------------------------------
|
| If this is set to true when you load the migrations class and have
| $config['migration_enabled'] set to true the system will auto migrate
| to your latest migration (whatever $config['migration_version'] is
| set to). This way you do not have to call migrations anywhere else
| in your code to have the latest migration.
|
*/
$migrate['migration_auto_latest'] = false;

/*
|--------------------------------------------------------------------------
| Migrations version
|--------------------------------------------------------------------------
|
| This is used to set migration version that the file system should be on.
| If you run $this->migration->current() this is the version that schema will
| be upgraded / downgraded to.
|
*/
$migrate['migration_version'] = 0;

/*
|--------------------------------------------------------------------------
| Migrations Path
|--------------------------------------------------------------------------
|
| Path to your migrations folder.
| Typically, it will be within your application path.
| Also, writing permission is required within the migrations path.
|
*/
$migrate['migration_path'] = ROOTPATH.'database/migrations/';

/*
|
| Get all migrate array and define them as constants
| This is a workaround to make configuration work
| Do not edit the constants below in anyway
|
*/

define('MIGRATION_ENABLED', $migrate['migration_enabled']);
define('MIGRATION_TYPE', $migrate['migration_type']);
define('MIGRATION_TABLE', $migrate['migration_table']);
define('MIGRATION_AUTO_LATEST', $migrate['migration_auto_latest']);
define('MIGRATION_VERSION', $migrate['migration_version']);
define('MIGRATION_PATH', $migrate['migration_path']);
