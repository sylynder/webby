<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Plate Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah Nti
 */

// ------------------------------------------------------------------------

if ( ! function_exists('view')) 
{
    /**
     * Undocumented function
     *
     * @param string $view_path
     * @param arrat $view_data
     * @return void
     */
    function view($view_path, $view_data = null)
    {
        $view_path = dot($view_path);

        ci()->load->view($view_path, $view_data);
    }
}

