<?php

/**
 *  DB Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah-Nti
 */

// ------------------------------------------------------------------------

defined('BASEPATH') or exit('No direct script access allowed');

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