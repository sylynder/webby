<?php

use Base\Controllers\WebController;

class Handle extends WebController
{

    public function __construct()
    {
        parent::__construct();

        // use services, forms, libraries etc
    }
    
    /**
     * Index route
     *
     * @return void
     */
    public function index()
    {
        $this->console404();
        $this->api404();
        $this->page404();
    }

    /**
     * This is a default method to
     * send intruders outside of 
     * the application
     * 
     * You can read the documentation
     * to find out more
     *
     * @param string $to
     * @return void
     */
    public function outside($to = '')
    {
        $this->toOutside($to);
    }

    /**
     * Custom Error 404 for Web
     *
     * @return void
     */
    public function page404()
    {
        return view(config_item('app_error_view'), $this->data);
    }

     /**
     * Custom Error 404 for Console
     *
     * @return void
     */
    public function console404()
    {
        if (is_cli()) {
            show_404();
        }
    }

     /**
     * Custom Error 404 for Api
     *
     * @return void
     */
    public function api404()
    {
        // implement your code here
        // check your api routes
        // make sure you exit at the end of your checks' logic
        // The code below can used anyway
        if (contains('api/v1', current_url())) {

			header("Content-Type: application/json");

			$this->json([
				'status' => false,
				'error' => [
					"code" => Base\Http\HttpStatus::NOT_FOUND,
					"message" => "End Point Not Found"
				],
				'reason' => "End Point Not Found"
			], Base\Http\HttpStatus::NOT_FOUND);

			exit;
		}
        
    }
}
