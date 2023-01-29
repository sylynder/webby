<?php
defined('COREPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Configure Json Database Root Path
| -------------------------------------------------------------------------
| This path is where you will store
| All your JSON Database files
|
 */

$config['json_db_path'] = (getenv('database.json.path')) 
    ? ROOTPATH . getenv('database.json.path') 
    : WRITABLEPATH . 'jsondb' . DS . 'storage';
