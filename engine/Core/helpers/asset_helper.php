<?php
defined('COREPATH') or exit('No direct script access allowed');

/* ------------------------------- Path Functions ---------------------------------*/

if ( ! function_exists('public_path')) 
{
    /**
     * Path to the public directory
     *
     * @param string $path
     * @return string
     */
    function public_path($path = '')
    {   
        if ( ! empty($path) && is_dir(FCPATH . $path)) {
            return FCPATH . $path . DIRECTORY_SEPARATOR;
        }

        if (empty($path)) {
            return FCPATH;
        }

        return;
    }
}

if ( ! function_exists('app_path')) 
{
    /**
     * Path to the app directory
     * This represents the APPROOT 
     * instead of APPPATH
     * 
     * @param string $path
     * @return string
     */
    function app_path($path = '')
    {   
        if (empty($path)) {
            return APPROOT;
        }

        if ( ! empty($path) && is_dir(APPROOT . $path)) {
            return APPROOT . $path . DIRECTORY_SEPARATOR;
        }

        if ( ! empty($path) && is_file(APPROOT . $path)) {
            return APPROOT . $path;
        }

        if ( ! empty($path) && !is_dir(APPROOT . $path)) {
            return;
            // throw new Exception("Path ". $path . " cannot be found");
        }

        return APPROOT;
    }
}

if ( ! function_exists('writable_path')) 
{
    /**
     * Path to the writable directory
     *
     * @param string $path
     * @return string
     */
    function writable_path($path = '')
    {   
        if ( ! empty($path) && is_dir(WRITABLEPATH . $path)) {
            return WRITABLEPATH . $path . DIRECTORY_SEPARATOR;
        }

        return;
    }
}

if ( ! function_exists('load_path')) 
{
	/**
     * Load other folders from the public folder
     * @param  string $path
     * @return string
     */
	function load_path($path)
	{
		return site_url() . $path;
	}
}

if ( ! function_exists('resource')) 
{
	/**
     * Load files from resource folder
     * by the use of CodeIgniter's site_url() function
     * 
     * @param  string   $path
     * @return string 
     */
	function resource($path = null)
	{
        if ( ! is_null($path)) {
		    $path = 'resources' . DIRECTORY_SEPARATOR . $path;
        }
        
		return (!empty($path)) ? load_path($path) : site_url() . ASSETS;
	}
}

if ( ! function_exists('asset')) 
{
	/**
     * Load assets folder
     * by the use of CodeIgniter's site_url() function
     * 
     * @param  string   $file_path
     * @return string 
     */
	function asset($file_path = null)
	{
		if($file_path !== null) 
		{
			return site_url() . ASSETS . $file_path;
		} 

		return site_url() . ASSETS;

	}
}

if ( ! function_exists('img')) 
{
    /**
     * Load image assets
     *
     * @param string $file_path
     * @return string
     */
	function img($file_path = null)
	{
		return asset($file_path);
	}
}

if ( ! function_exists('css')) 
{
    /**
     * Load css assets
     *
     * @param string $file_path
     * @return string
     */
	function css($file_path = null)
	{
		return asset($file_path);
	}
}

if ( ! function_exists('js')) 
{
    /**
     * Load javascript assets
     *
     * @param string $file_path
     * @return string
     */
	function js($file_path = null)
	{
		return asset($file_path);
	}
}
