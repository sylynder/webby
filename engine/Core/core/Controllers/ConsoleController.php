<?php

namespace Base\Controllers;

use Base\Console\ConsoleColor;

class ConsoleController extends Controller
{
    
    private $env = 'development';

    public function __construct()
    {
        parent::__construct();

        if (!is_cli()) {show_404();}
    }

    /**
     * Set to allow for only
     * development environment
     *
     * @return void
     */
    protected function onlydev()
    {
        if (ENVIRONMENT !== $this->env) {
            exit;
        }
    }

    protected function success($text, $times = 1, $nextline = true)
    {
        if ($nextline) {
            return ConsoleColor::green($text) . $this->nextline($times);
        }

        return ConsoleColor::green($text);
    }

    protected function info($text, $times = 1, $nextline = true)
    {
        if ($nextline) {
            return ConsoleColor::cyan($text) . $this->nextline($times);
        }

        return ConsoleColor::cyan($text);
    }

    protected function warning($text, $times = 1, $nextline = true)
    {
        if ($nextline) {
            return ConsoleColor::yellow($text) . $this->nextline($times);
        }

        return ConsoleColor::yellow($text);
    }

    protected function error($text, $times = 1, $nextline = true)
    {
        if ($nextline) {
            return ConsoleColor::red($text) . $this->nextline($times);
        }

        return ConsoleColor::red($text);
    }

    protected function nextline($times = 1)
    {
        $line = " \n";

        if ($times > 1) {
            return str_repeat($line, $times);
        }

        return $line;
    }

}
