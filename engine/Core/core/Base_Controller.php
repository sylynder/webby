<?php 
defined('COREPATH') or exit('No direct script access allowed');

class Base_Controller extends MX_Controller
{
    /**
     * Data array variable
     *
     * @var array
     */
    public $data = [];

    public function __construct()
    {
        parent::__construct();

        // Protection
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
    }

    protected function useDatabase() 
    {
        // Load the CodeIgniter Database 
        // Object from here i.e $this->db
        $this->load->database();
    }

}
/* end of file Base_Controller.php */
