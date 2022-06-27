<?php

use Base\Controllers\WebController;

class App extends WebController 
{
	public function __construct()
	{
		parent::__construct();

		// use services, forms, libraries etc
	}

	public function index()
	{
		return view('welcome');
	}

}
