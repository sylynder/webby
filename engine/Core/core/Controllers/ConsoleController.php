<?php

namespace Base\Controllers;

class ConsoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!is_cli()) {show_404();}
    }

}
