<?php

use Base\Helpers\DotEnvWriter;
use Base\Console\ConsoleColor;
use Base\Controllers\ConsoleController;

class Maintenance extends ConsoleController
{

    /**
     * Console keyword
     *
     * @var string
     */
    private $keyword = 'app.mode.on';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Turn on
     * Used with webby command
     *
     * @return void
     */
    public function on()
    {
        $exists = $this->check();

        if ($exists) {
            $this->turnOn();
        }

        echo ConsoleColor::yellow("Application is back online") . "\n";
    }

    /**
     * Turn off
     * Used with webby command
     * 
     * @return void
     */
    public function off()
    {
        $exists = $this->check();

        if ($exists) {
            $this->turnOff();
        }

        echo ConsoleColor::yellow("Application is offline now") . "\n";
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
     * Turn App Mode On
     *
     * @return void
     */
    private function turnOn()
    {
        $dotenv = new DotEnvWriter();

        $mode = $dotenv->getValue($this->keyword);

        if ($mode === "false") {
            $dotenv->setValue($this->keyword, str_replace('"', '', "true"));
        }
    }

    /**
     * Turn App Mode Off
     *
     * @return void
     */
    public function turnOff()
    {
        $dotenv = new DotEnvWriter();

        $mode = $dotenv->getValue($this->keyword);

        if ($mode === "true") {
            $dotenv->setValue($this->keyword, str_replace('"', '', "false"));
        }
    }
}
