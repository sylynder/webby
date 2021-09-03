<?php

use Base\Controllers\WebController;

class App extends WebController 
{

	public function index()
	{
		return view('welcome');
	}

	public function error404()
	{
		return view('errors.error404');
	}
}
