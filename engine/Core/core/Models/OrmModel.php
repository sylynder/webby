<?php

/**
 * An Orm Model to provide basic actions
 * for all models that inherit from it
 * 
 * This Model with have the most complex
 * of functionalities to allow database
 * manipulations in a more specific
 * way 
 * 
 * @author  Oteng Kwame Appiah-Nti <developerkwame@gmail.com> (Developer Kwame)
 * @license MIT
 * @link    <link will be here>
 * @version 1.0
 */

namespace Base\Models;

class OrmModel extends Model
{
    /**
     * Construct the CI_Model
     */
    public function __construct()
    {
        parent::__construct();
    }
}
/* end of file Core/core/Models/Model.php */