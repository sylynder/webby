<?php
defined('COREPATH') or exit('No direct script access allowed');

class Base_Form_validation extends \CI_Form_validation
{
     public function __construct()
     {
          parent::__construct();
          $this->ci = ci();
     }

     /**
      * Set Rules
      *
      * This function takes an array of field names and validation
      * rules as input, any custom error messages, validates the info,
      * and stores it
      * 
      * Overrides parent::set_rules to validate files
      *
      * @param	mixed	$field
      * @param	string	$label
      * @param	mixed	$rules
      * @param	array	$errors
      * @return	CI_Form_validation
      */
     public function set_rules($field, $label = '', $rules = [], $errors = [])
     {
          if (count($_POST) === 0 and count($_FILES) > 0) //it will prevent the form_validation from working
          {
               // add a dummy $_POST
               $_POST['PLACE_HOLDER'] = '';
               parent::set_rules($field, $label, $rules, $errors);
               unset($_POST['PLACE_HOLDER']);
          } else {
               // we are safe just run as is
               parent::set_rules($field, $label, $rules, $errors);
          }
     }

     /**
      * Run the Validator
      *
      * This function does all the work.
      *
      * Overrides parent::run to validate files
      *
      * @param	string	$group
      * @return	bool
      */
     public function run($group = '')
     {
          $formState = false;

          log_message('debug', 'called Base_Form_validation:run()');
          
          if (count($_POST) === 0 and count($_FILES) > 0) //does it have a file only form?
          {
               // add a dummy $_POST
               $_POST['PLACE_HOLDER'] = '';
               $formState = parent::run($group);
               unset($_POST['PLACE_HOLDER']);
          } else {
               // we are safe just run as is
               $formState = parent::run($group);
          }

          return $formState;
     }
 
     /**
      * Sets the error message associated with a particular field
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
     
     /**
      * To return error message of choice.
      * It will use $msg if it cannot find one in the lang files
      *
      * @param string $message
      * @return string
      */
     public function set_error_message($message)
     {
          $this->CI->lang->load('upload');
          return ($this->CI->lang->line($message) == false) ? $message : $this->CI->lang->line($message);
     }

     public function _execute($row, $rules, $postdata = null, $cycles = 0)
     {
          log_message('debug', 'called Base_Form_validation::_execute ' . $row['field']);

          if (in_array('file_required', $rules) && !in_array('required', $rules) && !isset($_FILES[$row['field']])) {
               $rules[] = 'required';
          }

          if (isset($_FILES[$row['field']])) {

               log_message('debug', 'processing as a file');

               $postdata = $_FILES[$row['field']];

               if (in_array('required', $rules)) {
                    $rules[array_search('required', $rules)] = 'file_required';
               }

               // before doing anything check for errors

               if ($postdata['error'] !== UPLOAD_ERR_OK) {
                    // If the error it's 4 (ERR_NO_FILE) and the file required it's deactivated don't call an error
                    if ($postdata['error'] != UPLOAD_ERR_NO_FILE) {
                         $this->_error_array[$row['field']] = $this->file_upload_error_message($row['label'], $postdata['error']);
                         $this->_field_data[$row['field']]['error'] = $this->file_upload_error_message($row['label'], $postdata['error']);

                         return false;
                    } elseif ($postdata['error'] == UPLOAD_ERR_NO_FILE and in_array('file_required', $rules)) {
                         $this->_error_array[$row['field']] = $this->file_upload_error_message($row['label'], $postdata['error']);
                         $this->_field_data[$row['field']]['error'] = $this->file_upload_error_message($row['label'], $postdata['error']);

                         return false;
                    }
               }

               $_in_array = false;

               // If the field is blank, but NOT required, no further tests are necessary
               $callback = false;
               
               if (!in_array('file_required', $rules) and $postdata['size'] == 0) {
                    // Before we bail out, does the rule contain a callback?
                    if (preg_match("/(callback_\w+)/", implode(' ', $rules), $match)) {
                         $callback = true;
                         $rules = (array('1' => $match[1]));
                    } else {
                         return;
                    }
               }

               foreach ($rules as $rule) {
                    
                    // From original class implementation

                    // Is the rule a callback?		
                    $callback = $callable = false;

                    if (is_string($rule)) {
                         if (strpos($rule, 'callback_') === 0) {
                              $rule = substr($rule, 9);
                              $callback = true;
                         }
                    } elseif (is_callable($rule)) {
                         $callable = true;
                    }

                    // Strip the parameter (if exists) from the rule
                    // Rules can contain a parameter: max_length[5]
                    $param = false;
                    if (!$callable && preg_match('/(.*?)\[(.*)\]/', $rule, $match)) {
                         $rule = $match[1];
                         $param = $match[2];
                    }

                    // Call the function that corresponds to the rule
                    if ($callback or $callable) {
                         if ($callback) {
                              if (! method_exists($this->CI, $rule)) {
                                   log_message('debug', 'Unable to find callback validation rule: ' . $rule);
                                   $result = false;
                              } else {
                                   // Run the function and grab the result
                                   $result = $this->CI->$rule($postdata, $param);
                              }
                         } else {
                              $result = is_array($rule)
                                   ? $rule[0]->{$rule[1]}($postdata, $param)
                                   : $rule($postdata, $param);
                         }

                         // Re-assign the result to the master data array
                         if ($_in_array == true) {
                              $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                         } else {
                              $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                         }

                         // If the field isn't required and we just processed a callback we'll move on...
                         if (!in_array('file_required', $rules, true) and $result !== false) {
                              return;
                         }
                    } elseif (!method_exists($this, $rule)) {
                         // If our own wrapper function doesn't exist we see if a native PHP function does.
                         // Users can use any native PHP function call that has one param.
                         if (function_exists($rule)) {
                              // Native PHP functions issue warnings if you pass them more parameters than they use
                              $result = ($param !== false) ? $rule($postdata, $param) : $rule($postdata);

                              if ($_in_array === true) {
                                   $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                              } else {
                                   $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                              }
                         } else {
                              log_message('debug', 'Unable to find validation rule: ' . $rule);
                              $result = false;
                         }
                    } else {
                         $result = $this->$rule($postdata, $param);

                         if ($_in_array === true) {
                              $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                         } else {
                              $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                         }
                    }

                    // Did the rule test negatively?  If so, grab the error.
                    if ($result === false) {
                         // Check if a custom message is defined
                         if (isset($this->_field_data[$row['field']]['errors'][$rule])) {
                              $line = $this->_field_data[$row['field']]['errors'][$rule];
                         } elseif (!isset($this->_error_messages[$rule])) {
                              if (
                                   false === ($line = $this->CI->lang->line('form_validation_' . $rule))
                                   // DEPRECATED support for non-prefixed keys
                                   && false === ($line = $this->CI->lang->line($rule, false))
                              ) {
                                   $line = 'Unable to access an error message corresponding to your field name.';
                              }
                         } else {
                              $line = $this->_error_messages[$rule];
                         }

                         // Is the parameter we are inserting into the error message the name
                         // of another field? If so we need to grab its "field label"
                         if (isset($this->_field_data[$param], $this->_field_data[$param]['label'])) {
                              $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                         }

                         // Build the error message
                         $message = $this->_build_error_msg($line, $this->_translate_fieldname($row['label']), $param);

                         // Save the error message
                         $this->_field_data[$row['field']]['error'][] = $message;

                         $this->_error_array[$row['field']][] = $message;
                    }
               }
          } else {
               log_message('debug', 'Called parent::_execute');
               parent::_execute($row, $rules, $postdata, $cycles);
          }
     }

     /**
      * File Upload error message
      *
      * @param string|array $field
      * @param mixed $error_code
      * @return string
      */
     public function file_upload_error_message($field, $error_code)
     {
          $param = '';

          switch ($error_code) {
               case UPLOAD_ERR_INI_SIZE:
                    $message = $this->CI->lang->line('error_max_filesize_phpini');
                    break;
               case UPLOAD_ERR_FORM_SIZE:
                    $message = $this->CI->lang->line('error_max_filesize_form');
                    break;
               case UPLOAD_ERR_PARTIAL:
                    $message = $this->CI->lang->line('error_partial_upload');
                    break;
               case UPLOAD_ERR_NO_FILE:
                    $message = $this->CI->lang->line('file_required');
                    break;
               case UPLOAD_ERR_NO_TMP_DIR:
                    $message = $this->CI->lang->line('error_temp_dir');
                    break;
               case UPLOAD_ERR_CANT_WRITE:
                    $message = $this->CI->lang->line('error_disk_write');
                    break;
               case UPLOAD_ERR_EXTENSION:
                    $message = $this->CI->lang->line('error_stopped');
                    break;
               default:
                    return $this->_build_error_msg($this->CI->lang->line('error_unexpected'), $this->_translate_fieldname($field), $param) . $error_code;
          }

          return $this->_build_error_msg($message, $this->_translate_fieldname($field), $param);
     }
     
}
/* end of file ./engine/Core/libraries/Base_Form_validation.php */
