<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
if ( ! function_exists( 'select_db' )) 
{
    /**
     * Select a database to use
     *
     * @param string $database_name
     * @return void
     */
    function select_db(string $database_name)
	{
        return ci()->db->db_select($database_name);
	}
}

if ( ! function_exists( 'external_db' )) 
{
    /**
     * Select a secondary or 
     * external database to use
     *
     * @param string $db_group
     * @return void
     */
    function external_db(string $db_group)
	{
        return ci()->load->database($db_group, true);
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
     * @return void
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