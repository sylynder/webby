<?php

namespace Base\Controllers;

class ConsoleController extends Controller
{
    
    private $env = 'development';

    public function __construct()
    {
        parent::__construct();

        if (!is_cli()) {show_404();}
    }

    /**
     * Set to allow for only
     * development environment
     *
     * @return void
     */
    protected function onlydev()
    {
        if (ENVIRONMENT !== $this->env) {
            exit;
        }
    }

}
