<?php

use Base\Controllers\WebController;

class Migrate extends WebController 
{	
	public function __construct()
	{
		parent::__construct();
		use_library('migration');
	}
	
	public function index()
	{
			
		if ($this->migration->current() === FALSE)
		{
			show_error($this->migration->error_string());
		} else {
            echo "Table Migrated Successfully.";
        }
	}
}