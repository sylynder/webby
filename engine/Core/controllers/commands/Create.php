<?php

use Base\Console\ConsoleColor;
use Base\Controllers\ConsoleController;

class Create extends ConsoleController
{
    public function __construct()
    {
        parent::__construct();
        $this->onlydev();
    }

    /**
     * Create a symlink resources path
     *
     * @return void
     */
    public function resourcelink()
    {
        $resourcesFolder = WRITABLEPATH . 'resources' . DS;
        $publicResourcesLinkFolder = FCPATH . 'resources';

        $created = true;

        shut_up();
            $created = symlink($resourcesFolder, $publicResourcesLinkFolder);
        speak_up();

        if (!$created) {
            
            $output =   " \n";
            $output .=  ConsoleColor::white(" Sorry symlink for resources was not created", 'light', 'red') . " \n";

            echo $output . "\n";
        }

        if ($created) {
            $output =   " \n";
            $output .=  ConsoleColor::green(" Symlink for resources created successfully") . " \n";

            echo $output . "\n";
        }
    
    }

}
