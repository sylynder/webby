<?php 

namespace Base\Controllers;

use Exception;
use Base\Http\HttpStatus;
use Base\Rest\RestController;

class ApiController extends RestController 
{

    public function __construct()
    {
        parent::__construct();
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
