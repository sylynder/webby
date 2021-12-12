<?php

use Base\Controllers\ConsoleController;

class Migrate extends ConsoleController
{
    public function __construct()
    {
        parent::__construct();
        $this->onlydev();
        $this->load->library('migration');
    }

    public function index()
    {
        if ($this->migration->current() === false) {
            show_error($this->migration->error_string());
        } else {
            echo "Table Migrated Successfully.";
        }
    }
}
