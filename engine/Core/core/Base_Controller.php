<?php 
defined('COREPATH') or exit('No direct script access allowed');

class Base_Controller extends MX_Controller
{

    public $data = [];

    public function __construct()
    {
        parent::__construct();

        // Protection
        $this->output->set_header('X-Content-Type-Options: nosniff');
        $this->output->set_header('X-Frame-Options: DENY');
        $this->output->set_header('X-XSS-Protection: 1; mode=block');
    }

    protected function useDatabase() 
    {
        // Load the CodeIgniter Database 
        // Object from here i.e $this->db
        $this->load->database();
    }

}
/* end of file Base_Controller.php */
