<?php

use Base\Controllers\WebController;

class Handle extends WebController
{

    public function __construct()
    {
        parent::__construct();

        // use services, forms, libraries etc
    }
    
    /**
     * Index route
     *
     * @return void
     */
    public function index()
    {
        $this->page404();
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

    /**
     * Custom Error 404 
     *
     * @return void
     */
    public function page404()
    {
        return view('errors.app.error404', $this->data);
    }
}
