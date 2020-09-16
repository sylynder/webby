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
     * A view function for the CodeIgniter 
     * $this->load->view()
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

if ( ! function_exists('section')) 
{
    /**
     * load a view section
     * @param string $view_path       
     * @param array [$view_data=null]
     */
    function section($view_path, $view_data = null)
    {
        $view_path = dot($view_path);

        ci()->load->view($view_path, $view_data);
    }
}