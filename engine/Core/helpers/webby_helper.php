<?php

defined('BASEPATH') or exit('No direct script access allowed');

/* ------------------------------- Random Code Generation Functions ---------------------------------*/

if ( ! function_exists('unique_code')) 
{
    /**
     * Generates unique ids/codes
     *
     * @param integer $limit
     * @return void
     */
    function unique_code(int $limit = 13)
    {
      return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}

if ( ! function_exists('unique_id')) 
{
    /**
     * Generates unique ids
     *
     * @param integer $length
     * @return void
     */
    function unique_id(int $length = 13) 
    {

        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $length);
    }
}

/* ------------------------------- String Functions ---------------------------------*/

if ( ! function_exists('dot')) 
{
    /**
     * Check if dot exists in string
     * and replace with forward slash
     *
     * @param string $string
     * @return void
     */
    function dot(string $string)
    {
        if (strstr($string, '/')) {
            $string = $string;
        }

        if (strstr($string, '.')) {
            $string = str_replace('.', '/', $string);
        }

        return $string;
    }
}

if ( ! function_exists('dot')) 
{
    /**
     * Check if dot exists in string
     * and replace with forward slash
     *
     * @param string $string
     * @return void
     */
    function dot_to_slash(string $string)
    {
        if (strstr($string, '/')) {
            $string = $string;
        }

        if (strstr($string, '.')) {
            $string = str_replace('.', '/', $string);
        }

        return $string;
    }
}

if ( ! function_exists('with_dot')) 
{

    /**
     * Check if dot exists in string
     * Also checks if string is array
     * and replace with forward slash
     * 
     * 
     * @param string|array $string
     * @return void
     */
    function with_dot($string)
    {
        $output = [];

        if (is_array($string)) {

            foreach ($string as $key => $value)
            {
                
                if (is_int($key))
                {
                    $output[] = dot($value);
                }
                else
                {
                    $output[] = dot($value);
                }
            }
        }

        if (!is_array($string)) {
            $output = dot($string);
        }

        return $output;
    }
}

if ( ! function_exists('str_left_zeros')) 
{
    /**
     * prefix zeros at the beginning of a string
     * 
     * @param mixed $value
     * @param int $length
     * @return void
     */
    function str_left_zeros($value, $length)
    {
        return str_pad($value, $length, '0', STR_PAD_LEFT);
    }
}

if ( ! function_exists('str_right_zeros')) 
{
    /**
     * suffix zeros at the end of a string
     *
     * @param mixed $value
     * @param int $length
     * @return void
     */
    function str_right_zeros($value, $length)
    {
        return str_pad($value, $length, '0', STR_PAD_RIGHT);
    }
}


