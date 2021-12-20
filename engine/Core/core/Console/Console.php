<?php

namespace Base\Console;

class Console 
{

    private static $phpCommand = 'php public/index.php ';

    private static $rootpath;

    private static $cliversion;

    private static $env;

    private static $removeComposerDev = 'composer --no-dev update';

    private static $composerCommand = 'composer ';

    /**
     * Display console help
     *
     * @param array $args
     * @return void
     */
    public static function showHelp($args = []): void
    {
        static::$cliversion = static::userConstants()->WEBBY_CLI_VERSION;

        $output =   " \n";
        $output .=  ConsoleColor::cyan(" Welcome to Webby CLI") . " " . ConsoleColor::green(static::$cliversion) . "\n";
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
     * Grab available defined user constants
    */
    private static function userConstants()
    {
        return (object) get_defined_constants(true)['user'];
    }

    /**
     * Display when command
     * not found
     *
     * @return void
     */
    public static function noCommand(): void
    {
        static::$cliversion = static::userConstants()->WEBBY_CLI_VERSION;
        $output =   " \n";
        $output .=  ConsoleColor::cyan(" Welcome to Webby CLI " . static::$cliversion . ":") . "\n\n";
        $output .=  ConsoleColor::white(" Sorry the command is not known", 'light', 'red') . " \n";

        echo $output . "\n";
    }

    public static function executeCommand()
    {
        $arguments = func_get_args();

        [$listArguments] = $arguments;

        // $count = is_countable($listArguments) ? count($listArguments) : 0;
        $count = $_SERVER['argc'];

        if ($count === 0) {
            static::noCommand();
            exit;
        }

        // Declare empty argX variables
        $arg2 = '';
        $arg3 = '';
        $arg4 = '';
        $arg5 = '';
        $arg6 = '';

        list($webby, $arg1) = $listArguments;

        if ($count === 3) {
            list($webby, $arg1, $arg2) = $listArguments;
        }

        if ($count === 4) {
            list($webby, $arg1, $arg2, $arg3) = $listArguments;
        }

        if ($count === 5) {
            list($webby, $arg1, $arg2, $arg3, $arg4) = $listArguments;
        }

        if ($count === 6) {
            list($webby, $arg1, $arg2, $arg3, $arg4, $arg5) = $listArguments;
        }

        switch($arg1)
        {
            case 'key:generate':
                static::consoleEnv();
                static::runSystemCommand(static::$phpCommand . 'key/prepare');

                if ($arg2 == "--regenerate") {
                    static::runSystemCommand(static::$phpCommand . 'key/regenerate');
                    exit();
                }

                static::runSystemCommand(static::$phpCommand . 'key');
            break;
            case 'migrate':
                static::runSystemCommand(static::$phpCommand . 'migrate');
            break;
            case 'list:routes':
                static::runSystemCommand(static::$phpCommand . 'routes');
            break;
            case 'app:on':
                static::runSystemCommand(static::$phpCommand . 'maintenance/on');
            break;
            case 'app:off':
                static::runSystemCommand(static::$phpCommand . 'maintenance/off');
            break;
            case 'resource:link':
                static::runSystemCommand(static::$phpCommand . 'create/resourcelink');
            break;
            case 'use:command':
                static::runSystemCommand(static::$phpCommand . $arg2);
            break;
            case 'git:init':
                static::consoleEnv();
                static::runSystemCommand('git init');
            break;
            // case 'create:web':
            //     static::createCommand();
            // break;
            // case 'deploy:ready':
            //     static::runSystemCommand(static::$phpCommand . 'routes');
            // break;
            // case 'deploy:check':
            //     static::runSystemCommand(static::$phpCommand . 'routes');
            // break;
            // case 'install:package':
            //     static::consoleEnv();
            //     // $installOption = 'require ';
            //     // static::runSystemCommand(static::$composerCommand . $installOption. $arg2 . ' ' . $arg3);
            // break;
            // case 'publish:package':
            //     static::consoleEnv();
            // break;
            // case 'composer':
            //     static::consoleEnv();
            //     static::runSystemCommand(static::$composerCommand . $arg2 .' '. $arg3);
            // break;
            default:
                static::noCommand();
            break;
        }
    }

    // public static function createCommand(){}

    /**
     * Check Console Environment
     *
     * @return void
     */
    private static function consoleEnv(): void
    {
        static::$env = static::userConstants()->ENVIRONMENT;

        if (static::$env !== 'development') {
            exit();
        }
    }

    /**
     * Run system command
     *
     * @param string $command
     * @return void
     */
    public static function runSystemCommand($command = ''): void
    {
        system($command);
    }

    /**
     * Set environment function
     *
     * @return void
     */
    public static function setenv(): void
    {
        static::$rootpath = static::userConstants()->WEBBY_ROOTPATH;
        
        $envExampleFile =  static::$rootpath . '/.env.example';
        $envFile = static::$rootpath . '/.env';

        if (file_exists($envFile)) {
            echo ConsoleColor::red("Environment file exists already!") . "\n";
            exit();
        }

        // Copy content from .env.example file
        // to .env file
        if (!copy($envExampleFile, $envFile)) {
            echo ConsoleColor::red("Environment was not able to be set!") . "\n";
        } else {
            echo ConsoleColor::green("Environment has been set successfully!") . "\n";
        }
    }

    /**
     * Serve Webby application
     *
     * @param array $args
     * @return void
     */
    public static function serve($args = []): void
    {
        static::$rootpath = static::userConstants()->WEBBY_ROOTPATH;
        
        $number = isset($args[3]) ? (int)$args[3] : "";
        $project_dir = static::$rootpath; //__DIR__;
        $dir = realpath($project_dir . '/public/');
        $port = (isset($number) && is_int($number)) ? $number : 8085;
        $port = intval($port);

        if ($port === 0) {
            echo ConsoleColor::red("Please choose a valid port!") . "\n";
            exit();
        }

        $output =  "PHP Webserver Started for Webby \n";
        $output .= "Navigate to http://localhost:{$port} ";
        $output .= "to view your project.\nPress Ctrl+C to stop it!";
        " \n";

        echo $output . "\n";
        system('php -S localhost:' . $port . ' -t ' . $dir);
    }

    /**
     * Run Webby Console
     *
     * @param array $args
     * @return void
     */
    public static function run($args): void
    {

        if (isset($args[2]) && $args[2] === '--port') {
            Console::serve($args);
        } else if (isset($args[1]) && $args[1] === 'serve') {
            Console::serve();
        } else if (isset($args[1]) && $args[1] === 'set' && @$args[2] === '--env') {
            Console::setenv();
        } else if (isset($args[1]) && $args[1] === '--help') {
            Console::showHelp();
        } else if (!empty($args[1])) {
            Console::executeCommand($args);
        } else if (!isset($args[1])) {
            Console::showHelp();
        } else {
            Console::noCommand();
        }
    }

}
