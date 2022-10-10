<?php
defined('COREPATH') or exit('No direct script access allowed');

/**
 *  DB Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah-Nti
 */

// ------------------------------------------------------------------------


/* ------------------------------- DB Functions ---------------------------------*/

if ( ! function_exists('use_table'))
{
	/**
	 * Select and use any table by specifying
	 * the table name
	 * 
	 * By default it uses the EasyModel class
	 * 
	 * @param string $table
	 * @return object
	 */
	function use_table($table = '', $model_type = 'EasyModel')
	{
		if ($model_type === 'EasyModel') {
			$model = new \Base\Models\EasyModel;
		}

		if ($model_type === 'BaseModel') {
			$model = new \Base\Models\BaseModel();
		}

		if ($model_type === 'OrmModel') {
			$model = new \Base\Models\OrmModel;
		}

		if ($model_type === 'Model') {
			$model = new \Base\Models\Model;
		}

		// This will default to EasyModel unless 
		// $model_type is changed appropriately
        if (empty($table)) {
			return $model;
		}

		$model->table = $table;

		return $model;
	}
}

if ( ! function_exists( 'use_db' ))
{
    /**
     * CodeIgniter's database object
     *
     * @return object
     */
    function use_db($database_name = null, $db_group = 'default')
	{
		$db = null;

		if (contains('://', $database_name) || contains('=', $database_name)) {
			$db = ci()->load->database($database_name, true);
			return ci()->db =  $db;
		}

		if (strstr($db_group, '.')) {
			$db_group = str_replace('.', '/', $db_group);
		}

		if (contains('/', $db_group)) {

			$module = $config_file = $config_name = null;

			[$module, $config_file, $config_name] = explode('/', $db_group);

			ci()->load->config(ucfirst($module).'/'.ucfirst($config_file));

			$db_config = ci()->config->item($config_name);

			$db = ci()->load->database($db_config, true);
		}

		if ($db_group === 'default' && $db === null) {
			ci()->load->database($db_group);
		} else if ($db_group !== 'default' && $db === null) {
			ci()->load->database($db_group);
		}

		ci()->db = $db ?? ci()->db;

		$exists = $database_name !== null && select_db($database_name);

		if ($exists) {
			return ci()->db;
		} else {
			ci()->load->database();
		}
		
        return ci()->db;
	}
}

if ( ! function_exists( 'select_db' )) 
{
    /**
     * Select a database to use
     *
     * @param string $database_name
     * @return mixed
     */
    function select_db(string $database_name)
	{
        return ci()->db->db_select($database_name);
	}
}

if ( ! function_exists( 'close_db' )) 
{
    /**
     * Close a selected database
     *
     * @return void
     */
    function close_db()
	{
        ci()->db->close();
	}
}

if ( ! function_exists( 'max_id' )) 
{
    /**
     * This function let's you get
     * highest id value from a table.
     * 
     * @param string $table
     * @param string $select_as
     * @return string|int
     */
    function max_id($table, $select_as=null) {
		
		if($select_as != null) {
			$maxid = ci()->db->query('SELECT MAX(id) AS '.$select_as.' FROM ' . $table)->row()->$select_as; 
		} else {
			$maxid = ci()->db->query('SELECT MAX(id) AS biggest  FROM '. $table)->row(); 
        }
        
        return $maxid;
    }
}

if ( ! function_exists('add_foreign_key'))
{
	/**
	 * @param string $table       Table name
	 * @param string $foreign_key Collumn name having the Foreign Key
	 * @param string $references  Table and column reference. Ex: users(id)
	 * @param string $on_delete   RESTRICT, NO ACTION, CASCADE, SET NULL, SET DEFAULT
	 * @param string $on_update   RESTRICT, NO ACTION, CASCADE, SET NULL, SET DEFAULT
	 *
	 * @return string SQL command
	 */
	function add_foreign_key($table, $foreign_key, $references, $on_delete = 'RESTRICT', $on_update = 'RESTRICT')
	{
		$references = explode('(', str_replace(')', '', str_replace('`', '', $references)));

		return "ALTER TABLE `{$table}` ADD CONSTRAINT `{$table}_{$foreign_key}_fk` FOREIGN KEY (`{$foreign_key}`) REFERENCES `{$references[0]}`(`{$references[1]}`) ON DELETE {$on_delete} ON UPDATE {$on_update}";
	}
}

if ( ! function_exists('drop_foreign_key'))
{
	/**
	 * @param string $table       Table name
	 * @param string $foreign_key Collumn name having the Foreign Key
	 *
	 * @return string SQL command
	 */
	function drop_foreign_key($table, $foreign_key)
	{
		return "ALTER TABLE `{$table}` DROP FOREIGN KEY `{$table}_{$foreign_key}_fk`";
	}
}

if ( ! function_exists('add_trigger'))
{
	/**
     * Add an SQL Trigger Command
     * 
	 * @param string $trigger_name Trigger name
	 * @param string $table        Table name
	 * @param string $statement    Command to run
	 * @param string $time         BEFORE or AFTER
	 * @param string $event        INSERT, UPDATE or DELETE
	 * @param string $type         FOR EACH ROW [FOLLOWS|PRECEDES]
	 *
	 * @return string SQL Command
	 */
	function add_trigger($trigger_name, $table, $statement, $time = 'BEFORE', $event = 'INSERT', $type = 'FOR EACH ROW')
	{
		return 'DELIMITER ;;' . PHP_EOL . "CREATE TRIGGER `{$trigger_name}` {$time} {$event} ON `{$table}` {$type}" . PHP_EOL . 'BEGIN' . PHP_EOL . $statement . PHP_EOL . 'END;' . PHP_EOL . 'DELIMITER ;;';
	}
}

if ( ! function_exists('drop_trigger'))
{
    /**
     * Trigger an SQL Command using name
     *
     * @param string $trigger_name Trigger name
     * @return string SQL Command
     */
	function drop_trigger($trigger_name)
	{
		return "DROP TRIGGER {$trigger_name};";
	}
}
