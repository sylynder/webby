<?php

/**
 * Extend CI_Session for Webby
 * 
 * @author Kwame Oteng Appiah-Nti (Developer Kwame)
 * 
 */

namespace Base\Session;


class Session extends \CI_Session
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Force cleanup expired sessions
     * This happens when using session from database
     */
    public function cleanDbSessions()
    {
        if (config_item('sess_driver') != 'database') {
            return;
        }

        $expire = (time() - config_item('sess_expiration'));
        
        get_instance()->load->database();
        get_instance()->db->where("timestamp < {$expire}");
        $delete = get_instance()->db->delete(config_item('sess_save_path'));

        log_message('debug', 'Session garbage collection performed on database.');

        return ($delete) ? true : false;
    }

    /**
     * Force cleanup expired sessions
     * This happens when using session from files
     */
    public function cleanFileSessions()
    {

        $sessionPath = WRITABLEPATH . 'session' . DIRECTORY_SEPARATOR;

        $handle = opendir($sessionPath);

        while (($file = readdir($handle)) !== false) {
            //Leave the directory protection alone
            if ($file == '.htaccess' || $file == 'index.html') {
                continue;
            }

            $lastmodified = filemtime($sessionPath . $file);
            //24 hours in a day * 3600 seconds per hour
            if ((time() - $lastmodified) > config_item('sess_expiration')) {
                @unlink($sessionPath . $file);
            }
        }

        closedir($handle);

        log_message('debug', 'Session garbage collection performed on files.');

        return true;   
    }
}
/* end of file ./engine/Core/Session/Session.php */
