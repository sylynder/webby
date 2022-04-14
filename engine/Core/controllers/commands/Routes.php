<?php

/**
 * Routes Command Controller
 */

use Base\Console\ConsoleColor;
use Base\Controllers\ConsoleController;

class Routes extends ConsoleController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->onlydev();
    }

    /**
     * Grab a list of available routes
     * and display it to developer
     * 
     * Note: http based routes may not be included
     * if you enable Route::$trueHttp = true
     * 
     * @Todo make http based routes available in
     * route lists
     *
     * @return void
     */
    public function index()
    {
        $output =   "\n";
        $output .=  ConsoleColor::cyan(" Available Routes \n\n");

        $routes = $this->router->routes;

        $output .= ConsoleColor::green("| No.|  Route Name   |  Route Path    \n") ;

        $output .= "\n";

        $count = 0;
        foreach ($routes as $route => $value) {
            $count++;
            $output .= ConsoleColor::green("$count:") ." ". ConsoleColor::cyan($route) . " : " . ConsoleColor::yellow($value) ."\n\n";
        }

        echo $output . "\n";
    }
}
