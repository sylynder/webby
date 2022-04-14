<?php

use Base\Helpers\DotEnvWriter;
use Base\Console\ConsoleColor;
use Base\Controllers\ConsoleController;

class Environment extends ConsoleController
{

    /**
     * Console keyword
     *
     * @var string
     */
    private $keyword = 'app.env';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * To production
     * Used with webby command
     *
     * @return void
     */
    public function production()
    {
        $exists = $this->check();

        if ($exists) {
            $this->toProduction();
        }

        echo ConsoleColor::yellow("Application environment set to production ") . "\n\n";
    }

    /**
     * To Testing
     * Used with webby command
     * 
     * @return void
     */
    public function testing()
    {
        $exists = $this->check();

        if ($exists) {
            $this->toTesting();
        }

        echo ConsoleColor::yellow("Application environment set to testing ") . "\n\n";
    }

    /**
     * To development
     * Used with webby command
     * 
     * @return void
     */
    public function development()
    {
        $exists = $this->check();

        if ($exists) {
            $this->toDevelopment();
        }

        echo ConsoleColor::yellow("Application environment set to development ") . "\n\n";
    }

    /**
     * Check if key exists
     *
     * @return bool
     */
    private function check()
    {

        $exists = false;

        if ((new DotEnvWriter)->exists($this->keyword)) {
            $exists = true;
        }

        return $exists;
    }

    /**
     * Change App Env to production
     *
     * @return void
     */
    private function toProduction()
    {
        $dotenv = new DotEnvWriter();

        $mode = $dotenv->getValue($this->keyword);

        if ($mode === "testing") {
            $dotenv->setValue($this->keyword, str_replace('"', '', "production"));
        }

        if ($mode === "development") {
            $dotenv->setValue($this->keyword, str_replace('"', '', "production"));
        }
    }

    /**
     * Change App Env to testing
     *
     * @return void
     */
    private function toTesting()
    {
        $dotenv = new DotEnvWriter();

        $mode = $dotenv->getValue($this->keyword);

        if ($mode === "development") {
            $dotenv->setValue($this->keyword, str_replace('"', '', "testing"));
        }

        $this->onlydev();
        if ($mode === "production") {
            $dotenv->setValue($this->keyword, str_replace('"', '', "testing"));
        }
    }

    /**
     * Change App Env to development
     *
     * @return void
     */
    public function toDevelopment()
    {
        $dotenv = new DotEnvWriter();

        $mode = $dotenv->getValue($this->keyword);

        if ($mode === "testing") {
            $dotenv->setValue($this->keyword, str_replace('"', '', "development"));
        }

        $this->onlydev();
        if ($mode === "production") {
            $dotenv->setValue($this->keyword, str_replace('"', '', "development"));
        }
    }
}
