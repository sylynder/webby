<?php

/**
 * A Base Middleware to provide basic 
 * Middleware implementation in Webby
 * 
 *
 * @author  Oteng Kwame Appiah-Nti <developerkwame@gmail.com> (Developer Kwame)
 * @license MIT
 * @link    <link will be here>
 * @version 1.0
 */

namespace Base\Middleware;

use Base\Controllers\Controller;

class Middleware extends Controller
{
    protected $middlewares = [];

    public function __construct()
    {
        parent::__construct();

        $this->runMiddlewares();
    }

    protected function middleware()
    {
        return [];
    }

    protected function runMiddlewares()
    {
        $this->load->helper('inflector');

        $middlewares = $this->middleware();

        foreach ($middlewares as $middleware) {

            $middlewareArray = explode('|', str_replace(' ', '', $middleware));
            $middlewareName = $middlewareArray[0];
            $runMiddleware = true;

            if (isset($middlewareArray[1])) {

                $options = explode(':', $middlewareArray[1]);

                $type = $options[0];

                $methods = explode(',', $options[1]);

                if ($type == 'except') {

                    if (in_array($this->router->method, $methods)) {
                        $runMiddleware = false;
                    }

                } else if ($type == 'only') {

                    if (!in_array($this->router->method, $methods)) {
                        $runMiddleware = false;
                    }

                }
            }

            $filename = ucfirst(camelize($middlewareName)) . 'Middleware';

            if ($runMiddleware == true) {
                if (file_exists(APPROOT . 'Middleware/' . $filename . '.php')) {
                    require APPROOT . 'Middleware/' . $filename . '.php';

                    $ci = &get_instance();

                    $object = new $filename($this, $ci);

                    $object->run();

                    $this->middlewares[$middlewareName] = $object;

                } else {
                    
                    if (ENVIRONMENT == 'development') {
                        show_error('Unable to load middleware: ' . $filename . '.php');
                    } else {
                        show_error('Sorry something went wrong.');
                    }
                }
            }
        }
    }
}
