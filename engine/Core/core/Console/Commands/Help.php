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
        $output .=  ConsoleColor::light_purple("    run:migration") .  ConsoleColor::cyan("    Run and manage migrations for databases")  . " \n";
        $output .=  ConsoleColor::light_purple("    list:routes") .  ConsoleColor::cyan("      List all available routes")  . " \n";
        $output .=  ConsoleColor::light_purple("    app:off") .  ConsoleColor::cyan("          Turn maintenance mode on")  . " \n";
        $output .=  ConsoleColor::light_purple("    app:on") .  ConsoleColor::cyan("           Turn maintenance mode off")  . " \n";
        $output .=  ConsoleColor::light_purple("    resource:link") .  ConsoleColor::cyan("    Create a symlink for the resources folder in public")  . " \n";
        $output .=  ConsoleColor::light_purple("    use:command") .  ConsoleColor::cyan("      This enables you to access console controllers to perform cli tasks")  . " \n";
        $output .=  ConsoleColor::light_purple("    git:init") .  ConsoleColor::cyan("         Initialize your project to use git")  . " \n";
        $output .=  ConsoleColor::light_purple("    clear:cache") .  ConsoleColor::cyan("      Clear specific cached files")  . " \n";

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
            {$description}
                The webby server for local development.

            {$usage}
                php webby serve [option]

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
            {$description}
                Generate an encryption key for your application.
                The [--regenerate] option will regenerate a new key please 
                becareful when using this option.

            {$usage}
                php webby key:generate [option] [--regenerate]

            {$examples}
                php webby key:generate
                php webby key:generate --regenerate

        KEYGENERATE;
    }

    private static function create_migration()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEMIGRATION
            {$welcome}
            {$description}
                Create migration files to be used

            {$usage}
                php webby create:migration <migration-file-name>
            
            {$examples}
                php webby create:migration create_books_table
                php webby create:migration create_authors_table

        CREATEMIGRATION;
    }

    private static function migration()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<MIGRATION
            {$welcome}
            {$description}
                Perform migration functionalities on your migration files.

            {$usage}
                php webby run:migration
            
            {$examples}
                php webby run:migration
                php webby run:migration --step=1
                php webby run:migration --rollback --step=1
                php webby run:migration --reset
                php webby run:migration --status
                php webby run:migration --latest
                php webby run:migration --truncate
                
        MIGRATION;
    }

    private static function listRoutes()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<LISTROUTES
            {$welcome}
            {$description}
                List all routes defined in your entire application.

            {$usage}
                php webby list:routes 
            
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
            {$description}
                Brings an application back to live from maintenance mode.

            {$usage}
                php webby app:on 
            
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
            {$description}
                Makes an application switch to maintenance mode.

            {$usage}
                php webby app:off 

            {$examples}
                php webby app:off

        APPOFF;
    }

    private static function AppToDevelopment()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<APPTODEVELOPMENT
            {$welcome}
            {$description}
                Make application ready for development mode.

            {$usage}
                php webby app:to-development 

            {$examples}
                php webby app:to-development

        APPTODEVELOPMENT;
    }

    private static function AppToTesting()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<APPTOTESTING
            {$welcome}
            {$description}
                Make application ready for testing mode.

            {$usage}
                php webby app:to-testing 

            {$examples}
                php webby app:to-testing

        APPTOTESTING;
    }

    private static function AppToProduction()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<APPTOPRODUCTION
            {$welcome}
            {$description}
                Make application ready for production mode.

            {$usage}
                php webby app:to-production 

            {$examples}
                php webby app:to-production

        APPTOPRODUCTION;
    }

    private static function resourceLink()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<RESOURCELINK
            {$welcome}
            {$description}
                Creates a symlink for the resources folder in public directory.

            {$usage}
                php webby resource:link

            {$examples}
                php webby resource:link

        RESOURCELINK;
    }

    private static function useCommand()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<USECOMMAND
            {$welcome}
            {$description}
                Enables you to access console controllers to perform cli tasks.

            {$usage}
                php webby use:command

            {$examples}
                php webby use:command

        USECOMMAND;
    }

    private static function gitInit()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<GITINIT
            {$welcome}
            {$description}
                Initialize your project to use git.

            {$usage}
                php webby git:init

            {$examples}
                php webby git:init


        GITINIT;
    }

    private static function clear_cache()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CLEARCACHE
            {$welcome}
            {$description}
                Clear cache by specifying cached path.

            {$usage}
                php webby clear:cache [options]

            {$examples}
                php webby clear:cache --files
                php webby clear:cache --arrayz
                php webby clear:cache --plates
                php webby clear:cache --web


        CLEARCACHE;
    }

    private static function create_module()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEMODULE
            {$welcome}
            {$description}
                Create modules by specifying which sub-directories to use.

            {$usage}
                php webby create:module <name>
                php webby create:module <module-type:module-name> --config
                php webby create:module <module-type:module-name> --m
                php webby create:module <module-type:module-name> --v
                php webby create:module <module-type:module-name> --c
                php webby create:module <module-type:module-name> --h
                php webby create:module <module-type:module-name> --l
                php webby create:module <module-type:module-name> --f
                php webby create:module <module-type:module-name> --s
                php webby create:module <module-type:module-name> --r
                php webby create:module <module-type:module-name> --a
                php webby create:module <module-type:module-name> --mvc
                php webby create:module <module-type:module-name> --all
                

            {$examples}
                php webby create:module web:books --mvc


        CREATEMODULE;
    }

    private static function create_package()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEPACKAGE
            {$welcome}
            {$description}
                Create package(modules) by specifying which sub-directories to use.

            {$usage}
                php webby create:package <name>
                php webby create:package <name> --config
                php webby create:package <name> --m 
                php webby create:package <name> --v 
                php webby create:package <name> --c 
                php webby create:package <name> --all 


            {$examples}
                php webby create:package notifications --all
                php webby create:package notifications --config

        CREATEPACKAGE;
    }

    private static function create_controller()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATECONTROLLER
            {$welcome}
            {$description}
                Create controller by specifying which module it belongs with

            {$usage}
                php webby create:controller <module-type:module-name> <controller-name>


            {$examples}
                php webby create:controller web:books --name=books
                php webby create:controller web:console --name=schedule
                php webby create:controller api:v1 --name=send
                php webby create:controller web:books --name=authors --addcontroller

        CREATECONTROLLER;
    }

    private static function create_model()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEMODEL
            {$welcome}
            {$description}
                Create model by specifying which module it belongs with.

            {$usage}
                php webby create:model <module-type:module-name> <model-name>

            {$examples}
                php webby create:model web:app --name=books
                php webby create:model console:tasks --name=schedule
                php webby create:model api:v1 --name=send

        CREATEMODEL;
    }

    private static function create_service()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATESERVICE
            {$welcome}
            {$description}
                Create service by specifying which module it belongs with.

            {$usage}
                php webby create:service <module-type:module-name> <service-name>

            {$examples}
                php webby create:service web:books --name=pdf
                php webby create:service console:tasks --name=queue
                php webby create:service api:v1 --name=mail

        CREATESERVICE;
    }

    private static function create_action()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEACTION
            {$welcome}
            {$description}
                Create action by specifying which module it belongs with.

            {$usage}
                php webby create:action <module-type:module-name> <action-name> <action-type>

            {$examples}
                php webby create:action web:books --name=books
                php webby create:action web:books --name=author --crud
                php webby create:action web:books --name=category --job
            
        CREATEACTION;
    }

    private static function create_library()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATELIBRARY
            {$welcome}
            {$description}
                Create library by specifying which module it belongs with.

            {$usage}
                php webby create:library <module-type:module-name> <library-name>

            {$examples}
                php webby create:library web:books --name=isbn
                php webby create:library web:books --name=wiki
                
        CREATELIBRARY;
    }

    private static function create_helper()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEHELPER
            {$welcome}
            {$description}
                Create helper by specifying which module it belongs with.

            {$usage}
                php webby create:helper <module-type:module-name> <helper-name> <helper-type>

            {$examples}
                php webby create:helper web:books --name=status --base
                php webby create:helper web:books --name=pdf --static
            
        CREATEHELPER;
    }

    private static function create_form()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEFORM
            {$welcome}
            {$description}
                Create form to validate your input fields.
                Specify which module the form belongs with.

            {$usage}
                php webby create:form <module-type:module-name> <form-name>

            {$examples}
                php webby create:form web:books --name=author
                php webby create:form web:auth --name=login
            
        CREATEFORM;
    }

    private static function create_rule()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATERULE
            {$welcome}
            {$description}
                Create rule to validate your input fields.
                Rules work a little different from Forms.
                Specify which module the rule belongs with.

            {$usage}
                php webby create:rule <module-type:module-name> <rule-name>

            {$examples}
                php webby create:rule web:books --name=author
                php webby create:rule web:auth --name=login

        CREATERULE;
    }

    private static function create_middleware()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEMIDDLEWARE
            {$welcome}
            {$description}
                Create middleware to implement a filter on your controllers.

            {$usage}
                php webby create:middleware <middleware-name> <middleware-type>

            {$examples}
                php webby create:middleware admin --web
                php webby create:middleware cron --console
                php webby create:middleware users --api

        CREATEMIDDLEWARE;
    }

    private static function create_enum()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<CREATEENUM
            {$welcome}
            {$description}
                Create enums with real to create PHP8.1 enum or fake to create class constants

            {$usage}
                php webby create:enum <enum-name> <enum-type>

            {$examples}
                php webby create:enum status --fake
                php webby create:enum content --real
            
        CREATEENUM;
    }

    public function sample()
    {
        $welcome     = static::welcome();
        $usage       = static::hereColor('Usage:', 'yellow');
        $description = static::hereColor('Description:', 'yellow');
        $examples    = static::hereColor('Examples:', 'yellow');

        echo <<<HELP
            {$welcome}
            {$description}
                The sample for creating cli help descriptions.

            {$usage}
                php webby sample example

            {$examples}
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
            case 'run:migration':
                Help::migration();
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
            case 'app:to-development':
                Help::AppToDevelopment();
            break;
            case 'app:to-testing':
                Help::AppToTesting();
            break;
            case 'app:to-production':
                Help::AppToProduction();
            break;
            case 'resource:link':
                Help::resourceLink();
            break;
            case 'use:command':
                Help::useCommand();
            break;
            case 'git:init':
                Help::gitInit();
            break;
            case 'clear:cache':
                Help::clear_cache();
            break;
            case 'key:generate':
                Help::keyGenerate();
            break;
            case 'create:migration':
                Help::create_migration();
            break;
            case 'create:module':
                Help::create_module();
            break;
            case 'create:package':
                Help::create_package();
            break;
            case 'create:controller':
                Help::create_controller();
            break;
            case 'create:model':
                Help::create_model();
            break;
            case 'create:service':
                Help::create_service();
            break;
            case 'create:action':
                Help::create_action();
            break;
            case 'create:library':
                Help::create_library();
            break;
            case 'create:helper':
                Help::create_helper();
            break;
            case 'create:form':
                Help::create_form();
            break;
            case 'create:rule':
                Help::create_rule();
            break;
            case 'create:middleware':
                Help::create_middleware();
            break;
            case 'create:enum':
                Help::create_enum();
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
