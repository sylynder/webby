<?php

/**
 * Originally Created By Jesse Donat
 * 
 * Console Color
 * Used to log strings with custom colors to console using php
 * Modified to work with Webby
 * 
 * @author  Kwame Oteng Appiah-Nti <developerkwame@gmail.com> (Developer Kwame)
 * 
 * Colored CLI Output is created by: (C) Jesse Donat
 * https://gist.github.com/donatj/1315354
 * 
 */

namespace Base\Console;

class ConsoleColor
{

    static $foregroundColors = [
        'bold'         => '1',    'dim'          => '2',
        'black'        => '1;30', 'dark_gray'    => '1;30',
        'blue'         => '1;34', 'light_blue'   => '1;34',
        'green'        => '1;32', 'light_green'  => '1;32',
        'cyan'         => '1;36', 'light_cyan'   => '1;36',
        'red'          => '1;31', 'light_red'    => '1;31',
        'purple'       => '1;35', 'light_purple' => '1;35',
        'brown'        => '1;33', 'yellow'       => '1;33',
        'light_gray'   => '1;37', 'white'        => '1;37',
        'normal'       => '1;39',
    ];

    static $backgroundColors = [
        'black'        => '40',   'red'          => '41',
        'green'        => '42',   'yellow'       => '43',
        'blue'         => '44',   'magenta'      => '45',
        'cyan'         => '46',   'light_gray'   => '47',
    ];

    static $options = [
        'underline'    => '4',    'blink'         => '5',
        'reverse'      => '7',    'hidden'        => '8',
    ];

    static $EOF = "\n";

    /**
     * Logs a string to console.
     * @param  string  $str        Input String
     * @param  string  $color      Text Color
     * @param  boolean $newline    Append EOF?
     * @param  string  $background Background Color
     * @return string              Formatted output
     */
    public static function log($str = '', $color = 'normal', $newline = true, $backgroundColor = null)
    {
        if (is_bool($color)) {
            $newline = $color;
            $color   = 'normal';
        } elseif (is_string($color) && is_string($newline)) {
            $backgroundColor = $newline;
            $newline          = true;
        }

        $str = $newline ? $str . self::$EOF : $str;

        echo self::$color($str, $backgroundColor);
    }

    /**
     * Anything below this point (and its related variables):
     * Colored CLI Output is: (C) Jesse Donat
     * https://gist.github.com/donatj/1315354
     * 
     */
    
    // ---------------------------------------------------------

    /**
     * Catches static calls (Wildcard)
     * @param  string $foregroundColor Text Color
     * @param  array  $args             Options
     * @return string                   Colored string
     */
    public static function __callStatic($foregroundColor, $args)
    {
        $string         = $args[0];
        $coloredString = "";

        // Check if given foreground color found
        if (isset(self::$foregroundColors[$foregroundColor])) {
            $coloredString .= "\033[" . self::$foregroundColors[$foregroundColor] . "m";
        } else {
            die($foregroundColor . ' not a valid color');
        }

        array_shift($args);

        foreach ($args as $option) {
            // Check if given background color found
            if (isset(self::$backgroundColors[$option])) {
                $coloredString .= "\033[" . self::$backgroundColors[$option] . "m";
            } elseif (isset(self::$options[$option])) {
                $coloredString .= "\033[" . self::$options[$option] . "m";
            }
        }

        // Add string and end coloring
        $coloredString .= $string . "\033[0m";

        return $coloredString;
    }

    /**
     * Plays a bell sound in console (if available)
     * @param  integer $count Bell play count
     * @return string         Bell play string
     */
    public static function bell($count = 1)
    {
        echo str_repeat("\007", $count);
    }
}
