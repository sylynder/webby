<?php

namespace Base\Console\Commands;

use Base\Console\Console;
use Base\Console\ConsoleColor;

class Help extends Console
{
    /**
     * Show help list
     *
     * @param string $help
     * @return void
     */
    public static function runHelp()
    {
        Console::runSystemCommand(Console::$phpCommand . 'help');
    }

    /**
     * Display console help
     *
     * @param array $args
     * @return void
     */
    public static function showHelp(): void
    {
        $output =   " \n";
        $output .=  static::welcome();
        $output .=  " \n";
        $output .=  ConsoleColor::yellow(" Usage:") . " \n";
        $output .=  ConsoleColor::cyan("    webby [options] [arguments] ") . "\n";
        $output .=  " \n";

        $output .=  ConsoleColor::green(" All commands start with 'php webby'") . " \n";
        $output .=  ConsoleColor::green("     --help") .  ConsoleColor::cyan("     Help list for available commands if not specified will show by default")  . " \n";

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

    private static function serve()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<SERVE
            {$welcome}
            {$usage}
                php webby serve [option]
            
            {$description}
                The webby server for local development.

            {$examples}
                php webby serve
                php webby serve --port 8086
                php webby serve --port 9000


        SERVE;
    }

    private static function keyGenerate()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<KEYGENERATE
            {$welcome}
            {$usage}
                php webby key:generate [option] [--regenerate]
            
            {$description}
                This will generate an encryption key for your application.
                The [--regenerate] option will regenerate a new key please 
                becareful when using this option.

            {$examples}
                php webby key:generate
                php webby key:generate --regenerate


        KEYGENERATE;
    }

    private static function migrate()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<KEYGENERATE
            {$welcome}
            {$usage}
                php webby migrate 
            
            {$description}
                This will perform a migration function on your migration files.

            {$examples}
                php webby migrate


        KEYGENERATE;
    }

    private static function listRoutes()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<LISTROUTES
            {$welcome}
            {$usage}
                php webby list:routes 
            
            {$description}
                This will list all routes you have defined in your entire application.

            {$examples}
                php webby list:routes


        LISTROUTES;
    }

    private static function AppOn()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<APPON
            {$welcome}
            {$usage}
                php webby app:on 
            
            {$description}
                This will bring an application back to live from maintenance mode.

            {$examples}
                php webby app:on


        APPON;
    }

    private static function AppOff()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<APPOFF
            {$welcome}
            {$usage}
                php webby app:off 
            
            {$description}
                This will send an application into maintenance mode.

            {$examples}
                php webby app:off


        APPOFF;
    }

    public function sample()
    {
        echo <<<HELP

            Usage:
                php webby samole example

            Description:
                The sample for creating cli help descriptions.

            Examples:
                php webby some command


        HELP;
    }

    public static function whichHelp($command)
    {
        switch ($command) {

            case 'serve':
                Help::serve();
            break;
            case 'key:generate':
                Help::keyGenerate();
            break;
            case 'migrate':
                Help::migrate();
            break;
            case 'list:routes':
                Help::listRoutes();
            break;
            case 'app:on':
                Help::AppOn();
            break;
            case 'app:off':
                Help::AppOff();
             break;
            default:
                Help::showHelp();
            break;
        }

        return;
    }

    private static function hereColor($string = '', $color = 'cyan')
    {
        switch ($color) {
            case 'cyan':
                return ConsoleColor::cyan($string);
            break;
            case 'green':
                return ConsoleColor::green($string);
            break;
            case 'yellow':
                return ConsoleColor::yellow($string);
            break;
            case 'purple':
                return ConsoleColor::purple($string);
            break;
            case 'light_purple':
                return ConsoleColor::light_purple($string);
            break;
            case 'normal':
                return ConsoleColor::normal($string);
            break;
            case 'dim':
                return ConsoleColor::dim($string);
            break;
            case 'red':
                return ConsoleColor::red($string);
            break;
            case 'brown':
                return ConsoleColor::brown($string);
            break;
            case 'white':
                return ConsoleColor::white($string);
            break;
            default:
                return ConsoleColor::white($string);
            break;
        }
        return ConsoleColor::cyan($string);
    }

}
