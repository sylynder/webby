<?php

use Base\Cache\Cache as Cached;
use Base\Controllers\ConsoleController;

class Cache extends ConsoleController
{

    private $cache;

    public function __construct()
    {
        parent::__construct();
        
        $this->onlydev();

        $this->cache = new Cached;
    }

    public function index($path)
    {
        $this->clearpath($path);
    }

    public function clearpath($path)
    {
        try {
            
            $parentDirectory = 'web' . DS;
            $cachePath = $path;

            if ($path === 'web') {
                $cachePath = $parentDirectory . 'app';
            }

            if ($path === 'plates') {
                $cachePath = $parentDirectory . 'plates';
            }

            $this->cache->setCachePath($cachePath)->clearAllCache(); //->deleteCacheItem('arrayz'));

            echo $this->success(ucwords($path). " caches pruned successfully");

        } catch (\Exception $e) {
            echo $this->error(ucwords($path) . " caches failed to prune, please check for path permissions");
        }
        
    }

}
