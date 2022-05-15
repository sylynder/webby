<?php
defined('COREPATH') or exit('No direct script access allowed');

/**
 *  Webby Helper functions
 *
 *  @package		Webby
 *	@subpackage		Helpers
 *	@category		Helpers
 *	@author			Kwame Oteng Appiah-Nti
 */

/* ------------------------------- Random Code Generation Functions ---------------------------------*/

if ( ! function_exists('unique_code')) 
{
    /**
     * Generates unique ids/codes
     *
     * @param integer $limit
     * @return string
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
     * @return string
     */
    function unique_id(int $length = 13) 
    {

        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $length);
    }
}

/* ------------------------------- Config Functions ---------------------------------*/

if ( ! function_exists('config')) 
{
     /**
      * Fetch/Set a config file item
      *
      * @param array|string $key
	  * @param mixed $value
	  * @return mixed
      */
    function config($key = null, $value = null)
	{
		if (is_null($key)) {
			return ci('config');
		}

		if (is_array($key)) {
			foreach ($key as $item => $val) {
				config($item, $val);
			}

			return '';
		}

		if ( ! is_null($value)) {
			return ci('config')->set_item($key, $value);
		}

		return ci('config')->item($key);
	}
}

/* ------------------------------- Session Functions ---------------------------------*/

if ( ! function_exists('init_session'))
{
    /**
     * This function is used to initialize or create sessions
     * same as the native session_start function.
     * @return 
     */
    function init_session()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); //the good old friend
        }
    }
}

if ( ! function_exists('sessions'))
{
    /**
     * This function is used for retrieving all Session Data
     * @return array (all session data)
     */
    function sessions()
    {
        ci()->load->library('session');
        return ci()->session->all_userdata();
    }
}

if ( ! function_exists('session'))
{
    /**
     * Add or retrieve a session data
     *
     * @param array|string $key
     * @param string|null $value
     * @return string|null|object
     */
    function session($key = null, $value = null)
    {
        ci()->load->library('session'); 

        if (empty($key)) {
            return ci()->session;
        }

        if (is_array($key)) {
            return ci()->session->set_userdata($key);
        }

        if (!is_null($value) && is_string($key)) {
            return ci()->session->set_userdata($key, $value);
        }

        return ci()->session->userdata($key);
    }
}

if ( ! function_exists('remove_session'))
{
    /**
     * Remove session data
     *
     * @param array|string $key
     * @return void
     */
    function remove_session($key)
    {
        ci()->load->library('session');
        ci()->session->unset_userdata($key);
    }
}

if ( ! function_exists('has_session'))
{
    /**
     * Verify if a session value exists
     *
     * @param string $key
     * @return bool
     */
    function has_session($key)
    {
        ci()->load->library('session');
        return ci()->session->has_userdata($key);
    }
}

if ( ! function_exists('flash_session'))
{
    /**
     * Set or retrieve flash data
     *
     * @param array|string $key
     * @param string $value
     * @return string|void
     */
    function flash_session($key, $value=null)
    {
        ci()->load->library('session');

        if (is_array($key)) {
            return ci()->session->set_flashdata($key);
        }

        if (!is_null($value) && is_string($key)) {
            return ci()->session->set_flashdata($key, $value);
        }

        return ci()->session->flashdata($key);

    }
}

if ( ! function_exists('destroy_session'))
{
    /**
    * Destroy session data
    *
    * @return void
    */
    function destroy_session()
    {
        ci()->load->library('session');
        ci()->session->sess_destroy();
    }
}

if ( ! function_exists('success_message'))
{
    /**
     * Set/Get success message
     *
     * @param string $message
     * @return string
     */
    function success_message(string $message = null)  
    {

        if ($message !== null) {
           return flash_session('success_message', $message);
        }

        return flash_session('success_message');
        
    }
}

if ( ! function_exists('error_message'))
{
    /**
     * Set/Get error message
     *
     * @param string $message
     * @return string
     */
    function error_message(string $message = null)  
    {

        if ($message !== null) {
           return flash_session('error_message', $message);
        }

        return flash_session('error_message');
        
    }
}

if ( ! function_exists('info_message'))
{
    /**
     * Set/Get info message
     *
     * @param string $message
     * @return string
     */
    function info_message(string $message = null)  
    {

        if ($message !== null) {
           return flash_session('info_message', $message);
        }

        return flash_session('info_message');
        
    }
}

if ( ! function_exists('warn_message'))
{
    /**
     * Set/Get warning message
     *
     * @param string $message
     * @return string
     */
    function warn_message(string $message = null)  
    {

        if ($message !== null) {
           return flash_session('warn_message', $message);
        }

        return flash_session('warn_message');
        
    }
}

if ( ! function_exists('clear_message'))
{
    /**
     * Clearing message type
     * @return void
     */
    function clear_message($message_type)
    {
        remove_session($message_type);
    }
}

/* ------------------------------- Cache Functions ---------------------------------*/

if ( ! function_exists('cache')) 
{
    /**
     * Cache items or retreive items
     *
     * @param string $key
     * @param mixed $value
     * @param string $cache_path
     * @param integer $ttl
     * @return mixed
     */
    function cache($key = null, $value = null, $cache_path = '', $ttl = 1800)
    {
        $cache = new Base\Cache\Cache;
        $cache->expireAfter = $ttl;

        if ($key === null) {
            return $cache;
        }

        if (!empty($cache_path)) {
            $cache->setCachePath($cache_path);
        }

        if (is_string($key) && $value !== null) {
            return $cache->cacheItem($key, $value);
        }
        
        return $cache->getCacheItem($key);
    }
}

/* ------------------------------- String Functions ---------------------------------*/

if ( ! function_exists('dot2slash')) 
{
    /**
     * Check if dot exists in string
     * and replace with forward slash
     *
     * @param string $string
     * @return string
     */
    function dot2slash(string $string)
    {
        if (strstr($string, '.')) {
            $string = str_replace('.', '/', $string);
        }

        return $string;
    }
}

if ( ! function_exists('has_dot')) 
{

    /**
     * Check if dot exists in string
     * Also checks if string is array
     * and replace with forward slash
     * 
     * 
     * @param mixed $string
     * @return mixed
     */
    function has_dot($string)
    {
        $output = [];

        if (is_array($string)) {

            foreach ($string as $key => $value)
            {
                
                if (is_int($key))
                {
                    $output[] = dot2slash($value);
                }
                else
                {
                    $output[] = dot2slash($value);
                }
            }
        }

        if (!is_array($string)) {
            $output = dot2slash($string);
        }

        return $output;
    }
}

if ( ! function_exists('pad_left')) 
{
    /**
     * prefix string at the beginning of a string
     *
     * @param string $str
     * @param mixed $value
     * @param int $length
     * @return string
     */
    function pad_left($str, $value, $length)
    {
        return str_pad($value, $length, $str, STR_PAD_LEFT);
    }
}

if ( ! function_exists('pad_right')) 
{
    /**
     * suffix string at the end of a string
     *
     * @param string $str
     * @param mixed $value
     * @param int $length
     * @return string
     */
    function pad_right($str, $value, $length)
    {
        return str_pad($value, $length, $str, STR_PAD_RIGHT);
    }
}

if ( ! function_exists('str_left_zeros')) 
{
    /**
     * prefix zeros at the beginning of a string
     * 
     * @param mixed $value
     * @param int $length
     * @return string
     */
    function str_left_zeros($value, $length)
    {
        return pad_left('0', $value, $length);
    }
}

if ( ! function_exists('str_right_zeros')) 
{
    /**
     * suffix zeros at the end of a string
     *
     * @param mixed $value
     * @param int $length
     * @return string
     */
    function str_right_zeros($value, $length)
    {
        return pad_right('0', $value, $length);
    }
}

if ( ! function_exists('str2hex')) 
{
    /**
     * convert string to hexadecimal
     *
     * @param string $str
     * @return string
     */
    function str2hex($str)
    {   
        $str = trim($str);
        return bin2hex($str);
    }
}

if ( ! function_exists('hex2str')) 
{
    /**
     * convert hexadecimal to string
     *
     * @param string $hex_string
     * @return string
     */
    function hex2str(/*hexadecimal*/ $hex_string)
    {   
        $hex_string = hex2bin($hex_string); 
        return trim($hex_string);;
    }
}

if ( ! function_exists('dec2str')) 
{
    /**
     * convert decimal to string using base
     * this is made for special use case
     * else use strval() i.e from int to string
     * 
     * @param string $decimal
     * @param int $base
     * @return string
     */
    function dec2str(/*decimal*/ $decimal, $base = 36) 
    {
        $string = null;

        $base = (int) $base;
        if ($base < 2 | $base > 36 | $base == 10) {
            throw new \Exception('$base must be in the range 2-9 or 11-36');
            exit;
        }

        // maximum character string is 36 characters
        $charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // strip off excess characters (anything beyond $base)
        $charset = substr($charset, 0, $base);

        if (!preg_match('/^[0-9]{1,50}$/', trim($decimal))) {
            throw new \Exception('Value must be a positive integer with < 50 digits');
            return false;
        } 

        do {
            // get remainder after dividing by BASE
            $remainder = bcmod($decimal, $base);

            $char = substr($charset, $remainder, 1);   // get CHAR from array
            $string = "$char$string";                    // prepend to output

            //$decimal = ($decimal - $remainder) / $base;
            $decimal = bcdiv(bcsub($decimal, $remainder), $base);

        } while ($decimal > 0);

        return $string;

    }
}

if ( ! function_exists('slugify')) 
{
    /**
     * create strings with hyphen seperated
     *
     * @param string $string
     * @return string
     */
    function slugify($string, $separator = '-', $lowercase = true)
    {
        ci()->load->helper('url');
        ci()->load->helper('text');
        
        // Replace unsupported 
        // characters (if necessary more will be added)
        $string = str_replace("'", '-', $string);
        $string = str_replace(".", '-', $string);
        $string = str_replace("²", '2', $string);

        // Slugify and return the string
        return url_title(
            convert_accented_characters($string), 
            $separator, 
            $lowercase
        );
    }
}

if ( ! function_exists('extract_email_name')) 
{
    /**
     * Extract name from a given email address
     *
     * @param string $email
     * @return string
     */
    function extract_email_name($email)
    {
        $email = explode('@', $email);

        return $email[0];
    }
}

if ( ! function_exists('str_extract')) 
{
    /**
     * Extract symbol,character,word from a string
     *
     * @param string $string
     * @param string $symbol
     * @return string
     */
    function str_extract($string, $symbol)
    {
        $string = explode($symbol, $string);

        return $string = $string[0];
    }
}

if ( ! function_exists('exploded_title')) 
{
    /**
     * Explode Title
     *
     * @param string $title
     * @return string
     */
    function exploded_title($title)
    {
        return @trim(@implode('-', @preg_split("/[\s,-\:,()]+/", @$title)), '');
    }
}

if ( ! function_exists('str_clean')) 
{
    /**
     * Clean by removing spaces and special 
     * characters from string
     *
     * @param string $string
     * @return string
     */
    function str_clean($string)
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
     * @return string|bool
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
     * @return string
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
     * @return string
     */
    function remove_hyphen($str)
    {
        return str_replace("-", " ", $str);
    }
}

if ( ! function_exists('str_humanize')) 
{
    /**
     *
     * remove hyphen or underscore from 
     * string and you can capitalize it 
     *
     * @param string $str
     * @param boolean $capitalize
     * @return string
     */
    function str_humanize($str, $capitalize = false)
    {
        $str = remove_underscore($str);
        $str = remove_hyphen($str);

        if ($capitalize) {
            $str = ucwords($str);
        }

        return $str;
    }
}

if ( ! function_exists('str_ext')) 
{
    /**
     * Strips filename from extension Or
     * file extension from name
     * 
     * if $name is true return filename only
     * this is rarely used
     *
     * @param string $string
     * @return string
     */
    function str_ext(string $filename, $name = false)
    {
        if ($name) {
            return pathinfo($filename, PATHINFO_FILENAME);
        }

        return substr($filename, 0, strrpos($filename, "."));
    }
}

if ( ! function_exists('str_last_word')) 
{
    /**
     * Return last word of a string
     * 
     * @param string $string
     * @return string
     */
    function str_last_word(string $string, $symbol = ' ')
    {
        return substr($string, strrpos($string, $symbol) + 1);
    }
}

if ( ! function_exists('limit_words')) 
{
    /**
     * Limit length of a given string
     *
     * @param string $text
     * @param int $limit
     * @param string $ending_character
     * @return string
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
     * @return string
     */
    function truncate_text($text, $limit, $ending_character = '&#8230;')
    {
        ci()->load->helper('text');

        return character_limiter($text, $limit, $ending_character);
    }
}

if ( ! function_exists('str_censor')) 
{ 
    /**
     * Censor bad words from string
     *
     * @param string $text
     * @param array $words_to_censor
     * @param boolean $replacement
     * @return string
     */
    function str_censor($text, $words_to_censor, $replacement = false)
    {
        ci()->load->helper('text');

        return word_censor($text, $words_to_censor, $replacement);
    }
}

if ( ! function_exists('find_word')) 
{
    /**
     * search for word from a string
     *
     * @param string $string
     * @param string $word
     * @return string
     */
    function find_word($string, $word)
    {
        if (is_array($string)) {
            $string = arrtostr(',', $string);
        }

        if (strpos($string, $word) !== false) {
            return true;
        }

        return false;
    }
}

if ( ! function_exists('contains')) 
{
    /**
     * Returns true if $needle
     * is a substring of $haystack
     *
     * @param string $needle
     * @param mixed $haystack
     * @return void
     */
    function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }
}

if ( ! function_exists('starts_with')) 
{
    /**
     *  Determine if a given string 
     *  starts with a given substring
     *
     *  @param     string          $haystack
     *  @param     string|array    $needles
     *  @return    boolean
     */
    function starts_with($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if (
                $needle != '' &&
                substr($haystack, 0, strlen($needle)) === (string) $needle
            ) {
                return true;
            }
        }

        return false;
    }
}

if ( ! function_exists('ends_with')) 
{
    /**
     *  Determine if a given string 
     *  ends with a given substring
     *
     *  @param string $haystack
     *  @param string|array $needles
     *  @return boolean
     */
    function ends_with($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if (substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }
}

/* ------------------------------- Array Functions ---------------------------------*/

if ( ! function_exists('arrayz')) 
{
    /**
     *  Instantiate the Arrayz Class
     *
     *  @param     array     $array
     *  @return    object
     */
    function arrayz($array = [])
    {
        return(new \Base\Helpers\Arrayz($array));
    }
}

if ( ! function_exists('has_element')) 
{
    /**
     * Check if array element exists
     *
     * @param string|mixed $element
     * @param array $array
     * @return boolean
     */
    function has_element($element, $array)
    {
        if (in_array($element, $array)) {
            return true;
        }

        return false;
    }
}

if ( ! function_exists('with_each')) 
{
    /**
     * Replaces the deprecated each function
     * since PHP 7.2 but limited 
     * in it's implementation
     *
     * @param array $array
     * @return mixed
     */
    function with_each(&$array)
    {
        $key = key($array);
        $result = ($key === null) 
                            ? false 
                            : [$key, current($array), 'key' => $key, 'value' => current($array)];
        next($array);
        return $result;
    }
}

if ( ! function_exists('strtoarr')) 
{
    /**
     * Converts a string to an array
     *
     * @param string $symbol
     * @param string $string
     * @return string
     */
    function strtoarr($symbol, $string)
    {
        return explode($symbol, $string);
    }
}

if ( ! function_exists('arrtostr')) 
{
    /**
     * Converts an array to a string
     * using a given symbol e.g. ',' or ':'
     * 
     * @param string $symbol
     * @param array $array
     * @return string
     */
    function arrtostr($symbol, $array)
    {
        if ($array === null) {
            return false;
        }

        return implode($symbol, $array);
    }
}

if ( ! function_exists('add_array')) 
{
    /**
     * This is a function that 
     * helps to add an element to an array
     *
     * @param array $array
     * @param string $element
     * @param string $symbol
     * @param boolean $return_string
     * @return array
     */
    function add_array($array, $element, $symbol = null, $return_string = false)
    {
        if (!is_array($array) && $symbol != null) {
            $array = strtoarr($symbol, $array);
        }

        if (is_array($array)) {
            array_push($array, $element);
        }

        if ($return_string == true) {
            return $array = arrtostr($symbol, $array);
        }

        return $array;
    }
}

if ( ! function_exists('add_associative_array')) 
{
    /**
     * This is a function that helps to 
     * add associative key => value
     * to an associative array
     * 
     * Set multi to true to 
     * insert into multidimensional
     *
     * @param array $array
     * @param string $key
     * @param string $value
     * @return array
     */
    function add_associative_array($array, $key, $value, $multi = false)
    {
        
        if ($multi === false) {
            $array[$key] = $value;
            return $array;
        }
        
        $array = array_map(function($array) use ($key, $value){
            return $array + [$key => $value];
        }, $array);

        return $array;
    }
}

if ( ! function_exists('set_array')) 
{
    /**
     * Alias of the above function
     *
     * @param array $array
     * @param string $key
     * @param string $value
     * @return array
     */
    function set_array($array, $key, $value, $multi = false)
    {
        return add_associative_array($array, $key, $value, $multi);
    }
}

if ( ! function_exists('remove_empty_elements')) 
{
    /**
     * Remove keys and values 
     * that are empty
     *
     * @param array $array
     * @return array
     */
    function remove_empty_elements($array)
    {
            $array = array_map('array_filter', $array);
            return $array = array_filter($array);
    }
}

if ( ! function_exists('remove_first_element')) 
{
    /**
     * Removes first element of an array
     *
     * @param array $array
     * @return array
     */
    function remove_first_element($array) : array
    {
        if (is_object($array)) {
            $array = get_object_vars($array);
        }

        unset($array[current(array_keys($array))]);

        return $array;
    }
}

if ( ! function_exists('remove_from_array')) 
{
    /**
     * Removes a key or keys from an array
     *
     * @param array $array
     * @param string $element
     * @param string $symbol
     * @param boolean $return_string
     * @return array
     */
    function remove_from_array(
        $array, 
        $element, 
        $symbol = null, 
        $return_string = false
    ) :array {
        if (!is_array($array) && $symbol != null) {
            $array = strtoarr($symbol, $array);
        }

        if (is_array($array) && ($key = array_search($element, array_keys($array))) !== false) {
            unset($array[$element]);
        }

        if ($return_string == true) {
            return $array = arrtostr($symbol, $array);
        }

        return $array;
    }
}

if ( ! function_exists('remove_empty_elements')) 
{
    /**
     * Remove keys and values 
     * that are empty
     *
     * @param array $array
     * @return array
     */
    function remove_empty_elements($array)
    {
            $array = array_map('array_filter', $array);
            return $array = array_filter($array);
    }
}

if ( ! function_exists('remove_with_value')) 
{
    /**
     * Remove key and value from multidimensional array
     *
     * @param array $array
     * @param string $key
     * @param string $value
     * @return array
     */
    function remove_with_value($array, $key, $value)
    {
        
        foreach ($array as $innerKey => $innerArray) {
            if ($innerArray[$key] == $value) {
                unset($array[$innerKey]);
            }
        }

        return $array;
    }
}

if ( ! function_exists('object_array')) 
{
    /**
     * Retrieve arrays with single objects
     * And their index (For specific table 
     * operations e.g user_roles)
     *
     * @param array $object_array
     * @param int|string $index
     * @return void|object|array
     */
    function object_array($object_array, $index)
    {
        if (!empty($object_array)) {
            return $object_array[0]->$index;
        }

        return '';
    }
}

if ( ! function_exists('arrayfy')) 
{

    /**
     * Encode an array-object and retrieve
     * as an array
     *
     * @param mixed 
     * @return array|bool
     */
    function arrayfy($object)
    {

        if ($object) {
            $json = json_encode($object);
            return json_decode($json, true);
        }

        throw new \Exception("Parameter must be an object or supporting type", 1);

        return false;
    }
}

if ( ! function_exists('objectify')) 
{
    /**
     * Encode an array and retrieve
     * as an object
     *
     * @param array $array
     * @return object|bool
     */
    function objectify(array $array)
    {
        if (is_array($array)) {
            $array = json_encode($array, JSON_THROW_ON_ERROR);
            return json_decode($array, null, 512, JSON_THROW_ON_ERROR);
        }

        throw new \Exception("Parameter must be array", 1);
        
        return false;
    }
}

if ( ! function_exists('is_json')) 
{

    /**
     * Check if string is json
     * Mostly string should be a json string
     * 
     * 
     * @param string $string
     * @return bool
     */
    function is_json($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

if ( ! function_exists('compare_json')) 
{
    /**
     * Compare two json objects
     *
     * This is taken from
     * https://stackoverflow.com/questions/34346952/compare-two-json-in-php
     * 
     * The second answer
     * 
     * @param  string $first_object
     * @param  string $second_object
     * @return bool
     */
    function compare_json($first_object, $second_object)
    {
        $match = json_decode($first_object) == json_decode($second_object);
        return $match ? true : false;
    }
}

/* ------------------------------- Date | Time Functions ---------------------------------*/


if ( ! function_exists('timezone')) 
{
    /**
     * Timezone from TIMEZONE Constants
     * in the config/constants.php file
     * 
     * @return string 
     */
    function timezone()
    {
        return TIMEZONE;
    }
}

if ( ! function_exists('datetime')) 
{
    /**
     * Datetime from DATETIME Constants
     * in the config/constants.php file
     * 
     * @return string 
     */
    function datetime()
    {
        return DATETIME;
    }
}

if ( ! function_exists('today')) 
{
    /**
     * Today from TODAY Constants
     * in the config/constants.php file
     * 
     * @return string 
     */
    function today()
    {
        return TODAY;
    }
}

if ( ! function_exists('system_default_timezone')) 
{
    /**
     * Default Timezone from DEFAULT_TIMEZONE Constants
     * in the config/constants.php file
     * 
     * @return string 
     */
    function system_default_timezone()
    {
        return DEFAULT_TIMEZONE;
    }
}

if ( ! function_exists('arrange_date')) 
{
    /**
     * This takes out forward slashes and
     * replaces them with hyphens
     * 
     * @param string $date
     * @return string
     */
    function arrange_date($date)
    {
        if (strstr($date, '/')) {
            return $date = str_replace('/', '-', $date);
        }

        return $date;
    }

}

if ( ! function_exists('real_date')) 
{
    /**
     * Output a human readable date
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    function real_date($date, $format=null)
    {
        if ($date == "0000-00-00 00:00:00") {
            return '';
        } elseif ($date == "0000-00-00") {
            return '';
        } else {
            if(!empty($format)) {
                return date($format, strtotime($date));
            } else {
                return date('jS F, Y', strtotime($date));
            }
        }
    }
}

if ( ! function_exists('correct_date')) 
{
    /**
     * Take date and format it in Y-m-d
     * This fixes a date and can be stored
     * and used easily
     * 
     * @param string $date
     * @return void
     */
    function correct_date($date)
    {
        if ($date == "0000-00-00 00:00:00") {
            return '';
        } elseif ($date == "0000-00-00") {
            return '';
        } else {
            return date('Y-m-d', strtotime($date));
        }
    }
}

if ( ! function_exists('correct_datetime')) 
{
    /**
     * Take datetime and format it in Y-m-d H:i:a
     * This fixes a datetime and can be stored
     * and used easily
     *
     * @param string $date
     * @return string
     */
    function correct_datetime($date)
    {
        if ($date == "0000-00-00 00:00:00") {
            return '';
        } elseif ($date == "0000-00-00") {
            return '';
        } else {
            return date('Y-m-d H:i:a', strtotime($date));
        }
    }
}

if ( ! function_exists('real_time')) 
{
    /**
     * Take date and format it in H:i:a
     *
     * @param string $date
     * @return string
     */
    function real_time($date)
    {
        if ($date == "0000-00-00 00:00:00") {
            return '';
        } elseif ($date == "0000-00-00") {
            return '';
        } else {
            return date('H:i a', strtotime($date));
        }
    }
}

if ( ! function_exists('format_date')) 
{
    /**
     * Take date and set a custom date format
     *
     * @param string $format
     * @param string $date
     * @return string
     */
    function format_date($format, $date)
    {
        return date($format, strtotime($date));
    }
}

if ( ! function_exists('time_difference')) 
{
    /**
     * Calculate time difference
     *
     * @param string $start_date
     * @param string $end_date
     * @return string
     */
    function time_difference($start_datetime, $end_datetime)
    {
        $start = date_create($start_datetime);
        $end = date_create($end_datetime);

        // difference between two dates or times
        $interval = date_diff($start, $end);
        
        $minutes   = $interval->format('%i');
        $seconds   = $interval->format('%s');
        $hours     = $interval->format('%h');
        $months    = $interval->format('%m');
        $days      = $interval->format('%d');
        $years     = $interval->format('%y');

        // get time difference
        if ($interval->format('%i%h%d%m%y') == "00000") {
            return $seconds . " Seconds";
        } 
        
        if ($interval->format('%h%d%m%y') == "0000") {
            return $minutes . " Minutes";
        } 
        
        if ($interval->format('%d%m%y') == "000") {
            return $hours . " Hours";
        } 
        
        if ($interval->format('%m%y') == "00") {
            return $days . " Days";
        } 
        
        if ($interval->format('%y') == "0") {
            return $months . " Months";
        }
        
        return $years . " Years";    
    }
}

if ( ! function_exists('date_difference')) 
{
    /**
     * Calculate date difference
     * return interval as object
     * 
     * @param string $start_date
     * @param string $end_date
     * @return mixed
     */
    function date_difference($start_date, $end_date)
    {
        $start_date = date_create($start_date);
        $end_date = date_create($end_date);

        //difference between two dates
        $interval = date_diff($start_date, $end_date);

        return $interval;
    }
}

if ( ! function_exists('date_plus_day')) 
{
    /**
     * Add days to a given date
     *
     * @param string $date
     * @param int $days
     * @param string $format
     * @return string
     */
    function date_plus_day($date, $days, $format = null)
    {
        if ($format != null) {
            return date($format, strtotime($date. ' + ' . $days. 'days'));
        } else {
            return date('Y-m-d', strtotime($date. ' + ' . $days. 'days'));
        }
    }
}

if ( ! function_exists('date_minus_day')) 
{
    /**
     * Subtract days from a given date
     *
     * @param string $date
     * @param int $days
     * @param string $format
     * @return string
     */
    function date_minus_day($date, $days, $format = null)
    {
        if ($format != null) {
            return date($format, strtotime($date. ' - ' . $days. 'days'));
        } else {
            return date('Y-m-d', strtotime($date. ' - ' . $days. 'days'));
        }
    }
}

if ( ! function_exists('time_ago')) 
{
    /**
     * Time ago
     *
     * @param mixed $datetime
     * @param boolean $show_ago
     * @return string
     */
    function time_ago($datetime, $show_ago = false)
    {

        $time_difference = time() - strtotime($datetime);

        $different_times = [
                    12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        ];

        foreach( $different_times as $seconds => $period )
        {
            $derived_time = $time_difference / $seconds;

            if ( $derived_time >= 1 ) {
                $time = round( $derived_time );
                return ($show_ago)
                        ? $time . ' ' . $period . ($time > 1 ? 's' : '') . ' ago'
                        // 'about ' . $time . ' ' . $period . ( $time > 1 ? 's' : '' ) . ' ago';
                        : $time . ' ' . $period . ($time > 1 ? 's' : '');
            }
        }

        return;
    }
}

if ( ! function_exists('travel')) 
{
    /**
     * Travel through time
     *
     * @return mixed
     */
    function travel()
    {
        return (new \Base\Helpers\TimeTravel);
    }
}

/* ------------------------------- Security Functions ---------------------------------*/

if ( ! function_exists('hash_algo')) 
{
    /**
     * A wrapper for php hash function
     *
     * @param string $algorithm
     * @param string $string
     * @return string
     */
    function hash_algo($algorithm, $string)
    {
        return hash($algorithm, $string);
    }
}

if ( ! function_exists('escape'))
{

    /**
     * Escape HTML entities in a string
     *
     * @param string $value
     * @return string
     */
    function escape($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }
}

if ( ! function_exists('csrf')) 
{
    /**
     * Creates a CSRF hidden form input
     *
     * @return void
     */
    function csrf()
    {
        echo '<input type="hidden" name="' . ci()->security->get_csrf_token_name() . '" value="' . ci()->security->get_csrf_hash() . '">';
    }
}

if ( ! function_exists('csrf_token')) 
{
    /**
     * Grab CSRF token name
     *
     * @return string
     */
    function csrf_token()
    {
        return ci()->security->get_csrf_token_name();
    }
}

if ( ! function_exists('csrf_hash')) 
{
    /**
     * Grab CSRF hash
     *
     * @return string
     */
    function csrf_hash()
    {
        return ci()->security->get_csrf_hash();
    }
}

if ( ! function_exists('honeypot')) 
{
    /**
     * Generate a honeypot field
     *
     * @return string
     */
    function honeypot($name = '', $template = '', $container = '')
    {
        $data = [
            'hidden' => env('honeypot.hidden', 'text'),
            'name' => env('honeypot.name', $name),
            'template' => env('honeypot.template', $template),
            'container' => env('honeypot.container', $container),
            'honeyfield' => env('honeypot.timefield')
        ];

        if ($data['hidden']) {
            $data['hidden'] = 'hidden';
        } else {
            $data['hidden'] = 'text';
        }

        if (!empty($data['honeyfield'])) {

            $data['honeytime'] = base64_encode(time());
            session('honeytime', $data['honeytime']);
            $data['timename'] = env('honeypot.timename');
            $data['honeyfield'] =str_replace('{hidden}', $data['hidden'], $data['honeyfield']);
            $data['honeyfield'] = str_replace('{timename}', $data['timename'], $data['honeyfield']);
            $data['honeyfield'] = str_replace('{honeytime}', $data['honeytime'], $data['honeyfield']);
        }

        if (!empty($data['container'])) {

            $output = str_replace('{name}', $data['name'], $data['template']);
            $output = str_replace('{hidden}', $data['hidden'], $output);
            $output = str_replace('{template}', $output, $output);
            $output = str_replace(['{template}','{honeyfield}'], [$output, $data['honeyfield']], $data['container']);
            return $output;
        }

        $output = str_replace('{name}', $data['name'], $data['template']);
        $output = str_replace('{hidden}', $data['hidden'], $output);
        $output = str_replace('{template}', $data['template'], $output);
        return $output;

    }
}

if ( ! function_exists('honey_check')) 
{
    /**
     * Checks if the honeypot field 
     * is not filled
     *
     * @param string $honeypot
     * @return bool
     */
    function honey_check($honeypot = '')
    {
        if (trim($honeypot) != '') {
            return false;
        }

        return true;
    }
}

if ( ! function_exists('honey_time')) 
{
    /**
     * Checks the time it takes a 
     * form to be submitted
     *
     * @param integer $time
     * @return bool
     */
    function honey_time($field = '', $time = 10)
    {
        $honeytime = base64_decode(session('honeytime'));
        $field = $field;
        $seconds = time() - $honeytime;

        if (empty($time)) {
            $time = env('honeypot.time', $time);
        }

        if ($seconds < $time) {
            return false;
        } else {
            return true;
        }
    }
}

if ( ! function_exists('clean')) 
{
    /**
     *  Clean string from XSS
     *
     *  @param     string    $str
     *  @param     string    $is_image
     *  @return    string|array
     */
    function clean($str, $is_image = false)
    {
        ci()->load->helper('security');
        return xss_clean($str, $is_image);
    }
}

if ( ! function_exists('cleanxss')) 
{
    /**
     * Prevents XXS Attacks
     *
     * @param string $input
     * @return string
     */
    function cleanxss($input)
    {
        $search = [
            '@&lt;script[^&gt;]*?&gt;.*?&lt;/script&gt;@si', // Strip out javascript
            '@&lt;[\/\!]*?[^&lt;&gt;]*?&gt;@si', // Strip out HTML tags
            '@&lt;style[^&gt;]*?&gt;.*?&lt;/style&gt;@siU', // Strip style tags properly
            '@&lt;![\s\S]*?--[ \t\n\r]*&gt;@', // Strip multi-line comments
        ];

        $inputx = preg_replace($search, '', $input);
        $inputx = trim($inputx);
        $inputx = stripslashes($inputx);
        $inputx = stripslashes($inputx);
        
        return clean($inputx);
    }
}

if ( ! function_exists('ping_url')) 
{
    /**
     * Ping url to check
     * if it is online or exists
     *
     *  @param     string  $url
     *  @return    bool
     */
    function ping_url(string $url): bool
    {
        $url = parse_url($url);

		if (!isset($url["host"])) { 
            return false;
        }

		return !(gethostbyname($url["host"]) == $url["host"]);
    }
}

if ( ! function_exists('filter_url')) 
{
    /**
     *  filter url
     *
     *  @param     string    $url
     *  @return    string
     */
    function filter_url($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }
}

if ( ! function_exists('is_url')) 
{

     /**
      * check if string is url
      *
      * @param string $url
      * @param bool $is_live
      * @param bool $return
      * @return bool|string
      */
    function is_url($url, $is_live = false, $return = false)
    {
        $url = filter_url($url);

        $url = filter_var($url, FILTER_VALIDATE_URL);

        if ($return && $is_live) {
            $live = ping_url($url);
            return $live ? $url : $live;
        }

        if ($return && $url) {
            return $url;
        }

        if ($is_live) {
            return ping_url($url);
        }

        if ($url) {
            return true;
        }

        return false;
    }
}

if ( ! function_exists('is_email')) 
{
    /**
     * Check if email is valid
     *
     * @param string $email
     * @return boolean
     */
    function is_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists('is_domain')) 
{
    /**
     * Checks if an email is from 
     * a given domain e.g. @webby
     *
     * @param string $email
     * @param string $domain
     * @return boolean
     */
    function is_domain($email, $domain)
    {
        if (preg_match("/$domain/", $email)) {
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists('is_email_injected')) 
{
    /**
     * validate against any email injection attempts
     *
     * @param string $email
     * @return boolean
     */
    function is_email_injected($email)
    {
        $injections = [
            '(\n+)',
            '(\r+)',
            '(\t+)',
            '(%0A+)',
            '(%0D+)',
            '(%08+)',
            '(%09+)',
        ];

        $inject = join('|', $injections);
        $inject = "/$inject/i";
        if (preg_match($inject, $email)) {
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists('is_email_valid')) 
{   
    /**
     * checks whether the email address is valid
     *
     * @param string $email
     * @return boolean
     */
    function is_email_valid($email)
    {
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
        
        if (preg_match($pattern, $email)) {
            return true;
        } else {
            return false;
        }
    }
}
