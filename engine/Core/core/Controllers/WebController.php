<?php 

namespace Base\Controllers;

use Base\View\Plates;

class WebController extends Controller
{

    public $plate;

    public function __construct()
    {
        parent::__construct();
        $this->plate = $this->plates();
    }

    public function plates($params = [])
    {
        return (new Plates($params));
    }

}
