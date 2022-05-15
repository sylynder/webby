<?php

/**
 * Webby Console 
 */

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

        $output .=  ConsoleColor::green(" All commands start with 'php webby'") . " \n";
        $output .=  ConsoleColor::green("     --help") .  ConsoleColor::cyan("     Help list for available commands if not specified will show by default")  . " \n";
        $output .=  ConsoleColor::green("     serve --port") .  ConsoleColor::cyan("     Specify port number to be used to serve application, e.g --port 8080")  . " \n";

        $output .=  " \n";
        $output .=  ConsoleColor::yellow(" Available Commands:") . " \n";
        $output .=  ConsoleColor::light_purple("    serve") .  ConsoleColor::cyan("            Serve your application with Webby Server")  . " \n";
        $output .=  ConsoleColor::light_purple("    migrate") .  ConsoleColor::cyan("          Run all available migration files")  . " \n";
        $output .=  ConsoleColor::light_purple("    list:routes") .  ConsoleColor::cyan("      List all available routes")  . " \n";
        $output .=  ConsoleColor::light_purple("    app:off") .  ConsoleColor::cyan("          Turn maintenance mode on")  . " \n";
        $output .=  ConsoleColor::light_purple("    app:on") .  ConsoleColor::cyan("           Turn maintenance mode off")  . " \n";
        $output .=  ConsoleColor::light_purple("    resource:link") .  ConsoleColor::cyan("    Create a symlink for the resources folder in public")  . " \n";
        $output .=  ConsoleColor::light_purple("    use:command") .  ConsoleColor::cyan("      Access console Controllers through cli to perform a cli task")  . " \n";
        $output .=  ConsoleColor::light_purple("    git:init") .  ConsoleColor::cyan("         Enable your project with git")  . " \n";

        $output .=  " \n";
        $output .=  ConsoleColor::yellow(" Generator Commands:") . " \n";
        $output .=  ConsoleColor::light_purple("    key:generate") .  ConsoleColor::cyan("        Generates an encryption key in the .env file")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:module") .  ConsoleColor::cyan("       Create a module by specifying which sub-directories to use e.g --mvc, --c, --m")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:package") .  ConsoleColor::cyan("      Create a package by specifying which sub-directories to use e.g --mvc, --c, --m, --s")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:controller") .  ConsoleColor::cyan("   Create a controller by specifying which module it belongs with")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:model") .  ConsoleColor::cyan("        Create a model by specifying which module it belongs with")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:service") .  ConsoleColor::cyan("      Create a service by specifying which module it belongs with")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:action") .  ConsoleColor::cyan("       Create an action by specifying which module it belongs with")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:library") .  ConsoleColor::cyan("      Create a library by specifying which module it belongs with")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:helper") .  ConsoleColor::cyan("       Create a helper by specifying which module it belongs with")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:form") .  ConsoleColor::cyan("         Create a form by specifying which module it belongs with")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:rule") .  ConsoleColor::cyan("         Create a rule by specifying which module it belongs with")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:middleware") .  ConsoleColor::cyan("   Create a middleware by specifying the name")  . " \n";
        $output .=  ConsoleColor::light_purple("    create:enum") .  ConsoleColor::cyan("         Create an enum by specifying the name and the type e.g. --real, --fake")  . " \n";
        
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

        if (!isset($webby)) 
        {
            static::noCommand();
            exit;
        }

        switch($arg1)
        {
            case 'key:generate':
                static::consoleEnv();
                static::runSystemCommand(static::$phpCommand . 'key/prepare');

                if ($arg2 == "--regenerate") {
                    static::runSystemCommand(static::$phpCommand . 'key/regenerate');
                    exit;
                }

                static::runSystemCommand(static::$phpCommand . 'key');
            break;
            case 'migrate':
                static::consoleEnv();
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
            case 'app:to-production':
                static::runSystemCommand(static::$phpCommand . 'environment/production');
            break;
            case 'app:to-testing':
                static::runSystemCommand(static::$phpCommand . 'environment/testing');
            break;
            case 'app:to-development':
                static::runSystemCommand(static::$phpCommand . 'environment/development');
            break;
            case 'resource:link':
                static::consoleEnv();
                static::runSystemCommand(static::$phpCommand . 'create/resourcelink');
            break;
            case 'use:command':
                if (empty($arg2)) {
                    echo ConsoleColor::red("No arguments provided!") . "\n";
                    exit;
                }
                static::runSystemCommand(static::$phpCommand . $arg2);
            break;
            case 'git:init':
                static::consoleEnv();
                static::runSystemCommand('git init');
            break;
            case 'create:package':
                static::consoleEnv();
                static::createPackage($arg2, $arg3, $arg4);
            break;
            case 'create:module':
                static::consoleEnv();
                static::createModule($arg2, $arg3, $arg4);
            break;
            case 'create:controller':
                static::consoleEnv();
                static::createController($arg2, $arg3, $arg4);
            break;
            case 'create:model':
                static::consoleEnv();
                static::createModel($arg2, $arg3, $arg4, $arg5);
            break;
            case 'create:view':
                static::consoleEnv();
                // static::createView(...$arg);
            break;
            case 'create:service':
                static::consoleEnv();
                static::createService($arg2, $arg3, $arg4);
            break;
            case 'create:action':
                static::consoleEnv();
                static::createAction($arg2, $arg3, $arg4);
            break;
            case 'create:library':
                static::consoleEnv();
                static::createLibrary($arg2, $arg3, $arg4);
            break;
            case 'create:helper':
                static::consoleEnv();
                static::createHelper($arg2, $arg3, $arg4);
            break;
            case 'create:form':
                static::consoleEnv();
                static::createForm($arg2, $arg3, $arg4);
            break;
            case 'create:rule':
                static::consoleEnv();
                static::createRule($arg2, $arg3, $arg4);
            break;
            case 'create:middleware':
                static::consoleEnv();
                static::createMiddleware($arg2, $arg3, $arg4);
            break;
            case 'create:enum':
                static::consoleEnv();
                static::createEnum($arg2, $arg3, $arg4);
            break;
            case 'install:package':
                static::consoleEnv();
                $installOption = 'require ';
                static::runSystemCommand(static::$composerCommand . $installOption. $arg2 . ' ' . $arg3);
            break;
            // case 'publish:package':
            //     static::consoleEnv();
            // break;
            case 'update:composer':
                static::consoleEnv();
                static::runSystemCommand(static::$composerCommand .'self-update');
            break;
            default:
                static::noCommand();
            break;
        }
    }
    
    protected static function createPackage(...$args)
    {
        $name = '';
        $type = '';
        $with = '';

        if (isset($args[0])) {
            $name = $args[0];
        }

        if (isset($args[1])) {
            $with = $args[1];
        }

        $command = static::$phpCommand . 'create/createpackage/' . $name . '/' . $type . '/' . $with;
        static::runSystemCommand($command);
    }

    protected static function createModule(...$args)
    {
        $module = explode(':', $args[0]);
        $name = '';
        $type = '';
        $with = '';

        if (isset($module[0])) {
            $type = $module[0];
        }

        if (isset($module[1])) {
            $name = $module[1];
        }

        if (isset($args[1])) {
            $with = $args[1];
        }

        $command = static::$phpCommand . 'create/createmodule/' . $name . '/' . $type . '/' . $with;
        static::runSystemCommand($command);
    }

    protected static function createController(...$args)
    {
        $module = $args[0];
        $controllerName = '';

        $controller = str_replace('=', ':', $args[1]);
        $controller = explode(':', $controller);

        $addController = '';

        if ($controller[0] !== '--name') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:controller", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        if (isset($controller[1])) {
            $controllerName = $controller[1];
        }

        if (isset($args[2])) {
            $addController = $args[2];
        }
        
        $module = str_replace('=',':', $module);
        $command = static::$phpCommand . 'create/createcontroller/' . $module . '/' . $controllerName . '/' . $addController;
        static::runSystemCommand($command);
    }

    protected static function createModel(...$args)
    {
        $module = $args[0];
        $modelName = '';

        $model = str_replace('=', ':', $args[1]);
        $model = explode(':', $model);

        $modelType = '';
        $removeModel = '';

        if ($model[0] !== '--name') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:model", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        if (isset($model[1])) {
            $modelName = $model[1];
        }

        if (isset($args[2])) {
            $modelType = $args[2];
        }
        
        if (isset($args[3])) {
            $removeModel = $args[3];
        }
        
        if ($modelType == '--remove-model') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:model", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        $module = str_replace('=', ':', $module);
        $command = static::$phpCommand . 'create/createmodel/' . $module . '/' . $modelName . '/' . $modelType. '/' . $removeModel;
        static::runSystemCommand($command);
    }

    protected static function createService(...$args)
    {
        $module = $args[0];
        $serviceName = '';

        $service = str_replace('=', ':', $args[1]);
        $service = explode(':', $service);

        if ($service[0] !== '--name') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:service", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        if (isset($service[1])) {
            $serviceName = $service[1];
        }

        $module = str_replace('=', ':', $module);
        $command = static::$phpCommand . 'create/createservice/' . $module . '/' . $serviceName;
        static::runSystemCommand($command);
    }

    protected static function createAction(...$args)
    {
        $module = $args[0];
        $actionName = '';

        $action = str_replace('=', ':', $args[1]);
        $action = explode(':', $action);

        $actionType = '';

        if ($action[0] !== '--name') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:action", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        if (isset($action[1])) {
            $actionName = $action[1];
        }

        if (isset($args[2])) {
            $actionType = $args[2];
        }

        $module = str_replace('=', ':', $module);
        $command = static::$phpCommand . 'create/createaction/' . $module . '/' . $actionName . '/' . $actionType;
        static::runSystemCommand($command);
    }

    protected static function createLibrary(...$args)
    {
        $module = $args[0];
        $libraryName = '';

        $library = str_replace('=', ':', $args[1]);
        $library = explode(':', $library);

        if ($library[0] !== '--name') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax for create:library", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        if (isset($library[1])) {
            $libraryName = $library[1];
        }

        $module = str_replace('=', ':', $module);
        $command = static::$phpCommand . 'create/createlibrary/' . $module . '/' . $libraryName;
        static::runSystemCommand($command);
    }

    protected static function createHelper(...$args)
    {
        $module = $args[0];
        $helperName = '';

        $helper = str_replace('=', ':', $args[1]);
        $helper = explode(':', $helper);

        $helperType = '';

        if ($helper[0] !== '--name') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:helper", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        if (isset($helper[1])) {
            $helperName = $helper[1];
        }

        if (isset($args[2])) {
            $helperType = $args[2];
        }

        $module = str_replace('=', ':', $module);
        $command = static::$phpCommand . 'create/createhelper/' . $module . '/' . $helperName . '/' . $helperType;
        static::runSystemCommand($command);
    }

    protected static function createForm(...$args)
    {
        $module = $args[0];
        $formName = '';

        $form = str_replace('=', ':', $args[1]);
        $form = explode(':', $form);

        if ($form[0] !== '--name') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:form", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        if (isset($form[1])) {
            $formName = $form[1];
        }

        $module = str_replace('=', ':', $module);
        $command = static::$phpCommand . 'create/createform/' . $module . '/' . $formName;
        static::runSystemCommand($command);
    }

    /**
     * Create Rule
     *
     * @param mixed ...$args
     * @return void
     */
    protected static function createRule(...$args)
    {
        $module = $args[0];
        $ruleName = '';

        $rule = str_replace('=', ':', $args[1]);
        $rule = explode(':', $rule);

        if ($rule[0] !== '--name') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:rule", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        if (isset($rule[1])) {
            $ruleName = $rule[1];
        }

        $module = str_replace('=', ':', $module);
        $command = static::$phpCommand . 'create/createrule/' . $module . '/' . $ruleName;
        static::runSystemCommand($command);
    }

    protected static function createMiddleware(...$args)
    {
        $name = '';
        $type = '';

        if (isset($args[0])) {
            $name = $args[0];
        }

        if (isset($args[1])) {
            $type = $args[1];
        }

        if ($name === '') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:middleware", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        $command = static::$phpCommand . 'create/createmiddleware/' . $name . '/' . $type;
        static::runSystemCommand($command);
    }

    protected static function createEnum(...$args)
    {
        $name = '';
        $type = '';

        if (isset($args[0])) {
            $name = $args[0];
        }

        if (isset($args[1])) {
            $type = $args[1];
        }

        if ($name === '') {
            $output =   " \n";
            $output .=  ConsoleColor::white(" Please check docs for correct syntax to create:enum", 'light', 'red') . " \n";
            echo $output . "\n";
            exit;
        }

        $command = static::$phpCommand . 'create/createenum/' . $name . '/' . $type;
        static::runSystemCommand($command);
    }


    /**
     * Check Console Environment
     *
     * @return void
     */
    private static function consoleEnv(): void
    {
        static::$env = static::userConstants()->ENVIRONMENT;

        if (static::$env !== 'development') {
            exit;
        }
    }

    /**
     * Set environment function
     *
     * @return void
     */
    private static function setenv(): void
    {
        static::$rootpath = static::userConstants()->WEBBY_ROOTPATH;
        
        $envExampleFile =  static::$rootpath . '/.env.example';
        $envFile = static::$rootpath . '/.env';

        if (file_exists($envFile)) {
            echo ConsoleColor::red("Environment file exists already!") . "\n";
            exit;
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
     * Serve Webby application
     *
     * @param array $args
     * @return void
     */
    private static function serve($args = []): void
    {
        static::$rootpath = static::userConstants()->WEBBY_ROOTPATH;
        
        $number = isset($args[3]) ? (int)$args[3] : "";
        $project_dir = static::$rootpath; //__DIR__;
        $dir = realpath($project_dir . '/public/');
        $port = (isset($number) && is_int($number)) ? $number : 8085;
        $port = intval($port);

        if ($port === 0) {
            echo ConsoleColor::red("Please choose a valid port!") . "\n";
            exit;
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
