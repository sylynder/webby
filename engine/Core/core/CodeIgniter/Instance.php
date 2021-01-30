<?php

namespace Base\CodeIgniter;

/**
 * CodeIgniter Instance
 *
 * A static helper for the CodeIgniter::instance method.
 * 
 * Had to expand on it due to Webby's work around
 *
 * @package Webby
 * @author  Rougin Gutib <rougingutib@gmail.com>
 * @author  Oteng Kwame Appiah-Nti <developerkwame@gmail.com>
 */
class Instance
{
    /**
     * Creates an instance of CodeIgniter 
     *
     * @param  string $path
     * @param  array  $server
     * @param  array  $globals
     * @return \CI_Controller
     */
    public static function create(array $server = array(), array $globals = array())
    {
        $globals = empty($globals) ? $GLOBALS : $globals;

        $server = empty($server) ? $_SERVER : $server;

        // $ci is CodeIgniter for short
        $ci = new CodeIgniter($globals, $server);

        return $ci->instance();
    }
}
