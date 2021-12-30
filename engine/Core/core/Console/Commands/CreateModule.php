<?php

namespace Base\Console\Commands;

use Base\Console\Commands\MakeDirectory;

class CreateModule 
{
    private $web      = 'Web';
    private $console  = 'Console';
    private $packages = 'Packages';
    private $api      = 'Api';

    public function __construct()
    {
        $this->make = new MakeDirectory();
    }

    public function createModule($type, $directoryName)
    {
        $isType = !empty($type) ? true : false;
        $isDirectoryName = !empty($type) ? true : false;

        if (!$isType && !$isDirectoryName) {
            return false;
        }

        switch ($type) {

            case 'console':
                
            break;
            case 'web':
                MakeDirectory::createModuleDirectory(ROOTPATH . ucfirst($this->web), $directoryName);
            break;
            case 'api':
                # code...
            break;
            case 'packages':
                # code...
            break;
            default:
                # code...
            break;

        }

        return true;
    }
}