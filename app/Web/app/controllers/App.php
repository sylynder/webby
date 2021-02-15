<?php

use Base\Controllers\WebController;

class App extends WebController {

	public function index()
	{
		return view('welcome');
	}
}
