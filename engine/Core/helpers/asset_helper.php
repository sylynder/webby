<?php

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
        if ( ! empty($path) && is_dir(APPROOT . $path)) {
            return APPROOT . $path . DIRECTORY_SEPARATOR;
        }

        if (empty($path)) {
            return APPROOT;
        }

        if ( ! empty($path) && !is_dir(APPROOT . $path)) {
            return;
            // throw new Exception("Path ". $path . " cannot be found");
        }

        return;
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
