<?php 

namespace Base\Controllers;

use Base\View\Plates;

class WebController extends \Base_Controller {

    public $plate;

    public function __construct()
    {
        $this->plate = new Plates();
    }

}
