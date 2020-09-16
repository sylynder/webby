<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Webby Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah-Nti
 */

// ------------------------------------------------------------------------


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

if ( ! function_exists('slugify')) 
{
    /**
     * create strings with hyphen seperated
     *
     * @param string $string
     * @return void
     */
    function slugify($string)
    {
        ci()->load->helper('url');
        return strtolower(url_title($string));
    }
}

if ( ! function_exists('extract_email_name')) 
{
    /**
     * Extract name from a given email address
     *
     * @param string $email
     * @return void
     */
    function extract_email_name($email)
    {
        $email = explode('@', $email);

        return $name = $email[0];
    }
}

if ( ! function_exists('string_dot_extract')) 
{
    /**
     * Extract dot from a string
     *
     * @param [type] $string
     * @return void
     */
    function string_dot_extract($string)
    {
        $string = explode('.', $string);

        return $name = $string[0];
    }
}

if ( ! function_exists('exploded_title')) 
{
    /**
     * Explode Title
     *
     * @param string $title
     * @return void
     */
    function exploded_title($title)
    {
        return @trim(@implode('-', @preg_split("/[\s,-\:,()]+/", @$title)), '');
    }
}

if ( ! function_exists('string_clean')) 
{
    /**
     * Clean by removing spaces and special 
     * characters from string
     *
     * @param string $string
     * @return void
     */
    function string_clean($string)
    {
        $string = str_replace(' ', '', $string); // Replaces all spaces.

        return $text = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}

if ( ! function_exists('replace_string')) 
{
    /**
     * search for a string 
     * and replace string with another
     *
     * @param string $string
     * @param string $word
     * @param string $replace_with
     * @return void
     */
    function replace_string($string, $word, $replace_with)
    {
        if (find_word($string, $word)) {
            return str_replace($word, $replace_with, $string);
        }

        return false;
    }
}

if ( ! function_exists('remove_underscore')) 
{  
    /**
     * remove underscore from string
     *
     * @param string $str
     * @return void
     */
    function remove_underscore($str)
    {
        return str_replace("_", " ", $str);
    }
}


if ( ! function_exists('remove_hyphen')) 
{

    /**
     * remove hyphen from string
     *
     * @param string $str
     * @return void
     */
    function remove_hyphen($str)
    {
        return str_replace("-", " ", $str);
    }
}

if ( ! function_exists('readable')) 
{
    /**
     *
     * remove hyphen or underscore from 
     * string and you can capitalize it 
     *
     * @param string $str
     * @param boolean $capitalize
     * @return void
     */
    function readable($str, $capitalize = false)
    {
        $str = remove_underscore($str);
        $str = remove_hyphen($str);

        if ($capitalize) {
            $str = ucwords($str);
        }

        return $str;
    }
}

if ( ! function_exists('limit_words')) 
{
    /**
     * Limt length of a sentence of a given string
     *
     * @param string $text
     * @param int $limit
     * @param string $ending_character
     * @return void
     */
    function limit_words($text, $limit, $ending_character = '&#8230;')
    {
        ci()->load->helper('text');

        return word_limiter($text, $limit, $ending_character);
    }
}

if ( ! function_exists('truncate_text')) 
{
    /**
     * Truncate words of a given string
     *
     * @param string $text
     * @param int $limit
     * @param string $ending_character
     * @return void
     */
    function truncate_text($text, $limit, $ending_character = '&#8230;')
    {
        ci()->load->helper('text');

        return character_limiter($text, $limit, $ending_character);
    }
}