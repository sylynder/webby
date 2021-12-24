<?php

namespace Base\Cache;

class Cache extends \Base_Output
{
    protected $ci;

    private $thisDirectory = 'files';

    /**
     * Number of seconds that a 
     * cached item will be considered current
     *
     * @var integer
     */
    public $expireAfter = 1800;


    public function __construct()
    {
        parent::__construct();

        $this->ci =& get_instance();
    }

    /* ----------------------------- For Custom Caching and Retrieving ---------------------- */

    // Credit https://github.com/colettesnow/Simple-Cache-for-CodeIgniter

	/**
	 * Caches an item which can be retrieved by key
	 *
	 * @param string $key identitifer to retrieve the data later
	 * @param mixed $value to be cached
	 */
    public function cacheItem($key, $value = null)
	{
        if (is_string($key) && $value !== null) {
            $this->setCacheItem($key, $value);
            return true;
        }

        if ($this->isCached($key)) {
            return $this->getCacheItem($key);
        }
        
        return null;
	}   

    /**
     * Set Custom Path
     *
     * @param string $path
     * @return string
     */
    public function setCachePath($path = '')
    {
        if ($this->customPath == $this->defaultPath) {
            $this->customPath = $this->thisDirectory;
        }

        if (!empty($path)) {
            $this->customPath = $path;
        }

        $this->customPath;

        return $this;
    }

	/**
	 * Check's whether an item is cached or not
	 *
	 * @param string $key containing the identifier of the cached item
	 * @return bool whether the item is currently cached or not
	 */
	public function isCached($key)
	{
		$key = sha1($key);

        $this->setCachePath(); // Set the correct cache path

        $cachePath = $this->filesCachePath();
        
        // checks if the cached item exists and that it has not expired.
        $fileExpires = file_exists($cachePath .$key. '.cache') 
                            ? (filectime($cachePath .$key. '.cache') + $this->expireAfter)
                            : (time() - 10);

        return ($fileExpires >= time()) ? true : false;
	}

    public function setCacheItem($key, $value)
    {
        $this->setCachePath(); // Set the correct cache path

        $cachePath = $this->filesCachePath();

        // hashing the key in order to ensure that the item
        // is stored with an appropriate file name in the file system.
        $key = sha1($key);

        // serializes the contents so that they can be stored in plain text
        $value = serialize($value);

        try { 
            file_put_contents($cachePath . $key . '.cache', $value);
        } catch(\Exception $e) {
            log_message('error', $e->message);
        }

    }

	/**
	 * Retrieve's the cached item
	 *
	 * @param string $key containing the identifier of the item to retrieve
	 * @return mixed the cached item or items
	 */
    public function getCacheItem($key)
	{
        $this->setCachePath(); // Set the correct cache path

        $cachePath = $this->filesCachePath();

		$key = sha1($key);

        $exists = file_exists($cachePath . $key . '.cache');

        if (!$exists) {
            return false;
        }

		$item = file_get_contents($cachePath .$key. '.cache');
		$items = unserialize($item);

		return $items;
	}

	/**
	 * Delete's the cached item
	 *
	 * @param string $key containing the identifier of the item to delete.
	*/
    public function deleteCacheItem($key)
	{
        $this->setCachePath(); // Set the correct cache path

        $cachePath = $this->filesCachePath();

		@unlink($cachePath .sha1($key). '.cache');

        return true;
	}

    /* ----------------------------- For Checking and Pruning Cached Files ---------------------- */

    /**
     * Clears the cache for the specified path
     * @param string $uri The URI path
     * @return bool true if successful, false if not
     */
    public function clearPathCache($uri = '')
    {

        $cachePath = $this->filesCachePath();

        if (empty($uri)) {
            $uri = $this->ci->config->item('base_url') .
            $this->ci->config->item('index_page') .
            $uri;
        }

        $cachePath .= md5($uri);

        return @unlink($cachePath);
    }

    /**
     * Clears all cache from a cache directory
     */
    public function clearAllCache()
    {

        $cachePath = $this->filesCachePath();;

        $handle = opendir($cachePath);

        while (($file = readdir($handle)) !== false) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cachePath . '/' . $file);
            }
        }

        closedir($handle);
    }

    /**
     * Checks to see if a cache file exists for the specified path
     * @param string $uri The URI path to check
     * @return bool true if it is, false if not
     */
    public function pathCached($uri = '')
    {
        $cachePath = $this->filesCachePath();

        if (empty($uri)) {
            $uri = $this->ci->config->item('base_url') .
            $this->ci->config->item('index_page') .
            $uri;
        }

        $cachePath .= md5($uri);

        return file_exists($cachePath);
    }

    /**
     * Returns the cache expiration timestamp for the specified path
     * @param string $uri The URI path to check
     * @return int|boolean The expiration Unix timestamp or false if there is no cache
     */
    public function getPathCacheExpiration($uri, $readableDate = false)
    {
        $cachePath = $this->filesCachePath();

        if ((empty($uri))) {
            $uri = $this->ci->config->item('base_url') .
            $this->ci->config->item('index_page') .
            $uri;
        }
        
        $cachePath .= md5($uri);
        
        if (!$fp = @fopen($cachePath, FOPEN_READ)) {
            return false;
        }

        flock($fp, LOCK_SH);

        $cache = '';
        
        if (filesize($cachePath) > 0) {
            $cache = fread($fp, filesize($cachePath));
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        $searchTimestamp = substr($cache, 0, 31);
        
        // Strip out the embedded timestamp
        $timestamp = str_replace([':', ';', ' '], '', substr($searchTimestamp, 19));

        // Strip out the embedded timestamp
        if (empty($timestamp)) {
            return false;
        }

        // Return the timestamp
        return ($readableDate) ? date('d/m/Y H:i:s', $timestamp) : (int)trim($timestamp);
    }

    /* ----------------------------- Specific For Cached Web Views ---------------------- */

    /**
     * Write Cache for web pages
     *
     * @param	string	$output	Output data to cache
     * @return mixed
     */
    public function writeWebCache(string $output)
    {
        return parent::_write_cache($output);
    }

    /**
     * Delete cache for web pages
     *
     * @param	string	$uri	URI string
     * @return	bool
     */
    public function deleteWebCache(string $uri = '') : bool
    {
        return parent::delete_cache($uri);
    }

}
