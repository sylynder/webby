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

if ( ! function_exists('dot_to_slash')) 
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

if ( ! function_exists('has_dot')) 
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
    function has_dot($string)
    {
        $output = [];

        if (is_array($string)) {

            foreach ($string as $key => $value)
            {
                
                if (is_int($key))
                {
                    $output[] = dot_to_slash($value);
                }
                else
                {
                    $output[] = dot_to_slash($value);
                }
            }
        }

        if (!is_array($string)) {
            $output = dot_to_slash($string);
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
     */
    function str_right_zeros($value, $length)
    {
        return pad_right('0', $value, $length);
    }
}

if ( ! function_exists('str_to_hex')) 
{
    /**
     * convert string to hexadecimal
     *
     * @param string $str
     * @return string
     */
    function str_to_hex(string $str)
    {
        $hex_string = unpack('H*', $string);
        return array_shift($hex_string);
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

if ( ! function_exists('str_censor')) 
{ 
    /**
     * Censor bad words from string
     *
     * @param string $text
     * @param array $words_to_censor
     * @param boolean $replacement
     * @return void
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
     * @return void
     */
    function find_word($string, $word)
    {
        if (is_array($string)) {
            $string = array_to_string(',', $string);
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

if ( ! function_exists('string_to_array')) 
{
    /**
     * Converts a string to an array
     *
     * @param string $symbol
     * @param string $string
     * @return void
     */
    function string_to_array($symbol, $string)
    {
        return explode($symbol, $string);
    }
}

if ( ! function_exists('array_to_string')) 
{
    /**
     * Converts an array to a string
     * using a given symbol e.g. ',' or ':'
     * 
     * @param string $symbol
     * @param array $array
     * @return string
     */
    function array_to_string($symbol, $array)
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
     * @return void
     */
    function add_array($array, $element, $symbol = null, $return_string = false)
    {
        if (!is_array($array) && $symbol != null) {
            $array = string_to_array($symbol, $array);
        }

        if (is_array($array)) {
            array_push($array, $element);
        }

        if ($return_string == true) {
            return $array = array_to_string($symbol, $array);
        }

        return $array;
    }
}

if ( ! function_exists('add_associative_array')) 
{
    /**
     * This is a function that helps to 
     * add associative key => value
     * To an associative array
     *
     * @param array $array
     * @param string $key
     * @param string $value
     * @return void
     */
    function add_associative_array($array, $key, $value)
    {
        $array[$key] = $value;

        return $array;
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
     * @return void
     */
    function remove_from_array(
        $array, 
        $element, 
        $symbol = null, 
        $return_string = false
    ) :array {
        if (!is_array($array) && $symbol != null) {
            $array = string_to_array($symbol, $array);
        }

        if (is_array($array) && ($key = array_search($element, $array)) !== false) {
            unset($array[$key]);
        }

        if ($return_string == true) {
            return $array = array_to_string($symbol, $array);
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

if ( ! function_exists('objectify')) 
{
    /**
     * Encode an array and retrieve
     * as an object
     *
     * @param array $array
     * @return object
     */
    function objectify(array $array)
    {
        if (is_array($array)) {
            $array = json_encode($array, JSON_THROW_ON_ERROR);
            return json_decode($array, null, 512, JSON_THROW_ON_ERROR);
        }

        throw new Exception("Parameter must be array", 1);
        
        return false;
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
     * @param  object $first_object
     * @param object $second_object
     * @return void
     */
    function compare_json($first_object, $second_object)
    {
        $match = json_decode($first_object) == json_decode($second_object);
        return $match ? true : false;
    }
}

/* ------------------------------- Date | Time Functions ---------------------------------*/

if ( ! function_exists('arrange_date')) 
{
    /**
     * This takes out forward slashes and
     * replaces them with hyphens
     * 
     * @param string $date
     * @return void
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
     * @return void
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
    //return date_format(date_create($this->data['details']['date_made']), 'Y-m-d');
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
     */
    function time_difference($start_date, $end_date)
    {
        $start_date = date_create($start_date);
        $end_date = date_create($end_date);

        //difference between two dates
        $diff = date_diff($start_date, $end_date);

        //get time difference
        return $diff->format("%a");
    }
}

if ( ! function_exists('date_difference')) 
{
    /**
     * Calculate date difference
     *
     * @param string $start_date
     * @param string $end_date
     * @return void
     */
    function date_difference($start_date, $end_date)
    {
        $start_date = date_create($start_date);
        $end_date = date_create($end_date);

        //difference between two dates
        $diff = date_diff($start_date, $end_date);

        return $diff->format("%a");
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
     * @return void
     */
    function date_plus_day($date, $days, $format = null)
    {
        if ($format != null) {
            return date('M d, Y', strtotime($date. ' + ' . $days. 'days'));
        } else {
            return date('Y-m-d', strtotime($date. ' + ' . $days. 'days'));
        }
    }
}

if ( ! function_exists('date_minus_day')) 
{
    /**
     * Subtract days from a give date
     *
     * @param string $date
     * @param int $days
     * @param string $format
     * @return void
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
    function time_ago($datetime)
    {

        $time_difference = time() - strtotime($datetime);

        $different_times = array(
                    12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );

        foreach( $different_times as $seconds => $period )
        {
            $derived_time = $time_difference / $seconds;

            if( $derived_time >= 1 )
            {
                $time = round( $derived_time );
                return 'about ' . $time . ' ' . $period . ( $time > 1 ? 's' : '' ) . ' ago';
            }
        }

        return;
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
        return htmlentities($value, ENT_QUOTES, 'UTF-8', FALSE);
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

if ( ! function_exists('clean')) 
{
    /**
     *  Clean string from XSS
     *
     *  @param     string    $str
     *  @param     string    $is_image
     *  @return    string
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
        $search = array(
            '@&lt;script[^&gt;]*?&gt;.*?&lt;/script&gt;@si', // Strip out javascript
            '@&lt;[\/\!]*?[^&lt;&gt;]*?&gt;@si', // Strip out HTML tags
            '@&lt;style[^&gt;]*?&gt;.*?&lt;/style&gt;@siU', // Strip style tags properly
            '@&lt;![\s\S]*?--[ \t\n\r]*&gt;@', // Strip multi-line comments
        );

        $inputx = preg_replace($search, '', $input);
        $inputx = trim($inputx);
        $inputx = stripslashes($inputx);
        $inputx = stripslashes($inputx);
        
        return clean($inputx);
    }
}

if ( ! function_exists('is_url')) 
{
    /**
     *  filter url
     *
     *  @param     string    $url
     *  @return    string
     */
    function is_url($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
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
        $injections = array('(\n+)',
            '(\r+)',
            '(\t+)',
            '(%0A+)',
            '(%0D+)',
            '(%08+)',
            '(%09+)',
        );
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
