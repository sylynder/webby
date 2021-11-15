<?php 
defined('COREPATH') or exit('No direct script access allowed');

class Base_Output extends \CI_Output
{
    /**
     * Default Path
     *
     * @var string
     */
    protected $defaultPath = 'web/app';

    /**
     * Custom path
     *
     * @var string
     */
    public $customPath = '';

	public function __construct()
	{
		parent::__construct();

        $this->customPath = $this->defaultPath; // set to default path
	}

    /**
     * Use custom cache path
     *
     * @return void
     */
    private function cacheCustomPath()
    {
        $ci =& get_instance();
        return $ci->config->item('cache_path') . $this->customPath . DIRECTORY_SEPARATOR;
    }

    public function filesCachePath()
    {
        $ci =& get_instance();
        $cachePath = (!empty($this->customPath)) ? $this->customPath : $this->defaultPath;
        return $ci->config->item('cache_path') . $cachePath . DIRECTORY_SEPARATOR;
    }

    /**
     * Write Cache
     *
     * @param	string	$output	Output data to cache
     * @return	void
     */
    public function _write_cache($output)
    {
        
        $ci =& get_instance();
        
        $path = $ci->config->item('web_cache_path');
        $cachePath = ($path === '') ? $ci->config->item('cache_path') . $this->defaultPath . DIRECTORY_SEPARATOR : rtrim($path, '/\\') . DIRECTORY_SEPARATOR;

        if (!is_dir($cachePath) or !is_really_writable($cachePath)) {
            log_message('error', 'Unable to write cache file: ' . $cachePath);
            return;
        }

        if ($ci->config->item('enable_custom_cache')) {
            $cachePath = $this->cacheCustomPath();
        }

        $uri = $ci->config->item('base_url')
                . $ci->config->slash_item('index_page')
                . $ci->uri->uri_string();

        if (($cacheQueryString = $ci->config->item('cache_query_string')) && !empty($_SERVER['QUERY_STRING'])) {
            if (is_array($cacheQueryString)) {
                $uri .= '?' . http_build_query(array_intersect_key($_GET, array_flip($cacheQueryString)));
            } else {
                $uri .= '?' . $_SERVER['QUERY_STRING'];
            }
        }

        $cachePath .= md5($uri);

        if (!$fp = @fopen($cachePath, 'w+b')) {
            log_message('error', 'Unable to write cache file: ' . $cachePath);
            return;
        }

        if (!flock($fp, LOCK_EX)) {
            log_message('error', 'Unable to secure a file lock for file at: ' . $cachePath);
            fclose($fp);
            return;
        }

        // If output compression is enabled, compress the cache
        // itself, so that we don't have to do that each time
        // we're serving it
        if ($this->_compress_output === true) {
            $output = gzencode($output);

            if ($this->get_header('content-type') === NULL) {
                $this->set_content_type($this->mime_type);
            }
        }

        $expire = time() + ($this->cache_expiration * 60);

        // Put together our serialized info.
        $cache_info = serialize([
            'expire'    => $expire,
            'headers'    => $this->headers
        ]);

        $output = $cache_info . 'ENDCI--->' . $output;

        $result = null;

        for ($written = 0, $length = self::strlen($output); $written < $length; $written += $result) {
            if (($result = fwrite($fp, self::substr($output, $written))) === false) {
                break;
            }
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        if (!is_int($result)) {
            @unlink($cachePath);
            log_message('error', 'Unable to write the complete cache content at: ' . $cachePath);
            return;
        }

        chmod($cachePath, 0640);
        log_message('debug', 'Cache file written: ' . $cachePath);

        // Send HTTP cache-control headers to browser to match file cache settings.
        $this->set_cache_header($_SERVER['REQUEST_TIME'], $expire);
    }

    // --------------------------------------------------------------------

    /**
     * Update/serve cached output
     *
     * @uses	CI_Config
     * @uses	CI_URI
     *
     * @param	object	&$CFG	CI_Config class instance
     * @param	object	&$URI	CI_URI class instance
     * @return	bool	true on success or false on failure
     */
    public function _display_cache(&$CFG, &$URI)
    {
        $cachePath = ($CFG->item('web_cache_path') === '') ? $this->defaultPath : $CFG->item('web_cache_path');

        if ($CFG->item('enable_custom_cache')) {
            $cachePath = $this->cacheCustomPath();
        } 

        // Build the file path. The file name is an MD5 hash of the full URI
        $uri = $CFG->item('base_url') . $CFG->slash_item('index_page') . $URI->uri_string;

        if (($cache_query_string = $CFG->item('cache_query_string')) && !empty($_SERVER['QUERY_STRING'])) {
            if (is_array($cache_query_string)) {
                $uri .= '?' . http_build_query(array_intersect_key($_GET, array_flip($cache_query_string)));
            } else {
                $uri .= '?' . $_SERVER['QUERY_STRING'];
            }
        }

        $filepath = $cachePath . md5($uri);

        if (!file_exists($filepath) or !$fp = @fopen($filepath, 'rb')) {
            return false;
        }

        flock($fp, LOCK_SH);

        $cache = (filesize($filepath) > 0) ? fread($fp, filesize($filepath)) : '';

        flock($fp, LOCK_UN);
        fclose($fp);

        // Look for embedded serialized file info.
        if (!preg_match('/^(.*)ENDCI--->/', $cache, $match)) {
            return false;
        }

        $cache_info = unserialize($match[1]);
        $expire = $cache_info['expire'];

        $last_modified = filemtime($filepath);

        // Has the file expired?
        if ($_SERVER['REQUEST_TIME'] >= $expire && is_really_writable($cachePath)) {
            // If so we'll delete it.
            @unlink($filepath);
            log_message('debug', 'Cache file has expired. File deleted.');
            return false;
        }

        // Send the HTTP cache control headers
        $this->set_cache_header($last_modified, $expire);

        // Add headers from cache file.
        foreach ($cache_info['headers'] as $header) {
            $this->set_header($header[0], $header[1]);
        }

        // Display the cache
        $this->_display(self::substr($cache, self::strlen($match[0])));
        log_message('debug', 'Cache file is current. Sending it to browser.');
        return true;
    }

    /**
     * Delete cache
     *
     * @param	string	$uri	URI string
     * @return	bool
     */
    public function delete_cache($uri = '')
    {
        $ci = &get_instance();
        
        $cachePath = $this->filesCachePath();

        if ($ci->config->item('enable_custom_cache')) {
            $cachePath = $this->cacheCustomPath();
        }
        
        if (!is_dir($cachePath)) {
            log_message('error', 'Unable to find cache path: ' . $cachePath);
            return false;
        }

        if (empty($uri)) {
            $uri = $ci->uri->uri_string();

            if (($cache_query_string = $ci->config->item('cache_query_string')) && !empty($_SERVER['QUERY_STRING'])) {
                if (is_array($cache_query_string)) {
                    $uri .= '?' . http_build_query(array_intersect_key($_GET, array_flip($cache_query_string)));
                } else {
                    $uri .= '?' . $_SERVER['QUERY_STRING'];
                }
            }

            $uri = md5($ci->config->item('base_url') . $ci->config->slash_item('index_page') . ltrim($uri, '/'));
        }

        $cachePath .= $uri;

        if (!@unlink($cachePath)) {
            log_message('error', 'Unable to delete cache file for ' . $uri);
            return false;
        }

        return true;
    }
}
/* end of file Base_Output.php */
