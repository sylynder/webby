<?php

namespace Base\Controllers;

use Exception;
use Base\Http\HttpStatus;
use Base\Rest\RestController;

class ApiController extends RestController // RestController from the "Rest" directory
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the request parameters 
     * given in the request body.
     *
     * @return array|string the request parameters 
     * given in the request body.
     */
    public function getContent($asArray = false)
    {
        $content = clean(input()->post());

        if (is_null($content) || empty($content)) {
            $content = json_decode(clean(input()->raw_input_stream), true);
        }

        if ($asArray) {
            return $content = !is_null($content) ? $content : [];
        }

        return $content = !is_null($content) ? json_encode($content) : [];
    }

    protected function setKey($controllerMethod, $value)
    {
        if (!empty($controllerMethod) && !empty($value)) {
            return $this->methods[$controllerMethod]['key'] = $value;
        }

        throw new Exception("Specify controller method and key", HttpStatus::BAD_REQUEST);
    }

    protected function setLimit($controllerMethod, $noOfTimes)
    {
        if (!empty($controllerMethod) && !empty($noOfTimes)) {
            return $this->methods[$controllerMethod]['limit'] = $noOfTimes;
        }

        throw new Exception("Specify controller method and no of times", HttpStatus::BAD_REQUEST);
    }

    protected function setLevel($controllerMethod, $value)
    {
        if (!empty($controllerMethod) && !empty($value)) {
            return $this->methods[$controllerMethod]['level'] = $value;
        }

        throw new Exception("Specify controller method and level", HttpStatus::BAD_REQUEST);
    }

    protected function setTime($controllerMethod, $value)
    {
        if (!empty($controllerMethod) && !empty($value)) {
            return $this->methods[$controllerMethod]['time'] = $value;
        }

        throw new Exception("Specify controller method and level", HttpStatus::BAD_REQUEST);
    }

    protected function setLog($controllerMethod, $value)
    {
        if (!empty($controllerMethod) && !empty($value)) {
            return $this->methods[$controllerMethod]['log'] = $value;
        }

        throw new Exception("Specify controller method and log", HttpStatus::BAD_REQUEST);
    }
}
