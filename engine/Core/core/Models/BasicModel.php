<?php

namespace Base\Models;

class BasicModel extends Model {

    /**
     * The model's default table.
     *
     * @var string;
     */
    protected $table;

    /**
     * The model's default primary key.
     *
     * @var string
     */
    protected $primary_key = 'id';

    /**
     * Field name to use for created time column in the DB table.
     *
     * @var string
     * @access protected
     */
    protected $created_field = 'created_at';

    /**
     * Field name to use for modified time column in the DB table.
     *
     * @var string
     * @access protected
     */
    protected $updated_field = 'updated_at';

    /**
     * Whether or not to auto-fill a 'created_at' field on inserts.
     *
     * @var boolean
     * @access protected
     */
    protected $set_created_at  = true;

    /**
     * Whether or not to auto-fill a 'updated_at' field on updates.
     *
     * @var boolean
     * @access protected
     */
    protected $set_updated_at = true;

    /**
     * 
     * If true, will log user id 
     * for 'created_by', 'updated_by' and 'deleted_by'.
     *
     * @var boolean
     */
    protected $log_user = true;

    /**
     * The user id to use when logging user.
     *
     * @var string
     */
    public $user_id = '';

    /**
     * Field name to use for created_by 
     * column in the DB table
     *
     * @var string
     */
    protected $created_by_field = 'created_by';

    /**
     * Field name to use for the update_by 
     * column in the DB table
     *
     * @var string
     */
    protected $updated_by_field = 'updated_by';

    /**
     * Field name to use for the deleted_by 
     * column in the DB table.
     *
     * @var string
     */
    protected $deleted_by_field = 'deleted_by';

    /**
     * The type of date/time field used for created_at and update_at fields.
     * Valid types are: 'int', 'datetime', 'date'
     *
     * @var string
     * @access protected
     */
    protected $date_format = 'datetime';

    /**
     * Support for soft_deletes.
     */
    protected   $soft_deletes       = false;
    protected   $soft_delete_key    = 'is_deleted';
    protected   $temp_with_deleted  = false;

    /**
     * Various callbacks available to the class. They are simple lists of
     * method names (methods will be ran on $this).
     */
    protected $before_insert = [];
    protected $after_insert = [];
    protected $before_update = [];
    protected $after_update = [];
    protected $before_find = [];
    protected $after_find = [];
    protected $before_delete = [];
    protected $after_delete = [];

    protected $callback_parameters  = [];

    /**
    * Protected, non-modifiable attributes
    *
    * @var array
    */
    protected $protected_attributes = [];

    /**
     * Sets fillable fields.
     * If value is set as null, the $fillable property will be set as an array 
     * with all the table fields (except the primary key) as elements.
     * If value is set as an array, there won't be any changes 
     * done to it (ie: no field of the table will be updated or inserted).
     * 
     * @var null|array
     */
    public $fillable = null;
    
    /**
     * Sets protected fields.
     * If value is set as null, the $guard will be set as an array with the primary key 
     * as single element. If value is set as an array, there won't be any changes done 
     * to it (if set as empty array, the primary key won't be inserted here).
     * 
     * @var null|array
     */
    public $protected = null;

    /**
     * An array of validation rules. This needs to be the same format
     * as validation rules passed to the Form_validation library.
     *
     * You can override this value into a string that is the name
     * of a rule group, if you've saved the rules array into
     * a config file as described in the CodeIgniter User Guide.
     * http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#savingtoconfig
     */
    protected $validation_rules = [];

    /**
     * An array of rules to be added to the validation rules during
     * insert type methods. This is commonly used to add a required rule
     * that is only needed during inserts and not updates. The array
     * requires the field_name as the key and the additional rules
     * as the value string.
     *
     *      array(
     *          'password' => 'required|matches[password]',
     *          'username' => 'required'
     *      )
     */
    protected $insert_validation_rules = [];

    /**
     * Optionally skip the validation. Used in conjunction with
     * skip_validation() to skip data validation for any future calls.
     */
    protected $skip_validation = false;

    /**
     * By default, we return items as objects. You can change this for the
     * entire class by setting this value to 'array' instead of 'object'.
     * Alternatively, you can do it on a per-instance basis using the
     * 'as_array()' and 'as_object()' methods.
     */
    protected $return_as      = 'object';
    protected $temp_return_type = null;
	
	/**
     * If the return type is object , one can specify 
     * a custom class representing the data to rather 
     * be created and returned as the stdClass object
     *
     * @var string
     */
    protected $custom_return_object = '';
    
    /**
     * 
     * If TRUE, inserts will return the last_insert_id. However,
     * this can potentially slow down large imports drastically
     * so you can turn it off with the return_insert_id(false) method.
     * This will simply return TRUE, instead.
     * 
     * IMPORTANT: Turning this to false will bypass any after_insert
     * trigger events.
     * 
     * @var boolean
     */
    protected $return_insert_id = true;

    /**
     * The database connection to use for all write-type calls
    *
    * @var mixed
    */
    protected $dbw;

    /**
     * The database connection to use for all read-type calls.
     *
     * @var mixed
     */
    protected $dbr;

    //--------------------------------------------------------------------


    /**
     * Gets our model up and running.
     *
     * You can provide your own connections for read and/or write databases
     * by passing them in the constructor.
     *
     * @param DB object $write_db A CI_DB connection.
     * @param DB object $read_db A CI_DB connection.
     */
    public function __construct(&$write_db=null, &$read_db=null)
    {
        // Always protect our attributes
        array_unshift($this->before_insert, 'protect_attributes');
        array_unshift($this->before_update, 'protect_attributes');

        // Check our auto-set features and make sure they are part of
        // our observer system.
        if ($this->set_created_at === true) array_unshift($this->before_insert, 'created_at');
        if ($this->set_updated_at === true) array_unshift($this->before_update, 'updated_at');

        // Make sure our temp return type is correct.
        $this->temp_return_type = $this->return_as;

        /*
            Passed DB connections?
        */
        if (is_object($write_db)) {
            $this->dbw = $write_db;
        }

        if (is_object($read_db)) {
            $this->dbr = $read_db;
        }

        /*
            Make sure we have a dbw and a dbr to use.

            Start with the writeable db. If we don't have
            one (passed in) then try to use the global $this->db
            object, if exists. Otherwise, load the database
            and then use $this->db
         */
        if ( ! isset($this->db)) {
            $this->load->database();
        }

        if ( ! is_object($this->dbw)) {
            $this->dbw = $this->db;
        }

        // If there's no read db, use the write db.
        if ( ! is_object($this->dbr)) {
            $this->dbr = $this->dbw;
        }

        log_message('debug', 'BasicModel Class Initialized');
        // parent::__construct();
    }

    //------------------ CRUD Functionalities --------------------------------------------------

    /**
     * A simple way to grab the first result of a search only.
     */
    public function first()
    {
        $rows = $this->limit(1)->findAll();

        if (is_array($rows) && count($rows) == 1)
        {
            return $rows[0];
        }

        return $rows;
    }

    /**
     * Finds a single record based on it's primary key. Will ignore deleted rows.
     *
     * @param  mixed $id The primary_key value of the object to retrieve.
     * @return object
     */
    public function find($id)
    {
        $this->trigger('before_find');

        // Ignore any soft-deleted rows
        if ($this->soft_deletes && $this->temp_with_deleted !== true)
        {
            $this->dbr->where($this->table.'.'.$this->soft_delete_key, false);
        }

        $this->dbr->where($this->table.'.'.$this->primary_key, $id);
        $row = $this->dbr->get($this->table);
        $row = $this->return_data($row);
		  

        $row = $this->trigger('after_find', $row);

        if ($this->temp_return_type == 'json')
        {
            $row = json_encode($row);
        }

        // Reset our return type
        $this->temp_return_type = $this->return_as;

        return $row;
    }

    /**
     * Fetch a single record based on an arbitrary WHERE call. Can be
     * any valid value to $this->db->where(). Will not pull in deleted rows
     * if using soft deletes.
     *
     * @return object
     */
    public function findBy()
    {
        $where = func_get_args();
        $this->set_where($where, 'dbr');

        // Ignore any soft-deleted rows
        if ($this->soft_deletes && $this->temp_with_deleted !== true)
        {
            $this->dbr->where($this->soft_delete_key, false);
        }

        $this->trigger('before_find');

        $row = $this->dbr->get($this->table);
        $row = $this->return_data($row);

        $row = $this->trigger('after_find', $row);

        if ($this->temp_return_type == 'json')
        {
            $row = json_encode($row);
        }

        // Reset our return type
        $this->temp_return_type = $this->return_as;

        return $row;
    }

    /**
     * Retrieves a number of items based on an array of primary_values passed in.
     *
     * @param  array $values An array of primary key values to find.
     *
     * @return object or FALSE
     */
    public function findMany($values)
    {
        $this->dbr->where_in($this->primary_key, $values);

        return $this->findAll();
    }

    /**
     * Retrieves a number of items based on an arbitrary WHERE call. Can be
     * any set of parameters valid to $db->where.
     *
     * @return object or FALSE
     */
    public function findByMany()
    {
        $where = func_get_args();
        $this->set_where($where, 'dbr');

        return $this->findAll();
    }

    /**
     * Fetch all of the records in the table. Can be used with scoped calls
     * to restrict the results.
     *
     * @return object or FALSE
     */
    public function findAll()
    {
        $this->trigger('before_find');

        // Ignore any soft-deleted rows
        if ($this->soft_deletes && $this->temp_with_deleted !== true)
        {
            $this->dbr->where($this->table.'.'.$this->soft_delete_key, false);
        }

        $rows = $this->db->get($this->table);
        $rows = $this->return_data($rows,true);

        if (is_array($rows))
        {
            foreach ($rows as $key => &$row)
            {
                $row = $this->trigger('after_find', $row, ($key == count($rows) - 1));
            }
        }

        if ($this->temp_return_type == 'json')
        {
            $rows = json_encode($rows);
        }

        // Reset our return type
        $this->temp_return_type = $this->return_as;

        return $rows;
    }

    /**
     * Alias function to findAll()
     *
     * @return object or FALSE
     */
    public function all()
    {
        return $this->findAll();
    }

    /**
     * Inserts data into the database.
     *
     * @param  array $data An array of key/value pairs to insert to database.
     *
     * @return mixed The primary_key value of the inserted record, or FALSE.
     */
    public function insert($data)
    {
        $data = $this->trigger('before_insert', $data);

        if ($this->skip_validation === false)
        {
            $data = $this->validate($data, 'insert');

            // If $data is false, we didn't validate
            // so we need to get out of here.
            if ( ! $data)
            {
                return false;
            }
        }

        if($this->set_created_at and empty($data[$this->created_field]))
        {
            $data[$this->created_field] = $this->set_date();
        }

        if($this->log_user)
        {
            $data[$this->created_by_field] = $this->set_user();
        }

        $this->dbw->insert($this->table, $data);

        if ($this->return_insert_id)
        {
            $id = $this->dbw->insert_id();

            $this->trigger('after_insert', $id);
        }
        else
        {
            $id = true;
        }

        return $id;
    }

    /**
     * Alias for insert() function
     *
     * @param array $data
     * @return mixed the primary_key value of the inserted record, or FALSE.
     */
    public function save($data)
    {
        return $this->insert($data);
    }

    /**
     * Inserts multiple rows into the database at once. Takes an associative
     * array of value pairs.
     *
     * $data = array(
     *     array(
     *         'title' => 'My title'
     *     ),
     *     array(
     *         'title'  => 'My Other Title'
     *     )
     * );
     *
     * @param  array $data An associate array of rows to insert
     *
     * @return bool
     */
    public function insertBatch($data)
    {
        if ($this->skip_validation === false)
        {
            $data = $this->validate($data, 'insert');
            if ( ! $data)
            {
                return false;
            }
        }

        $data['batch'] = true;
        $data = $this->trigger('before_insert', $data);

        if ($this->set_created_at === false) {
            unset($data['created_at']);
        }

        unset($data['batch']);
 
        return $this->dbw->insert_batch($this->table, $data);
    }
    
    /**
     * Updates an existing record in the database.
     *
     * @param  mixed $id   The primary_key value of the record to update.
     * @param  array $data An array of value pairs to update in the record.
     * @return bool
     */
    public function update($id, $data)
    {
        $data = $this->trigger('before_update', $data);

        if ($this->skip_validation === false)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return false;
            }
        }

        $this->dbw->where($this->primary_key, $id);

        if ($this->log_user)
        {
            $data[$this->updated_by_field] = $this->set_user();
        }

        $this->dbw->set($data);

        $result = $this->dbw->update($this->table);

        $this->trigger('after_update', array($data, $result));

        return $result;
    }

    /**
     * Updates multiple records in the database at once.
     *
     * $data = array(
     *     array(
     *         'title'  => 'My title',
     *         'body'   => 'body 1'
     *     ),
     *     array(
     *         'title'  => 'Another Title',
     *         'body'   => 'body 2'
     *     )
     * );
     *
     * The $where_key should be the name of the column to match the record on.
     * If $where_key == 'title', then each record would be matched on that
     * 'title' value of the array. This does mean that the array key needs
     * to be provided with each row's data.
     *
     * @param  array $data      An associate array of row data to update.
     * @param  string $where_key The column name to match on.
     * @return bool
     */
    public function updateBatch($data, $where_key)
    {
        foreach ($data as &$row)
        {
            $row = $this->trigger('before_update', $row);
        }

        $result = $this->dbw->update_batch($this->table, $data, $where_key);

        foreach ($data as &$row)
        {
            $this->trigger('after_update', array($row, $result));
        }

        return $result;
    }

    /**
     * Updates many records by an array of ids.
     *
     * While updateBatch() allows modifying multiple, arbitrary rows of data
     * on each row, updateMany() sets the same values for each row.
     *
     * $ids = array(1, 2, 3, 5, 12);
     * $data = array(
     *     'deleted_by' => 1
     * );
     *
     * $this->model->updateMany($ids, $data);
     *
     * @param  array $ids  An array of primary_key values to update.
     * @param  array $data An array of value pairs to modify in each row.
     * @return bool
     */
    public function updateMany($ids, $data)
    {
        $data = $this->trigger('before_update', $data);

        if ($this->skip_validation === false)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return false;
            }
        }

        $this->dbw->where_in($this->primary_key, $ids);
        
        if ($this->log_user)
        {
            $data[$this->updated_by_field] = $this->set_user();
        }

        $this->dbw->set($data);
        $result = $this->dbw->update($this->table);

        $this->trigger('after_update', array($data, $result));

        return $result;
    }
    
    /**
     * Update records in the database using a standard WHERE clause.
     *
     * Your last parameter should be the $data array with values to update
     * on the rows. Any additional parameters should be provided to make up
     * a typical WHERE clause. This could be a single array, or a column name
     * and a value.
     *
     * $data = array('deleted_by' => 1);
     * $wheres = array('user_id' => 15);
     *
     * $this->updateBy($wheres, $data);
     * $this->updateBy('user_id', 15, $data);
     *
     * @param array $data An array of data pairs to update
     * @param one or more WHERE-acceptable entries.
     * @return bool
     */
    public function updateBy()
    {
        $args = func_get_args();
        $data = array_pop($args);
        $this->set_where($args, 'dbw');

        $data = $this->trigger('before_update', $data);

        if ($this->skip_validation === false)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return false;
            }
        }

        if ($this->log_user)
        {
            $data[$this->updated_by_field] = $this->set_user();
        }

        $this->dbw->set($data);
        $result = $this->dbw->update($this->table);

        $this->trigger('after_update', array($data, $result));

        return $result;
    }

    /**
     * Updates all records and sets the value pairs passed in the array.
     *
     * @param  array $data An array of value pairs with the data to change.
     * @return bool
     */
    public function updateAll($data)
    {
        $data = $this->trigger('before_update', $data);

        if ($this->skip_validation === false)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return false;
            }
        }

        if ($this->log_user)
        {
            $data[$this->updated_by_field] = $this->set_user();
        }

        $this->dbw->set($data);
        $result = $this->dbw->update($this->table);

        $this->trigger('after_update', array($data, $result));

        return $result;
    }

    /**
     * Deletes a row by it's primary key value.
     *
     * @param  mixed $id The primary key value 
     * of the row to delete.
     * @return bool
     */
    public function delete($id)
    {
        $this->trigger('before_delete', $id);

         $this->dbw->where($this->primary_key, $id);

        if ($this->soft_deletes)
        {
            $sets = $this->log_user ? array($this->soft_delete_key => 1, $this->deleted_by_field => $this->set_user()) : array($this->soft_delete_key => 1);

            $result = $this->dbw->update($this->table, $sets);
        }

        // Hard Delete
        else {
            $result = $this->dbw->delete($this->table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    /**
     * Deletes a row by using the where clause
     * @param array $data An array of data pairs to update
     * @return bool
     */
    public function deleteBy()
    {
        $where = func_get_args();
        $this->set_where($where, 'dbw');

        $where = $this->trigger('before_delete', $where);

        if ($this->soft_deletes)
        {
            $sets = $this->log_user ? array($this->soft_delete_key => 1, $this->deleted_by_field => $this->set_user()) : array($this->soft_delete_key => 1);

            $result = $this->dbw->update($this->table, $sets);
        }
        else
        {
            $result = $this->dbw->delete($this->table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    /**
     * A convenience method to delete many rows 
     * of data when you have an
     * array of id's to delete. The same thing as:
     *
     *      $this->model->where_in($ids)->delete();
     *
     * @param  array $ids An array of primary 
     * keys to be deleted.
     */
    public function deleteMany($ids)
    {
        $ids = $this->trigger('before_delete', $ids);

        $this->dbw->where_in($ids);

        if ($this->soft_deletes)
        {
            $sets = $this->log_user ? array($this->soft_delete_key => 1, $this->deleted_by_field => $this->auth->user_id()) : array($this->soft_delete_key => 1);

            $result = $this->dbw->update($this->table, $sets);
        }
        else
        {
            $result = $this->dbw->delete($this->table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    /**
     * Empty a table.
     *
     * @param $table String Table name.
     * @return mixed
     */
    public function truncateTable($table = null)
    {
        return $this->db->empty_table($table);
    }

    //------------------ Scoped Functionalities --------------------------------------------------

    /**
     * Sets the value of the soft deletes flag.
     *
     * @param boolean $value $val If TRUE, should perform 
     * a soft delete. If FALSE, a hard delete.
     * @return object
     */
    public function softDelete($value = true)
    {
        $this->soft_deletes = $value;

        return $this;
    }

    /**
     * Temporarily sets our return type to an array.     
     * 
     * @return object
     */
    public function asArray()
    {
        $this->temp_return_type = 'array';

        return $this;
    }

    /**
     * Temporarily sets our return type to an object
    *
    * @return object
    */
    public function asObject()
    {
        $this->temp_return_type = 'object';

        return $this;
    }

    /**
     * Temporarily sets our object return to a json object.
    *
    * @return object
    */
    public function asJson()
    {
        $this->temp_return_type = 'json';

        return $this;
    }

    /**
     * Also fetches deleted items for this request only.
     * 
     * @return object
     */
    public function withDeleted()
    {
        $this->temp_with_deleted = TRUE;

        return $this;
    }

    /**
     * Sets the value of the skip_validation flag
     *
     * @param boolean $skip (optional) whether to 
     * skip validation in the model
     *
     * @return object    returns $this to 
     * allow method chaining
     */
    public function skipValidation($skip=TRUE)
    {
        $this->skip_validation = $skip;

        return $this;
    }

    //------------------ Utility Functionalities --------------------------------------------------

    /**
     * Counts number of rows modified by 
     * an arbitrary WHERE call.
     *
     * @param boolean $value
     * @return int
     */
    public function countBy()
    {
        $where = func_get_args();
        $this->set_where($where, 'dbr');

        return $this->dbr->count_all_results($this->table);
    }

    /**
     * Counts total number of records, disregarding 
     * any previous conditions.
     *
     * @return int
     */
    public function countAll()
    {
        return $this->dbr->count_all($this->table);
    }

    /**
     * Getter for the table name.
     *
     * @return string The name of the table used by this class.
     */
    public function table()
    {
        return $this->table;
    }

    /**
     * A convenience method to return options for form dropdown menus.
     *
     * Can pass either Key ID and Label Table names or Just Label Table name.
     *
     * @return array The options for the dropdown.
     */
    public function formatDropdown()
    {
        $args = func_get_args();

        if (count($args) == 2)
        {
            list($key, $value) = $args;
        }
        else
        {
            $key = $this->primary_key;
            $value = $args[0];
        }

        $query = $this->dbr->select(array($key, $value))->get($this->table);

        $options = array();
        foreach ($query->result() as $row)
        {
            $options[$row->{$key}] = $row->{$value};
        }

        return $options;

    }

    /**
     * A convenience method to return only a single field of the specified row.
     *
     * @param mixed  $id    The primary_key value to match against.
     * @param string $field The field to search for.
     *
     * @return bool|mixed The value of the field.
     */
    public function getField($id=null, $field='')
    {
        $this->dbr->select($field);
        $this->dbr->where($this->primary_key, $id);
        $query = $this->dbr->get($this->table);

        if ($query && $query->num_rows() > 0)
        {
            return $query->row()->$field;
        }

        return FALSE;

    }

    /**
     * Checks whether a field/value pair exists within the table.
     *
     * @param string $field The field to search for.
     * @param string $value The value to match $field against.
     *
     * @return bool TRUE/FALSE
     */
    public function isUnique($field, $value)
    {
        $this->dbr->where($field, $value);
        $query = $this->dbr->get($this->table);

        if ($query && $query->num_rows() == 0)
        {
            return true;
        }

        return false;

    }

    //------------------ Observers Functionalities --------------------------------------------------
    
    /**
     * Sets the created on date for the object based on the
     * current date/time and date_format. Will not overwrite existing.
     *
     * @param array  $row  The array of data to be inserted
     *
     * @return array
     */
    public function created_at($row)
    {
        if ( ! array_key_exists($this->created_field, $row)) {
            $row[$this->created_field] = $this->set_date();
        }

        return $row;
    }

    /**
     * Sets the updated_at date for the object based on the
     * current date/time and date_format. Will not overwrite existing.
     *
     * @param array  $row  The array of data to be inserted
     *
     * @return array
     */
    public function updated_at($row)
    {
        if ( ! array_key_exists($this->updated_field, $row)) {
            $row[$this->updated_field] = $this->set_date();
        }

        return $row;
    }

    //------------------ Internal Functionalities --------------------------------------------------
    
    /**
     * Return the method name for the current return type
     */
    protected function return_type($multi = FALSE)
    {
        $method = ($multi) ? 'result' : 'row';
        
		//if a custom object return type
		if (($this->temp_return_type == 'object') && ($this->custom_return_object != '')) {
		  return 'custom_'.$method.'_object';
		} else {
			// If our type is either 'array' or 'json', we'll simply use the array version
			// of the function, since the database library doesn't support json.
			return $this->temp_return_type == 'array' ? $method . '_array' : $method;
		}	
    }

    /**
     * Return the return data for configured type
    *
    * @param [type] $data
    * @param boolean $multi
    * @return void
    */
    protected function return_data($data, $multi = FALSE)
    {
		$r_type_method = $this->return_type($multi); 
		//if a object return type
		if (($this->temp_return_type == 'object') && ($this->custom_return_object != '')) {
			if ($r_type_method == 'custom_row_object') {
				$data = $data->{$r_type_method}(0,$this->custom_return_object);
			} else {	
			 $data = $data->{$r_type_method}($this->custom_return_object);
			}
		} else {
			$data = $data->{$r_type_method}();
		}	
		return  $data;
    }

    /**
     * Set WHERE parameters
     */
    protected function set_where($params, $db_type)
    {
        if (count($params) == 1)
        {
            $this->{$db_type}->where($params[0]);
        }
        else
        {
            $this->{$db_type}->where($params[0], $params[1]);
        }
    }

    /**
     * Triggers a model-specific event and call each of it's observers.
     *
     * @param string    $event  The name of the event to trigger
     * @param mixed     $data   The data to be passed to the callback functions.
     *
     * @return mixed
     */
    public function trigger($event, $data=false)
    {
        if ( ! isset($this->$event) || ! is_array($this->$event))
        {
            return $data;
        }

        foreach ($this->$event as $method)
        {
            if (strpos($method, '('))
            {
                preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);
                $this->callback_parameters = explode(',', $matches[3]);
            }

            $data = call_user_func_array(array($this, $method), array($data));
        }

        return $data;
    }

    /**
     * Adds the 'required' rule to the field's validation rules if exists.
     *
     * @param  string $field The name of the field to require
     * @return void
     */
    public function require_field($field)
    {
        if ( ! is_array($this->validation_rules) || ! count($this->validation_rules) )
        {
            return;
        }

        // If $field is an array, run them all through
        // this same method.
        if (is_array($field))
        {
            foreach ($field as $f)
            {
                $this->require_field($f);
            }

            return;
        }

        if ( ! is_string($field))
        {
            return;
        }

        for ($i = 1; $i < count($this->validation_rules); $i++)
        {
            if ($this->validation_rules[$i]['field'] == $field)
            {
                if (strpos($this->validation_rules[$i]['rules'], 'required'))
                {
                    // Already requiring this field.
                    break;
                }

                $this->validation_rules[$i]['rules'] = 'required|'. $this->validation_rules[$i]['rules'];
                break;
            }
        }
    }

    /**
     * Validates the data passed into it based upon the form_validation rules
     * setup in the $this->validate property.
     *
     * @param  array $data      An array of validation rules
     * @param string $type      Either 'insert' or 'update'
     *
     * @return array/bool       The original data or FALSE
     */
    public function validate($data, $type='update')
    {
        if ($this->skip_validation === true)
        {
            return $data;
        }

        if ( ! empty($this->validation_rules))
        {
            // We have to add/override the values to the
            // $_POST vars so that form_validation library
            // can work with them.
            foreach($data as $key => $val)
            {
                $_POST[$key] = $val;
            }

            $this->load->library('form_validation');

            if (is_array($this->validation_rules))
            {
                // If $type == 'insert', then we need to incorporate the
                // $insert_validation_rules.
                if ($type == 'insert'
                    && is_array($this->insert_validation_rules)
                    && count($this->insert_validation_rules))
                {
                    foreach ($this->validation_rules as &$row)
                    {
                        if (isset($this->insert_validation_rules[$row['field']]))
                        {
                            $row['rules'] = $this->insert_validation_rules[$row['field']] .'|'. $row['rules'];
                        }
                    }
                }

                // Now validate!
                $this->form_validation->set_rules($this->validation_rules);

                if ($this->form_validation->run() === true)
                {
                    return $data;
                }
                else
                {
                    return true;
                }
            }
            // It could be a string representing the name of a rule group
            // if you're saving the rules in a config file.
            else
            {
                if ($this->form_validation->run($this->validation_rules) === true)
                {
                    return $data;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return $data;
        }
    }

    /**
     * Protect attributes by removing them from $row array. Useful for
     * removing id, or submit buttons names if you simply throw your $_POST
     * array at your model. :)
     *
     * @param object/array $row The value pair item to remove.
     */
    public function protect_attributes($row)
    {
        foreach ($this->protected_attributes as $attr) {
            if (is_object($row)) {
                unset($row->$attr);
            } else {
                unset($row[$attr]);
            }
        }

        return $row;
    }

    /**
     * A utility function to allow child models to use the type of
     * date/time format that they prefer. This is primarily used for
     * setting created_on and modified_on values, but can be used by
     * inheriting classes.
     *
     * The available time formats are:
     * * 'int'      - Stores the date as an integer timestamp.
     * * 'datetime' - Stores the date and time in the SQL datetime format.
     * * 'date'     - Stores teh date (only) in the SQL date format.
     *
     * @param mixed $user_date An optional PHP timestamp to be converted.
     *
     * @access protected
     *
     * @return int|null|string The current/user time converted to the proper format.
     */
    protected function set_date($user_date = null)
    {
        $current_date = !empty($user_date) ? $user_date : time();

        switch ($this->date_format)
        {
            case 'int':
                return $current_date;
                break;
            case 'datetime':
                return date('Y-m-d H:i:s', $current_date);
                break;
            case 'date':
                return date( 'Y-m-d', $current_date);
                break;
        }

    }

    /**
     * Set user id for log_user
     *
     * @return string
     */
    protected function set_user()
    {
        if ( ! $this->user_id == '') {
            return $this->user_id;
        }

        if (session('user_id')) {
            return session('user_id');
        }

        return '';
    }

    /**
     * Allows you to retrieve error messages from the database
     *
     * @return string
     */
    public function get_db_error_message($db_type)
    {
        switch ($this->{$db_type}->platform())
        {
            case 'cubrid':
                // return cubrid_errno($this->{$db_type}->conn_id);
            case 'mssql':
                // return mssql_get_last_message();
            case 'mysql':
                // return mysql_error($this->{$db_type}->conn_id);
            case 'mysqli':
                return mysqli_error($this->{$db_type}->conn_id);
            case 'oci8':
                // If the error was during connection, no conn_id should be passed
                $error = is_resource($this->{$db_type}->conn_id) ? oci_error($this->{$db_type}->conn_id) : oci_error();
                return $error['message'];
            case 'odbc':
                return odbc_errormsg($this->{$db_type}->conn_id);
            case 'pdo':
                $error_array = $this->{$db_type}->conn_id->errorInfo();
                return $error_array[2];
            case 'postgre':
                return pg_last_error($this->{$db_type}->conn_id);
            case 'sqlite':
                // return sqlite_error_string(sqlite_last_error($this->{$db_type}->conn_id));
            case 'sqlsrv':
                // $error = array_shift(sqlsrv_errors());
                return !empty($error['message']) ? $error['message'] : null;
            default:
                /*
                 * !WARNING! $this->{$db_type}->_error_message() is supposed to be private and
                 * possibly won't be available in future versions of CI
                 */
                return $this->{$db_type}->_error_message();
        }
    }

    //------------------ Custom Method Functionalities --------------------------------------------------
    
    /**
     * Return the current query
     *
     * @return CI_DB_Result
     */
    public function showQuery()
    {
        return $this->dbr->last_query();
    }

    //------------------ CodeIgniter Database  Wrappers --------------------------------------------------
    //
    // To allow for more expressive syntax, we provide wrapper functions
    // for most of the query builder methods here.
    //
    // This allows for calls such as:
    //      $result = $this->model->select('...')
    //                            ->where('...')
    //                            ->having('...')
    //                            ->find();
    //

    /**
     * Select function
     *
     * @param string $select
     * @param mixed $escape
     * @return object
     */
    public function select($select = '*', $escape = null) 
    { 
        $this->dbr->select($select, $escape); 
        return $this; 
    }

    /**
     * Select Maximum function
     *
     * @param string $select
     * @param string $alias
     * @return object
     */
    public function selectMax($select = '', $alias = '') 
    { 
        $this->dbr->select_max($select, $alias); 
        return $this; 
    }

    /**
     * Select Minimum function
     *
     * @param string $select
     * @param string $alias
     * @return object
     */
    public function selectMin($select = '', $alias = '') 
    { 
        $this->dbr->select_min($select, $alias); 
        return $this; 
    }

    /**
     * Select Average function
     *
     * @param string $select
     * @param string $alias
     * @return object
     */
    public function selectAvg($select = '', $alias = '') 
    { 
        $this->dbr->select_avg($select, $alias); 
        return $this; 
    }

    /**
     * Select Sum function
     *
     * @param string $select
     * @param string $alias
     * @return object
     */
    public function selectSum($select = '', $alias = '') 
    { 
        $this->dbr->select_sum($select, $alias); 
        return $this; 
    }

    /**
     * Distinct function
     *
     * @param boolean $value
     * @return object
     */
    public function distinct($value = true) 
    { 
        $this->dbr->distinct($value); 
        return $this; 
    }

    /**
     * From function
     *
     * @param  string $from
     * @return object
     */
    public function from($from) 
    { 
        $this->dbr->from($from); 
        return $this; 
    }

    /**
     * Join function
     *
     * @param string $table
     * @param string $condition
     * @param string $type
     * @return object
     */
    public function join($table, $condition, $type = '') 
    { 
        $this->dbr->join($table, $condition, $type); 
        return $this; 
    }

    /**
     * Where function
     *
     * @param mixed $key
     * @param mixed $value
     * @param boolean $escape
     * @return object
     */
    public function where($key, $value = null, $escape = true) 
    { 
        $this->dbr->where($key, $value, $escape); 
        return $this; 
    }

    /**
     * orWhere function
     *
     * @param mixed $key
     * @param mixed $value
     * @param boolean $escape
     * @return object
     */
    public function orWhere($key, $value = null, $escape = true) { 
        $this->dbr->or_where($key, $value, $escape); 
        return $this; 
    }

    /**
     * whereIn function
     *
     * @param mixed $key
     * @param mixed $values
     * @return object
     */
    public function whereIn($key = null, $values = null) 
    { 
        $this->dbr->where_in($key, $values); 
        return $this; 
    }

    /**
     * orWhereIn function
     *
     * @param mixed $key
     * @param mixed $values
     * @return object
     */
    public function orWhereIn($key = null, $values = null) 
    { 
        $this->dbr->or_where_in($key, $values); 
        return $this; 
    }

    /**
     * whereNotIn function
     *
     * @param mixed $key
     * @param mixed $values
     * @return object
     */
    public function whereNotIn($key = null, $values = null) 
    { 
        $this->dbr->where_not_in($key, $values); 
        return $this; 
    }

    /**
     * orWhereNotIn function
     *
     * @param mixed $key
     * @param mixed $values
     * @return object
     */
    public function orWhereNotIn($key = null, $values = null) 
    { 
        $this->dbr->or_where_not_in($key, $values); 
        return $this; 
    }

    /**
     * Like function
     *
     * @param string $field
     * @param string $match
     * @param string $side
     * @return object
     */
    public function like($field, $match = '', $side = 'both') 
    { 
        $this->dbr->like($field, $match, $side); 
        return $this; 
    }

    /**
     * notLike function
     *
     * @param string $field
     * @param string $match
     * @param string $side
     * @return object
     */
    public function notLike($field, $match = '', $side = 'both') 
    { 
        $this->dbr->not_like($field, $match, $side); 
        return $this; 
    }

    /**
     * orLike function
     *
     * @param string $field
     * @param string $match
     * @param string $side
     * @return object
     */
    public function orLike($field, $match = '', $side = 'both') 
    { 
        $this->dbr->or_like($field, $match, $side); 
        return $this;
    }

    /**
     * orNotLike function
     *
     * @param string $field
     * @param string $match
     * @param string $side
     * @return object
     */
    public function orNotLike($field, $match = '', $side = 'both') 
    { 
        $this->dbr->or_not_like($field, $match, $side); 
        return $this; 
    }

    /**
     * groupBy function
     *
     * @param string $by
     * @return object
     */
    public function groupBy($by) 
    { 
        $this->dbr->group_by($by); 
        return $this; 
    }

    /**
     * Having function
     *
     * @param mixed $key
     * @param string $value
     * @param boolean $escape
     * @return object
     */
    public function having($key, $value = '', $escape = true) 
    { 
        $this->dbr->having($key, $value, $escape); 
        return $this; 
    }

    /**
     * orHaving function
     *
     * @param mixed $key
     * @param string $value
     * @param boolean $escape
     * @return object
     */
    public function orHaving($key, $value = '', $escape = true) 
    { 
        $this->dbr->or_having($key, $value, $escape); 
        return $this; 
    }

    /**
     * orderBt function
     *
     * @param string $orderby
     * @param string $direction
     * @return object
     */
    public function orderBy($orderby, $direction = '') 
    { 
        $this->dbr->order_by($this->table.'.'.$orderby, $direction); 
        return $this; 
    }

    /**
     * Limit function
     *
     * @param mixed $value
     * @param string $offset
     * @return object
     */
    public function limit($value, $offset = '') 
    { 
        $this->dbr->limit($value, $offset); 
        return $this; 
    }

    /**
     * Offset function
     *
     * @param mixed $offset
     * @return object
     */
    public function offset($offset) 
    { 
        $this->dbr->offset($offset); 
        return $this; 
    }

    /**
     * Set key value
     *
     * @param mixed $key
     * @param string $value
     * @param boolean $escape
     * @return object
     */
    public function set($key, $value = '', $escape = true) 
    { 
        $this->dbw->set($key, $value, $escape); 
        return $this; 
    }

    /**
     * Count all results
     *
     * @return object
     */
    public function countAllResults() { 
        $this->dbr->count_all_results($this->table); 
        return $this; 
    }
    
}
/* end of file Core/core/Models/Model.php */
