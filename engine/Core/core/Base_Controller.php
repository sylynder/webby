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

    protected function setBreadcrumb($title, $item = '', $active_page = '')
    {
        $this->data['breadcrumb_title'] = $title;
        $this->data['breadcrumb_item']  = $item;
        $this->data['active_page']      = $active_page;
    }

    protected function view($view_path, $view_data = [], $return = false) 
    {
        return view($view_path, $view_data, $return);
    }

    protected function layout($layout_path, $view_path = null, $view_data = null) 
    {
        return layout($layout_path, $view_path, $view_data);
    }

}
/* end of file Base_Controller.php */
