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
    $output .=  Console::cyan("    command [options] [arguments] ") . "\n";
    $output .=  " \n";
    $output .=  " \n";
    $output .=  Console::yellow(" Options:") . " \n";
    $output .=  Console::green("     --help") .  Console::cyan("     Help list for available commands if not specified will show by default")  . " \n";
    $output .=  Console::green("     --port") .  Console::cyan("     Specify port number to be used to serve application")  . " \n";

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
    $output .=  Console::cyan(" Welcome to Webby CLI " . WEBBY_VERSION . ":") . "\n\n";
    $output .=  Console::white(" Sorry the command is not known", 'light', 'red') . " \n";

    echo $output . "\n";
}

function execute_command($command)
{
    if ($command[1] === 'migrate') {
        system('php public/index.php ' . $command[1]);
    } else {
        no_command();
    }
    
}

function setenv()
{
    $env_example_file = __DIR__ . '/../.env.example';
    $env_file = __DIR__ . '/../.env';

    if (file_exists($env_file)) {
        echo Console::red("Environment file exists already!") . "\n";
        exit();
    }

    // Copy content from env_example_file
    // to env_file
    if (!copy($env_example_file, $env_file)) {
        echo Console::red("Environment was not able to be set!") . "\n";
    } else {
        echo Console::green("Environment has been set successfully!") . "\n";  
    }
}
