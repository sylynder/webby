<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Plate Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah-Nti
 */

// ------------------------------------------------------------------------

if ( ! function_exists('mail_view')) 
{
    /**
     * Used for finding mail views
     *
     * @param string $mail_view_path where to find the mail view
     * @param array $mail_data
     * @return void
     */
    function mail_view($mail_view_path, $mail_data)
    {
        $layout = null;
        $view = null;

        $mail_view_path = dot_to_slash($mail_view_path);

        if (strstr($mail_view_path, '::')) {
            $mail_view_path = string_to_array('::', $mail_view_path);
        }

        if (empty($mail_data)) {
            $exception_message = "Email data cannot be empty as second paramater";
            throw new Exception($exception_message); 
            log_message('error', $exception_message);
        }

        if ( ! is_array($mail_data)) {
            $exception_message = "Email data should be array";
            throw new Exception($exception_message); 
            log_message('error', $exception_message);
        }

        if ( ! is_array($mail_view_path)) {
            $exception_message = "Email view malformed, make sure it has the 'double colon' symbol '::' in it";
            throw new Exception($exception_message); 
            log_message('error', $exception_message);
            exit;
        }

        $layout = $mail_view_path[0];
        $view = $mail_view_path[1];
        $mail_data = add_associative_array($mail_data, 'content', $view);

        return ci()->load->view($layout, $mail_data, true);
    }
}

if ( ! function_exists('view')) 
{
    /**
     * A view function for the CodeIgniter 
     * $this->load->view()
     *
     * @param string $view_path
     * @param array $view_data
     * @param bool $return 
     * @return object|string
     */
    function view($view_path, $view_data = [], $return = false)
    {
        $view_path = dot_to_slash($view_path);

        return ci()->load->view($view_path, $view_data, $return);
    }
}

if ( ! function_exists('partial')) 
{
    /**
     * For loading header and footer views
     * or any includable view
     *
     * @param string $view_path
     * @param array $view_data
     * @return void
     */
    function partial($view_path, $view_data = null)
    {
        return view($view_path, $view_data);
    }
}

if ( ! function_exists('section')) 
{
    /**
     * load a view section
     * @param string $view_path       
     * @param array $view_data=null
     */
    function section($view_path, $view_data = null)
    {
        $view_path = dot_to_slash($view_path);

        ci()->load->view($view_path, $view_data);
    }
}

if ( ! function_exists('layout')) 
{
    /**
     * Load views in a layout format
     *
     * @param string $layout_path
     * @param string $view_path
     * @param array $view_data
     * @return void
     */
    function layout($layout_path, $view_path = null, $view_data = null)
    {
        
        $layout_path = dot_to_slash($layout_path);

        if (! is_null($view_path) && isset($view_path) )
        {
            $view_data['content'] = $view_path;
        }

        return ci()->load->view($layout_path, $view_data);
    }
}