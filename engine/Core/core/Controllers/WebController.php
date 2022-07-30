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

    protected function json($data = null, $statusCode = 200)
    {
        echo $this->output
            ->set_status_header($statusCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    protected function cachePage($ttl = 5)
    {
        $this->output->cache($ttl);
    }

    protected function removePageCache($page = '')
    {
        if (empty($page)) {
            return $this->output->delete_cache();
        }

        $this->output->delete_cache($page);
        
    }

    /**
     * An implemented method to
     * send intruders outside 
     * of the application
     *
     * @param string $to
     * @return void
     */
    protected function toOutside($to = '')
    {
        if (!contains('https://', $to) or !contains('http://', $to)) {
            $to = empty($to) ? "" : 'https://' . $to;
        } else {
            $to = '';
        }

        if (!empty($to)) {
            config('route_outside', $to);
        }

        if (in_array(uri_segment(1), config_item('forbidden_routes'))) {
            redirect(config('route_outside'), 'refresh');
        }

        if (!in_array(uri_segment(1), config_item('forbidden_routes'))) {
            redirect(config('route_outside'), 'refresh');
        }
    }
    
}
