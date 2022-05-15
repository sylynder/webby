<?php

/**
 * A CRUD Action
 * 
 * mostly to assist CRUD Based functionalities
 */

namespace Base\Actions;

abstract class CrudAction extends Action
{

    /**
     * Use to load database
     *
     * @return void
     */
    protected function useDatabase()
    {
        // Load the CodeIgniter Database 
        // Object from here i.e $this->db
        $this->load->database();
    }

    /**
     * The model method 
     * 
     * Will be implemented in child classes
     *
     * @return object
     */
    abstract public function model();

}
