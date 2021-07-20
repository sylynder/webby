<?php
defined('COREPATH') OR exit('No direct script access allowed');

use Base\View\Plates;

/**
 *  Plate Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah-Nti
 */

// ------------------------------------------------------------------------

if ( ! function_exists('plates')) 
{
    /**
     * Plates object
     *
     * @param array $params
     * @return Plates
     */
    function plates($params = array())
    {
        return (new Plates($params));
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('view')) 
{
    /**
     * A heavy lifting view function for the 
     * CodeIgniter $this->load->view() [enhanced]
     *
     * It also handles other templating engines
     * 
     * @param string $view_path
     * @param array $view_data
     * @param bool $return 
     * @return object|string
     */
    function view($view_path, $view_data = [], $return = false)
    {
        $view_path = dot2slash($view_path);

        if (config('view')['view_engine'] === '') {
            return ci()->load->view($view_path, $view_data, $return);
        }
        
        // Get the evaluated view contents for the given plates view
        if (config('view')['view_engine'] === 'plates') 

        if ($view_data === null) {
			return plates()->view($view_path);
		}

		return plates()->set($view_data)->view($view_path);
        
    }
}

if ( ! function_exists('mail_view')) 
{
    /**
     * Used for finding mail views
     *
     * @param string $mail_view_path where to find the mail view
     * @param array $mail_data
     * @return string
     */
    function mail_view($mail_view_path, $mail_data)
    {
        $layout = null;
        $view = null;

        $mail_view_path = dot2slash($mail_view_path);

        if (strstr($mail_view_path, '::')) {
            $mail_view_path = strtoarr('::', $mail_view_path);
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

if ( ! function_exists('partial')) 
{
    /**
     * For loading header and footer views
     * or any includable view
     *
     * @param string $view_path
     * @param array $view_data
     * @return string
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
        return view($view_path, $view_data);
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
     * @return string
     */
    function layout(
        $layout_path, 
        $view_path = null, 
        $view_data = null
    ) {

        if (! is_null($view_path) && isset($view_path) )
        {
            $view_data['content'] = $view_path;
        }

        return view($layout_path, $view_data);
    }
}
