<?php 

namespace Base\Controllers;

use Base\View\Plates;

class WebController extends Controller
{

    protected $plate;

    public function __construct()
    {
        parent::__construct();

        $this->data['site_name'] = config_item('app_name');

        $this->plate = $this->plates();
    }

    public function plates($params = [])
    {
        return (new Plates($params));
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
