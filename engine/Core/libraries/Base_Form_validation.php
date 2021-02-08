<?php 
defined('COREPATH') OR exit('No direct script access allowed');
 
class Base_Form_validation extends \CI_Form_validation
{
   function __construct()
   {
        parent::__construct();
        $this->ci = ci();
   }
 
   /**
   * sets the error message associated with a particular field
   *
   * @param   string  $field  Field name
   * @param   string  $error  Error message
   * used in controller like this: 
   * $this->form_validation->set_error('username', 'Invalid username credential');
   * added from: https://stackoverflow.com/a/35165483
   */
   public function set_error(string $field, string $error)
   {
        $this->_error_array[$field] = $error;
   }

}
/* end of file ./engine/Core/libraries/Base_Form_validation.php */
