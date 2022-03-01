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
    function resource($path = null, $item = null)
    {
        $path = dot2slash($path);

        if ( ! is_null($path)) {
            $path = 'resources' . DIRECTORY_SEPARATOR . $path;
        }

        if ( ! is_null($item)) {
            $path .= '/'.$item;
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
     * @param  string   $filepath
     * @return string 
     */
    function asset($filepath = null)
    {
        if($filepath !== null) 
        {
            return site_url() . ASSETS . $filepath;
        } 

        return site_url() . ASSETS;

    }
}


if ( ! function_exists('img')) 
{
    /**
     * Load image assets
     *
     * @param string $filepath
     * @return string
     */
    function img($filepath = null)
    {
        return asset($filepath);
    }
}

if ( ! function_exists('css')) 
{
    /**
     * Load css assets
     *
     * @param string $filepath
     * @return string
     */
    function css($filepath = null)
    {
        return asset($filepath);
    }
}

if ( ! function_exists('js')) 
{
    /**
     * Load javascript assets
     *
     * @param string $filepath
     * @return string
     */
    function js($filepath = null)
    {
        return asset($filepath);
    }
}


if ( ! function_exists('use_url')) 
{
    /**
     * Use an external asset from
     * a given url or source
     *
     * @param string $filepath
     * @param string $package
     * @return string
     */
    function use_url($url = null, $ext = false)
    {
        return ($ext) ? str_ext($url) : $url;
    }
}

if ( ! function_exists('use_asset')) 
{
    /**
     * Load assets for a package
     * This targets a module placed in app/Packages
     *
     * @param string $filepath 
     * @param string $package
     * @return string
     */
    function use_asset($filepath = null, $package = '')
    {
        $path = 'packages';
        $assets = 'assets';

        if ($filepath === null) {
            throw new \Exception('filepath needs to be specified');
        }

        if (empty($package)) {
            $package = strtolower(ci('router')->fetch_module());
        }

        return load_path($path .DS. $package) .DS.$assets.DS. $filepath;
    }
}

if ( ! function_exists('use_css')) 
{
    /**
     * Alias to the above function
     * but loads only css files
     *
     * @param string $filepath
     * @param string $package
     * @return string
     */
    function use_css($filepath = null, $package = '', $ext = '.css')
    {
        $filepath = str_ext($filepath, true);

        return use_asset($filepath.$ext, $package);
    }
}

if ( ! function_exists('use_js')) 
{
    /**
     * Alias to the above function
     * but loads only js files
     *
     * @param string $filepath
     * @param string $package
     * @return string
     */
    function use_js($filepath = null, $package = '', $ext = '.js')
    {
        $filepath = str_ext($filepath, true);

        return use_asset($filepath . $ext, $package);
    }
}
