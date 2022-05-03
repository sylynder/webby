<?php

use Base\Controllers\WebController;

class App extends WebController 
{

	public function index()
	{
		echo "Hello World";
		// return view('welcome');
	}

	/**
	 * This is a default method to
	 * send intruders outside of 
	 * the application
	 * 
	 * You can read the documentation
	 * to find out more
	 *
	 * @param string $to
	 * @return void
	 */
	public function outside($to = '')
	{
		$this->toOutside($to);
	}

	public function error404()
	{
		return view('errors.app.error404', $this->data);
	}

}
