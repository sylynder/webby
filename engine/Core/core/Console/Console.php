<?php

namespace Base\Console;

class Console {

    private static $phpCommand = 'php public/index.php ';
    /**
     * Function to display console help
     *
     * @param array $args
     * @return void
     */
    public static function showHelp($args = [])
    {
        $output =   " \n";
        $output .=  ConsoleColor::cyan(" Welcome to Webby CLI") . " " . ConsoleColor::green(WEBBY_CLI_VERSION) . "\n";
        $output .=  " \n";
        $output .=  ConsoleColor::yellow(" Usage:") . " \n";
        $output .=  ConsoleColor::cyan("    webby [options] [arguments] ") . "\n";
        $output .=  " \n";
        $output .=  " \n";
        $output .=  ConsoleColor::yellow(" Options:") . " \n";
        $output .=  ConsoleColor::green("     --help") .  ConsoleColor::cyan("     Help list for available commands if not specified will show by default")  . " \n";
        $output .=  ConsoleColor::green("     --port") .  ConsoleColor::cyan("     Specify port number to be used to serve application")  . " \n";

        echo $output . "\n";
    }

    /**
     * Function to display when command
     * not found
     *
     * @return void
     */
    public static function noCommand()
    {
        $output =   " \n";
        $output .=  ConsoleColor::cyan(" Welcome to Webby CLI " . WEBBY_CLI_VERSION . ":") . "\n\n";
        $output .=  ConsoleColor::white(" Sorry the command is not known", 'light', 'red') . " \n";

        echo $output . "\n";
    }

    public static function executeCommand()
    {
        $arguments = func_get_args();

        $phpCommand = 'php public/index.php ';

        [$listArguments] = $arguments;

        $count = is_countable($listArguments) ? count($listArguments) : 0;

        if ($count === 0) {
            static::noCommand();
            exit;
        }

        list($webby, $argumentOne) = $listArguments;

        // if ($argumentOne === 'migrate') {
        //     static::runSystemCommand(static::$phpCommand . $argumentOne);
        // } else if ($argumentOne === 'list:routes') {
        //     static::runSystemCommand(static::$phpCommand. 'command/routes');
        // } else {
        //     static::noCommand();
        // }

        switch($argumentOne) 
        {
            case 'migrate' :
                static::runSystemCommand(static::$phpCommand . $argumentOne);
            break;
            case 'list:routes':
                static::runSystemCommand(static::$phpCommand . 'command/routes');
            break;
            default:
                static::noCommand();
            break;
        }
    }

    public static function runSystemCommand($command = '')
    {
        system($command);
    }

}
