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