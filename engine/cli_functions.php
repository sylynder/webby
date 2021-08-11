<?php

require_once __DIR__ . '/console_color.php';

/**
 * This file contains the basic functionalities
 * for the webby cli file
 */

define('WEBBY_VERSION', 'v0.5.1');

/**
 * Function to display console help
 *
 * @param array $args
 * @return void
 */
function show_help($args = [])
{
	$output =   " \n";
	$output .=  Console::cyan(" Welcome to Webby CLI") . " " . Console::green(WEBBY_VERSION) . "\n";
	$output .=  " \n";
	$output .=  Console::yellow(" Usage:") . " \n";
	$output .=  Console::cyan("    command [options] [arguments] "). "\n";
	$output .=  " \n";
	$output .=  " \n";
	$output .=  Console::yellow(" Options:") . " \n";
	$output .=  Console::green("     --help").  Console::cyan("     Help list for available commands if not specified will show by default")  ." \n";
	$output .=  Console::green("     --port").  Console::cyan("     Specify port number to be used to serve application")  ." \n";
	
	echo $output . "\n";
}

/**
 * Function to display when command
 * not found
 *
 * @return void
 */
function no_command()
{
	$output =   " \n";
	$output .=  Console::cyan(" Welcome to Webby CLI ". WEBBY_VERSION.":") ."\n\n";
	$output .=  Console::white(" Sorry the command is not known", 'light', 'red') ." \n";

	echo $output . "\n";
}

function execute() {
	system('php public/index.php migrate');
}

/**
 * Colorize function
 *
 * @param [type] $string
 * @param string $type
 * @return void
 */
function colorize($string, $type = 'i'){
    switch ($type) {
        case 'e': //error
            echo "e\033[31m$string \033[0m\n";
        break;
        case 's': //success
            echo "\033[32m$string \033[0m\n";
        break;
        case 'w': //warning
            echo "\033[33m$string \033[0m\n";
        break;  
        case 'i': //info
            echo "\033[33m$string \033[0m\n";
        break;      
        default:
        # code...
        break;
    }
}
