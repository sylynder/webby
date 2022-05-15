 <?php

use Base\Console\ConsoleColor;
use Base\Console\Commands\Help as ConsoleHelp;
use Base\Controllers\ConsoleController;

class Help extends ConsoleController
{
    public function __construct()
    {
        parent::__construct();
        $this->onlydev();
    }

    public function index()
    {
        ConsoleHelp::showHelp();
    }
}
