<?php
defined('COREPATH') or exit('No direct script access allowed');

class Base_Session extends \CI_Session
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
        if ($this->sess_use_database != true) {
            return;
        }

        $expire = ($this->now - $this->sess_expiration);

        get_instance()->db->where("last_activity < {$expire}");
        get_instance()->db->delete($this->sess_table_name);

        log_message('debug', 'Session garbage collection performed.');
    }

    /**
     * Force cleanup expired sessions
     * This happens when using session from files
     */
    public function cleanFileSessions()
    {

    }
}
/* end of file ./engine/Core/libraries/Base_Session.php */
