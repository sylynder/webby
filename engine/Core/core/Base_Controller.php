<?php defined('COREPATH') OR exit('No direct script access allowed');

class Base_Controller extends MX_Controller
{

    public $data = [];

    public function __construct()
    {
        parent::__construct();

        $this->data['site_name'] = config_item('app_name');

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

    protected function setTitle($title)
    {
        $this->data['page_title'] = $title;
    }

    protected function setBreadcrumb($title, $item = '', $activePage = '')
    {
        $this->data['breadcrumb_title'] = $title;
        $this->data['breadcrumb_item']  = $item;
        $this->data['active_page']      = $activePage;
    }

    protected function view($viewPath, $viewData = [], $return = false) 
    {
        return view($viewPath, $viewData, $return);
    }

    protected function layout($layoutPath, $viewPath = null, $viewData = null) 
    {
        return layout($layoutPath, $viewPath, $viewData);
    }

}
/* end of file Base_Controller.php */
