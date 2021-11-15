<?php

/**
 * An Base Model to provide basic actions 
 * for models that inherit from it to do 
 * more than the EasyModel
 * 
 * Borrowed from Bonfire 
 * Expanded to work with Webby
 * 
 * Note it is not well documented.
 *
 * @author  Oteng Kwame Appiah-Nti <developerkwame@gmail.com> (Developer Kwame)
 * @license MIT
 * @link    <link will be here>
 * @version 1.0
 */

namespace Base\Models;

class BaseModel extends Model 
{

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
    protected $primaryKey = 'id';

    /**
     * Field name to use for created time column in the DB table.
     *
     * @var string
     * @access protected
     */
    protected $createdField = 'created_at';

    /**
     * Field name to use for modified time column in the DB table.
     *
     * @var string
     * @access protected
     */
    protected $updatedField = 'updated_at';

    /**
     * Whether or not to auto-fill a 'created_at' field on inserts.
     *
     * @var boolean
     * @access protected
     */
    protected $setCreatedAt  = true;

    /**
     * Whether or not to auto-fill a 'updated_at' field on updates.
     *
     * @var boolean
     * @access protected
     */
    protected $setUpdatedAt = true;

    /**
     * 
     * If true, will log user id 
     * for 'created_by', 'updated_by' and 'deleted_by'.
     *
     * @var boolean
     */
    protected $logUser = true;

    /**
     * 
     * If $logUser is true, set the session id
     * to be used to set the user id, by default
     * the session id used is 'user_id'.
     *
     * @var string
     */
    protected $userSessionKey = 'user_id';

    /**
     * The user id to use when logging user.
     *
     * @var string
     */
    public $userId = '';

    /**
     * Field name to use for created_by 
     * column in the DB table
     *
     * @var string
     */
    protected $createdByField = 'created_by';

    /**
     * Field name to use for the update_by 
     * column in the DB table
     *
     * @var string
     */
    protected $updatedByField = 'updated_by';

    /**
     * Field name to use for the deleted_by 
     * column in the DB table.
     *
     * @var string
     */
    protected $deletedByField = 'deleted_by';

    /**
     * The type of date/time field used for created_at and update_at fields.
     * Valid types are: 'int', 'datetime', 'date'
     *
     * @var string
     * @access protected
     */
    protected $dateFormat = 'datetime';

    /**
     * Support for soft delete.
     */
    protected   $softDelete       = false;
    protected   $softDeleteKey    = 'is_deleted';
    protected   $tempWithDeleted  = false;

    /**
     * Various callbacks available to the class. They are simple lists of
     * method names (methods will be ran on $this).
     */
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected $callbackParameters  = [];

    /**
    * Protected, non-modifiable attributes
    *
    * @var array
    */
    protected $protectedAttributes = [];

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
    protected $validationRules = [];

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
    protected $insertValidationRules = [];

    /**
     * Optionally skip the validation. Used in conjunction with
     * skipValidation() to skip data validation for any future calls.
     */
    protected $skipValidation = false;

    /**
     * By default, we return items as objects. You can change this for the
     * entire class by setting this value to 'array' instead of 'object'.
     * Alternatively, you can do it on a per-instance basis using the
     * 'as_array()' and 'as_object()' methods.
     */
    protected $returnAs      = 'object';
    protected $tempReturnType = null;
	
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
     * If true, inserts will return the last_insert_id. However,
     * this can potentially slow down large imports drastically
     * so you can turn it off with the return_insert_id(false) method.
     * This will simply return true, instead.
     * 
     * IMPORTANT: Turning this to false will bypass any afterInsert
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
        array_unshift($this->beforeInsert, 'protectAttributes');
        array_unshift($this->beforeUpdate, 'protectAttributes');

        // Check our auto-set features and make sure they are part of
        // our observer system.
        if ($this->setCreatedAt === true) array_unshift($this->beforeInsert, 'created_at');
        if ($this->setUpdatedAt === true) array_unshift($this->beforeUpdate, 'updated_at');

        // Make sure our temp return type is correct.
        $this->tempReturnType = $this->returnAs;

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

        log_message('debug', 'BaseModel Class Initialized');
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
     * @param  mixed $id The primaryKey value of the object to retrieve.
     * @return object
     */
    public function find($id)
    {
        $this->trigger('beforeFind');

        // Ignore any soft-deleted rows
        if ($this->softDelete && $this->tempWithDeleted !== true)
        {
            $this->dbr->where($this->table.'.'.$this->softDeleteKey, false);
        }

        $this->dbr->where($this->table.'.'.$this->primaryKey, $id);
        $row = $this->dbr->get($this->table);
        $row = $this->returnData($row);
		  

        $row = $this->trigger('afterFind', $row);

        if ($this->tempReturnType == 'json')
        {
            $row = json_encode($row);
        }

        // Reset our return type
        $this->tempReturnType = $this->returnAs;

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
        $this->setWhere($where, 'dbr');

        // Ignore any soft-deleted rows
        if ($this->softDelete && $this->tempWithDeleted !== true)
        {
            $this->dbr->where($this->softDeleteKey, false);
        }

        $this->trigger('beforeFind');

        $row = $this->dbr->get($this->table);
        $row = $this->returnData($row);

        $row = $this->trigger('afterFind', $row);

        if ($this->tempReturnType == 'json')
        {
            $row = json_encode($row);
        }

        // Reset our return type
        $this->tempReturnType = $this->returnAs;

        return $row;
    }

    /**
     * Retrieves a number of items based on an array of primary_values passed in.
     *
     * @param  array $values An array of primary key values to find.
     *
     * @return object or false
     */
    public function findMany($values)
    {
        $this->dbr->where_in($this->primaryKey, $values);

        return $this->findAll();
    }

    /**
     * Retrieves a number of items based on an arbitrary WHERE call. Can be
     * any set of parameters valid to $db->where.
     *
     * @return object or false
     */
    public function findByMany()
    {
        $where = func_get_args();
        $this->setWhere($where, 'dbr');

        return $this->findAll();
    }

    /**
     * Fetch all of the records in the table. Can be used with scoped calls
     * to restrict the results.
     *
     * @return object or false
     */
    public function findAll()
    {
        $this->trigger('beforeFind');

        // Ignore any soft-deleted rows
        if ($this->softDelete && $this->tempWithDeleted !== true)
        {
            $this->dbr->where($this->table.'.'.$this->softDeleteKey, false);
        }

        $rows = $this->db->get($this->table);
        $rows = $this->returnData($rows,true);

        if (is_array($rows))
        {
            foreach ($rows as $key => &$row)
            {
                $row = $this->trigger('afterFind', $row, ($key == count($rows) - 1));
            }
        }

        if ($this->tempReturnType == 'json')
        {
            $rows = json_encode($rows);
        }

        // Reset our return type
        $this->tempReturnType = $this->returnAs;

        return $rows;
    }

    /**
     * Get data by selecting a field or many fields
     * where the values are provided
     *
     * @param string $field
     * @param array $value
     * @return object|array
     */
    public function selectWhere($field, $value)
    {
        $this->trigger('beforeFind');
        
        // Ignore any soft-deleted rows
        if ($this->softDelete && $this->tempWithDeleted !== true)
        {
            $this->dbr->where($this->table.'.'.$this->softDeleteKey, false);
        }

        $this->db->select($field)->from($this->table)->where($value);

        $rows =  $this->db->get();
        $rows = $this->returnData($rows,true);

        if (is_array($rows))
        {
            foreach ($rows as $key => &$row)
            {
                $row = $this->trigger('afterFind', $row, ($key == count($rows) - 1));
            }
        }

        if ($this->tempReturnType == 'json')
        {
            $rows = json_encode($rows);
        }

        // Reset our return type
        $this->tempReturnType = $this->returnAs;

        return $rows;
    }

    /**
     * Alias function to findAll()
     *
     * @return object or false
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
     * @return mixed The primaryKey value of the inserted record, or false.
     */
    public function insert($data)
    {
        $data = $this->trigger('beforeInsert', $data);

        if ($this->skipValidation === false)
        {
            $data = $this->validate($data, 'insert');

            // If $data is false, we didn't validate
            // so we need to get out of here.
            if ( ! $data)
            {
                return false;
            }
        }

        if($this->setCreatedAt and empty($data[$this->createdField]))
        {
            $data[$this->createdField] = $this->setDate();
        }

        if($this->logUser)
        {
            $data[$this->createdByField] = $this->setUser();
        }

        $this->dbw->insert($this->table, $data);

        if ($this->return_insert_id)
        {
            $id = $this->dbw->insert_id();

            $this->trigger('afterInsert', $id);
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
     * @return mixed the primaryKey value of the inserted record, or false.
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
     * @param array $data An associate array of rows to insert
     * @param boolean $escape
     * @param integer $size
     * @return integer
     */
    public function insertBatch($data)
    {
        if ($this->skipValidation === false)
        {
            $data = $this->validate($data, 'insert');
            if ( ! $data)
            {
                return false;
            }
        }

        $data['batch'] = true;
        $data = $this->trigger('beforeInsert', $data, $escape = null, $size = 100);

        if ($this->setCreatedAt === false) {
            unset($data['created_at']);
        }

        unset($data['batch']);
 
        return $this->dbw->insert_batch($this->table, $data, $escape, $size);
    }
    
    /**
     * Updates an existing record in the database.
     *
     * @param  mixed $id   The primaryKey value of the record to update.
     * @param  array $data An array of value pairs to update in the record.
     * @return bool
     */
    public function update($id, $data)
    {
        $data = $this->trigger('beforeUpdate', $data);

        if ($this->skipValidation === false)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return false;
            }
        }

        $this->dbw->where($this->primaryKey, $id);

        if ($this->logUser)
        {
            $data[$this->updatedByField] = $this->setUser();
        }

        $this->dbw->set($data);

        $result = $this->dbw->update($this->table);

        $this->trigger('afterUpdate', array($data, $result));

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
            $row = $this->trigger('beforeUpdate', $row);
        }

        $result = $this->dbw->update_batch($this->table, $data, $where_key);

        foreach ($data as &$row)
        {
            $this->trigger('afterUpdate', array($row, $result));
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
     * @param  array $ids  An array of primaryKey values to update.
     * @param  array $data An array of value pairs to modify in each row.
     * @return bool
     */
    public function updateMany($ids, $data)
    {
        $data = $this->trigger('beforeUpdate', $data);

        if ($this->skipValidation === false)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return false;
            }
        }

        $this->dbw->where_in($this->primaryKey, $ids);
        
        if ($this->logUser)
        {
            $data[$this->updatedByField] = $this->setUser();
        }

        $this->dbw->set($data);
        $result = $this->dbw->update($this->table);

        $this->trigger('afterUpdate', array($data, $result));

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
        $this->setWhere($args, 'dbw');

        $data = $this->trigger('beforeUpdate', $data);

        if ($this->skipValidation === false)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return false;
            }
        }

        if ($this->logUser)
        {
            $data[$this->updatedByField] = $this->setUser();
        }

        $this->dbw->set($data);
        $result = $this->dbw->update($this->table);

        $this->trigger('afterUpdate', array($data, $result));

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
        $data = $this->trigger('beforeUpdate', $data);

        if ($this->skipValidation === false)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return false;
            }
        }

        if ($this->logUser)
        {
            $data[$this->updatedByField] = $this->setUser();
        }

        $this->dbw->set($data);
        $result = $this->dbw->update($this->table);

        $this->trigger('afterUpdate', array($data, $result));

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
        $this->trigger('beforeDelete', $id);

         $this->dbw->where($this->primaryKey, $id);

        if ($this->softDelete)
        {
            $sets = $this->logUser ? array($this->softDeleteKey => 1, $this->deletedByField => $this->setUser()) : array($this->softDeleteKey => 1);

            $result = $this->dbw->update($this->table, $sets);
        }

        // Hard Delete
        else {
            $result = $this->dbw->delete($this->table);
        }

        $this->trigger('afterDelete', $result);

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
        $this->setWhere($where, 'dbw');

        $where = $this->trigger('beforeDelete', $where);

        if ($this->softDelete)
        {
            $sets = $this->logUser ? array($this->softDeleteKey => 1, $this->deletedByField => $this->setUser()) : array($this->softDeleteKey => 1);

            $result = $this->dbw->update($this->table, $sets);
        }
        else
        {
            $result = $this->dbw->delete($this->table);
        }

        $this->trigger('afterDelete', $result);

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
        $ids = $this->trigger('beforeDelete', $ids);

        $this->dbw->where_in($ids);

        if ($this->softDelete)
        {
            $sets = $this->logUser ? array($this->softDeleteKey => 1, $this->deletedByField => $this->setUser()) : array($this->softDeleteKey => 1);

            $result = $this->dbw->update($this->table, $sets);
        }
        else
        {
            $result = $this->dbw->delete($this->table);
        }

        $this->trigger('afterDelete', $result);

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
     * @param boolean $value $val If true, should perform 
     * a soft delete. If false, a hard delete.
     * @return object
     */
    public function softDelete($value = true)
    {
        $this->softDelete = $value;

        return $this;
    }

    /**
     * Temporarily sets our return type to an array.     
     * 
     * @return object
     */
    public function asArray()
    {
        $this->tempReturnType = 'array';

        return $this;
    }

    /**
     * Temporarily sets our return type to an object
    *
    * @return object
    */
    public function asObject()
    {
        $this->tempReturnType = 'object';

        return $this;
    }

    /**
     * Temporarily sets our object return to a json object.
    *
    * @return object
    */
    public function asJson()
    {
        $this->tempReturnType = 'json';

        return $this;
    }

    /**
     * Also fetches deleted items for this request only.
     * 
     * @return object
     */
    public function withDeleted()
    {
        $this->tempWithDeleted = true;

        return $this;
    }

    /**
     * Sets the value of the skipValidation flag
     *
     * @param boolean $skip (optional) whether to 
     * skip validation in the model
     *
     * @return object    returns $this to 
     * allow method chaining
     */
    public function skipValidation($skip=true)
    {
        $this->skipValidation = $skip;

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
        $this->setWhere($where, 'dbr');

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
            $key = $this->primaryKey;
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
     * @param mixed  $id    The primaryKey value to match against.
     * @param string $field The field to search for.
     *
     * @return bool|mixed The value of the field.
     */
    public function getField($id=null, $field='')
    {
        $this->dbr->select($field);
        $this->dbr->where($this->primaryKey, $id);
        $query = $this->dbr->get($this->table);

        if ($query && $query->num_rows() > 0)
        {
            return $query->row()->$field;
        }

        return false;

    }

    /**
     * Checks whether a field/value pair exists within the table.
     *
     * @param string $field The field to search for.
     * @param string $value The value to match $field against.
     *
     * @return bool true/false
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
     * current date/time and dateFormat. Will not overwrite existing.
     *
     * @param array  $row  The array of data to be inserted
     *
     * @return array
     */
    public function createdAt($row)
    {
        if ( ! array_key_exists($this->createdField, $row)) {
            $row[$this->createdField] = $this->setDate();
        }

        return $row;
    }

    /**
     * Sets the updated_at date for the object based on the
     * current date/time and dateFormat. Will not overwrite existing.
     *
     * @param array  $row  The array of data to be inserted
     *
     * @return array
     */
    public function updatedAt($row)
    {
        if ( ! array_key_exists($this->updatedField, $row)) {
            $row[$this->updatedField] = $this->setDate();
        }

        return $row;
    }

    //------------------ Internal Functionalities --------------------------------------------------
    
    /**
     * Return the method name for the current return type
     */
    protected function returnType($multi = false)
    {
        $method = ($multi) ? 'result' : 'row';
        
		//if a custom object return type
		if (($this->tempReturnType == 'object') && ($this->custom_return_object != '')) {
		  return 'custom_'.$method.'_object';
		} else {
			// If our type is either 'array' or 'json', we'll simply use the array version
			// of the function, since the database library doesn't support json.
			return $this->tempReturnType == 'array' ? $method . '_array' : $method;
		}	
    }

    /**
     * Return the return data for configured type
    *
    * @param mixed $data
    * @param boolean $multi
    * @return void
    */
    protected function returnData($data, $multi = false)
    {
		$r_type_method = $this->returnType($multi); 
		//if a object return type
		if (($this->tempReturnType == 'object') && ($this->custom_return_object != '')) {
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
    protected function setWhere($params, $dbType)
    {
        if (count($params) == 1)
        {
            $this->{$dbType}->where($params[0]);
        }
        else
        {
            $this->{$dbType}->where($params[0], $params[1]);
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
                $this->callbackParameters = explode(',', $matches[3]);
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
    public function requireField($field)
    {
        if ( ! is_array($this->validationRules) || ! count($this->validationRules) )
        {
            return;
        }

        // If $field is an array, run them all through
        // this same method.
        if (is_array($field))
        {
            foreach ($field as $f)
            {
                $this->requireField($f);
            }

            return;
        }

        if ( ! is_string($field))
        {
            return;
        }

        for ($i = 1; $i < count($this->validationRules); $i++)
        {
            if ($this->validationRules[$i]['field'] == $field)
            {
                if (strpos($this->validationRules[$i]['rules'], 'required'))
                {
                    // Already requiring this field.
                    break;
                }

                $this->validationRules[$i]['rules'] = 'required|'. $this->validationRules[$i]['rules'];
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
     * @return array/bool       The original data or false
     */
    public function validate($data, $type='update')
    {
        if ($this->skipValidation === true)
        {
            return $data;
        }

        if ( ! empty($this->validationRules))
        {
            // We have to add/override the values to the
            // $_POST vars so that form_validation library
            // can work with them.
            foreach($data as $key => $val)
            {
                $_POST[$key] = $val;
            }

            $this->load->library('form_validation');

            if (is_array($this->validationRules))
            {
                // If $type == 'insert', then we need to incorporate the
                // $insertValidationRules.
                if ($type == 'insert'
                    && is_array($this->insertValidationRules)
                    && count($this->insertValidationRules))
                {
                    foreach ($this->validationRules as &$row)
                    {
                        if (isset($this->insertValidationRules[$row['field']]))
                        {
                            $row['rules'] = $this->insertValidationRules[$row['field']] .'|'. $row['rules'];
                        }
                    }
                }

                // Now validate!
                $this->form_validation->set_rules($this->validationRules);

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
                if ($this->form_validation->run($this->validationRules) === true)
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
    public function protectAttributes($row)
    {
        foreach ($this->protectedAttributes as $attr) {
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
    protected function setDate($user_date = null)
    {
        $current_date = !empty($user_date) ? $user_date : time();

        switch ($this->dateFormat)
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
     * Set user id for logUser
     *
     * @return string
     */
    protected function setUser()
    {
        if ( ! $this->userId == '') {
            return $this->userId;
        }

        if (session($this->userSessionKey)) {
            return session($this->userSessionKey);
        }

        return '';
    }

    /**
     * Allows you to retrieve error messages from the database
     *
     * @return string
     */
    /** */
    /**
     * Allows you to retrieve error messages from the database
     *
     * @param string $dbType
     * @return mixed
     */
    public function getDbErrorMessage($dbType)
    {
        switch ($this->{$dbType}->platform())
        {
            case 'cubrid':
                // return cubrid_errno($this->{$dbType}->conn_id);
            case 'mssql':
                // return mssql_get_last_message();
            case 'mysql':
                // return mysql_error($this->{$dbType}->conn_id);
            case 'mysqli':
                return mysqli_error($this->{$dbType}->conn_id);
            case 'oci8':
                // If the error was during connection, no conn_id should be passed
                $error = is_resource($this->{$dbType}->conn_id) ? oci_error($this->{$dbType}->conn_id) : oci_error();
                return $error['message'];
            case 'odbc':
                return odbc_errormsg($this->{$dbType}->conn_id);
            case 'pdo':
                $error_array = $this->{$dbType}->conn_id->errorInfo();
                return $error_array[2];
            case 'postgre':
                return pg_last_error($this->{$dbType}->conn_id);
            case 'sqlite':
                // return sqlite_error_string(sqlite_last_error($this->{$dbType}->conn_id));
            case 'sqlsrv':
                // $error = array_shift(sqlsrv_errors());
                return !empty($error['message']) ? $error['message'] : null;
            default:
                /*
                 * !WARNING! $this->{$dbType}->_error_message() is supposed to be private and
                 * possibly won't be available in future versions of CI
                 */
                return $this->{$dbType}->_error_message();
        }
    }

    //------------------ Custom Method Functionalities --------------------------------------------------
    
    /**
     * Return the current query
     *
     * @return CI_DB_Result
     */
    

    /**
    *   To allow for more expressive syntax, we provide wrapper functions
    *   for most of the query builder methods here.
    *
    *   This allows for calls such as:
    *   $result = $this->model->select('...')
    *                            ->where('...')
    *                            ->having('...')
    *                           ->find();
    *
    */

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
    public function join($table, $condition, $type = '', $escape = null) 
    { 
        $this->dbr->join($table, $condition, $type, $escape); 
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
     * orderBy function
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
/* end of file Core/core/Models/BaseModel.php */
