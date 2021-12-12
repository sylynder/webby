<?php

namespace Base\Console\Commands;

class MakeDirectory
{

    // recursive create folder and return file path
    public static function createModuleDirectory($modulePath, $directoryName)
    {

        $directory = $modulePath . $directoryName;

        if (!file_exists($directory)) {
            mkdir($directory, 0775, true);
            return true;
        }

        return false;

        // dd();
        // unset($arrDir[count($arrDir) - 1]);
        
        // foreach ($arrDir as $key => $value) {
        //     $folder .= $value . '/';
        //     if (!file_exists($folder)) {
        //         mkdir($folder);
        //     }
        // }

        // $arrDir = explode('.', $fileName);
        
        // switch ($mvc) {
        //     case 'views':
        //         $arrDir[count($arrDir) - 1] = strtolower($arrDir[count($arrDir) - 1]);
        //         break;
        //     default:
        //         $arrDir[count($arrDir) - 1] = ucfirst($arrDir[count($arrDir) - 1]);
        //         break;
        // }

        // return implode('/', $arrDir);
    }
}