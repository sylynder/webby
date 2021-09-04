<?php

namespace Base\Models;

/**
 * An Easy Model to provide basic actions 
 * for all models that inherit from it
 * Expanded by Me (Oteng Kwame Appiah Nti)
 * I think this will be useful :)
 * 
 * Note it is not well documented.
 *
 * @author  Oteng Kwame Appiah-Nti <developerkwame@gmail.com> (Developer Kwame)
 * @license MIT
 * @link    <link will be here>
 * @version 1.0
 */

class EasyModel extends Model
{

    /**
     * The model's default table.
     *
     * @var string;
     */
    public $table;

    /**
     * The model's default primary key.
     *
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * The where variable to be used
     *
     * @var mixed
     */
    public $where;

    public $order;

    public $columnOrder;

    public $columnSearch;

    /**
     * Support for soft deletes and a model's 'deleted' key
     */
    protected $softDelete = false;
    protected $softDeleteKey = 'is_deleted';
    protected $temporaryWithDeleted = false;
    protected $temporaryOnlyDeleted = false;

    public $ci;

    /**
     * Change the fetch mode if desired
     *
     * @var string $returnAs Optionally set to 'object', 
     * default is 'array', can also be set to 'json'
     * 
     */
    public $returnAs = 'object';

    /**
     * Construct the CI_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This function is used to 
     * escape data in codeigniter
     *
     * @param string $string
     * @return mixed
     */
    public function escape(string $string)
    {
        return $this->db->escape($string);
    }

    /**
     * Getter for the table name.
     *
     * @return string The name of the table used by this class.
     */
    public function table($tablename = false)
    {
        if ($tablename) {
            $this->table = $tablename;
            return $this;
        }

        return $this->table;
    }

    /**
     * This function retrieves the current 
     * sql query made and can be displayed to user
     *
     * @return void
     */
    public function showQuery()
    {
        return $this->db->last_query();
    }

    //--------- All functions below are used for retrieving information from the database -----
    
    /**
     * Make a query for filling datatables
     *
     * @return mixed
     */
    public function makeDatableQuery()
    {

        $this->db->from($this->table);
        $this->db->where($this->where);

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        $_POST = xss_clean($_POST);
        $i = 0;

        foreach ($this->columnSearch as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->columnSearch) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }
                //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->columnOrder[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    /**
     * Use queried data to make a datatable
     *
     * @return object|array
     */
    public function makeDatatable()
    {
        $this->makeDatableQuery();

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();

        return $this->getResult($query);
    }

    /**
     * Count retrieved data for datatable 
     *
     * @return mixed
     */
    public function countFilteredWhere()
    {
        $this->makeDatableQuery();
        $query = $this->db->get($this->where);
        return $query->num_rows();
    }

    /**
     * Count filtered data for datatable
     *
     * @return mixed
     */
    public function countFiltered()
    {
        $this->makeDatableQuery();
        $query = $this->db->get($this->where);
        return $query->num_rows();
    }

    /**
     * Count data from table  
     *
     * @return mixed
     */
    public function countAll()
    {
        $this->db->from($this->table);

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        return $this->db->count_all_results();
    }

    /**
     * Get the total records in the table
     *
     * @param  string|array  $where
     * @return integer
     */
    public function getTotal($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /**
     * Limit number of data to retrieve from table
     *
     * @param integer $limit
     * @return mixed
     */
    public function setLimit($limit)
    {
        $this->db->limit($limit);
        return $this;
    }

    /**
     * Limit number of data to retrieve from table
     * by setting limit offsets
     *
     * @param integer $limit
     * @return mixed
     */
    public function setLimitStart($limit, $start)
    {
        $this->db->limit($limit, $start);
        return $this;
    }

    public function lastInsertKey($primaryKey = null)
    {
        if ($this->primaryKey != null && $primaryKey == null) {
            $primaryKey = $this->primaryKey;
        }

        $this->db->select_max("{$primaryKey}");

        $result = $this->db->get($this->table)->row_array();
        return $result[$primaryKey];
    }

    public function lastInsertId()
    {
        return $this->db->insert_id();
    }

    public function query($query)
    {
        return $this->db->query($query);
    }

    /**
     * Get query results function
     *
     * @param object $query
     * @return mixed
     */
    public function getResult($query)
    {
        if ($this->returnAs == 'json') {
            return json_encode($query->result_array());
        }

        if ($this->returnAs == 'array') {
            return $query->result_array();
        } 

        return $query->result();
    }

    /**
     * Get query row function
     *
     * @param object $query
     * @param boolean $last
     * @return mixed
     */
    public function getRowResult($query, $last = false)
    {

        $mode = 'first_row';

        if ($last === true) {
            $mode = 'last_row';
        }

        if ($this->returnAs == 'json') {
            $result['data'] = $query->{$mode}('array');
            return json_encode($result['data']);
        }

        if ($this->returnAs == 'array') {
            return $query->{$mode}('array');
        } 
        
        return $query->{$mode}('object');
    }

    /**
     * Grabs data from a table
     *       OR a single record by passing $id,
     *       OR a different field than the primaryKey by passing two paramters
     *       OR by passing an array
     *
     * @param integer|string $idOrRow      (Optional)
     *                                       null    = Fetch all table records
     *                                       number  = Fetch where primary key = $id
     *                                       string  = Fetch based on a different column name
     *                                       array   = Fetch based on array criteria
     *
     * @param integer|string $optionalValue (Optional)
     * @param string         $orderBy (Optional)
     *
     * @return object database results
     */
    public function get($idOrRow = null, $optionalValue = null, $orderBy = null)
    {

        // Custom order by if desired
        if ($orderBy != null) {
            $this->db->order_by($orderBy);
        }

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        // Fetch all records for a table
        if ($idOrRow == null) {
            $query = $this->db->get($this->table);
        } elseif (is_array($idOrRow)) {
            $query = $this->db->get_where($this->table, $idOrRow);
        } else {
            if ($optionalValue == null) {
                $query = $this->db->get_where($this->table, [$this->primaryKey => $idOrRow]);
            } else {
                $query = $this->db->get_where($this->table, [$idOrRow => $optionalValue]);
            }
        }

        return $this->getResult($query);
    }

    /**
     * A simple way to grab the first result of a search only.
     */
    public function first()
    {
        $rows = $this->limit(1)->findAll();
        // dd($rows);
        if (is_array($rows) && count($rows) == 1)
        {
            return $rows[0];
        }
        dd($rows);
        return $rows;
    }

    /**
     * Find with id
     *
     * @param string|integer|array $idOrRow
     * @return array|object
     */
    public function find($idOrRow = null)
    {
        return $this->get($idOrRow, null, null);
    }

    /**
     * Find all
     *
     * @param string|integer|array $idOrRow
     * @param mixed $optionalValue
     * @param mixed $orderBy
     * @return array|object
     */
    public function findAll($idOrRow = null, $optionalValue = null, $orderBy = null)
    {
        return $this->get($idOrRow, $optionalValue, $orderBy);
    }

    /**
     * find where
     *
     * @param string $fields
     * @param array $where
     * @param integer $limit
     * @param mixed $orderBy
     * @return array|object
     */
    public function findWhere($fields, $where = null, $limit = null, $orderBy = null)
    {
        
        // Custom order by if desired
        if ($orderBy != null) {
            $this->db->order_by($orderBy);
        }

        if ($limit != null) {
            $this->db->select($fields)->from($this->table)->where($where)->limit($limit);
        } else if ($where != null) {
            $this->db->select($fields)->from($this->table)->where($where);
        } else {
            $this->db->select($fields)->from($this->table);
        }

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        $query = $this->db->get();

        return $this->getResult($query);
    }

    /**
     *
     * @param string  $field
     * @param array  $where
     * @param array $orwhere
     * @param integer $limit
     * @param mixed $orderBy
     * @return array|object
     */
    public function findOrWhere($fields, $where = null, $orWhere = null, $limit = null, $orderBy = null)
    {

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        // Custom order by if desired
        if ($orderBy != null) {
            $this->db->order_by($orderBy);
        }

        if ($limit != null) {
            $this->db->select($fields)->from($this->table)->where($where)->limit($limit);
        } else if ($where != null) {
            $this->db->select($fields)->from($this->table)->where($where);
        } else {
            $this->db->select($fields)->from($this->table);
        }

        if ($orWhere != null) {
            $this->db->or_where($orWhere);
        }

        $query = $this->db->get();

        return $this->getResult($query);
        
    }

    /**
     * Find limit where
     *
     * @param string $fields
     * @param integer $limit
     * @param array $where
     * @return array|object
     */
    public function findLimitWhere($fields, $limit = null, $where = null)
    {

        if ($where != null) {
            $this->db->select($fields)->from($this->table)->limit($limit);
            $this->db->where($where);
        } else if ($limit != null) {
            $this->db->select($fields)->from($this->table)->limit($limit);
        }

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        $query = $this->db->get();

        return $this->getResult($query);
    }

    /**
     * Get data by a single field or many fields
     * an alternative to the above function
     * @see get(...param)
     * @param array $field
     * @return array|object
     */
    public function whereFields($field)
    {
        $this->db->select()->from($this->table)->where($field);

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        $query = $this->db->get();

        return $this->getRowResult($query);
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

        $this->db->select($field)->from($this->table)->where($value);

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        $query = $this->db->get();

        return $this->getRowResult($query);
    }

    /**
     * Get first data by selecting a field or many fields
     * singlely
     *
     * @param array $field
     * @return object or array
     */
    public function selectSingle($field)
    {
        $this->db->select($field)->from($this->table);

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        $query = $this->db->get();

        return $this->getRowResult($query);
    }

    /**
     * Get last data by selecting a field or many fields
     * singlely
     *
     * @param array $field
     * @return object or array
     */
    public function selectLast($field)
    {
        $this->db->select($field)->from($this->table);

        if ($this->softDelete && $this->temporaryWithDeleted !== true) {
            $this->db->where($this->softDeleteKey, (bool) $this->temporaryOnlyDeleted);
        }

        $query = $this->db->get();
        return $this->getRowResult($query, true);
    }

    /**
     * Insert a record and might return the last inserted field value;
     * @param  array $data
     * @param  bool $show = null
     * @return boolean|object|array
     */
    public function saveOnly($data, $show = false)
    {
        if ($show) {
            $this->db->insert($this->table, $data);
            return $this->selectLast($this->primaryKey); //get inserted data
        }

        return $this->db->insert($this->table, $data);
    }

    /**
     * Insert a record
     * @param  array $data
     * @return integer
     */
    public function save($data)
    {
        //This is an insert
        $this->db->set($data)->insert($this->table);
        return $this->db->insert_id();
    }

    /**
     * Creates a record
     *
     * @usage  insert(['name' => 'jesse', 'age' => 28])
     *
     * @param     array   $data key value pair of mySQL fields
     *
     * @return    integer  insert id
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * This method replaces existing value with new array data
     * @param  array $data
     * @return return int
     */
    public function replace($data)
    {
        $this->db->replace($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Insert Batch data into table
     *
     * @param array $data
     * @param boolean $escape
     * @param integer $size
     * @return integer
     */
    public function insertBatch($data, $escape = null, $size = 100)
    {
        return $this->db->insert_batch($this->table, $data, $escape, $size);
    }

    /**
     * Insert if not exists, if exists Update
     *
     * @usage   insertUpdate(['item' => 10], 25)
     *          insertUpdate(['item' => 10], 'other_key' => 25)
     *
     * @param array $data Associative array [column => value]
     *
     * @param   integer|string $idOrRow (Optional)
     *           null    = Fetch all table records
     *           number  = Fetch where primary key = $id
     *           string  = Fetch based on a different column name
     *
     * @param integer|string $optionalValue (Optional)
     *
     * @return integer InsertID|Update Result
     */
    public function insertUpdate($idOrRow, $optionalValue = null, $data)
    {
        // First check to see if the field exists
        $this->db->select($this->primaryKey);

        if ($optionalValue == null) {
            $query = $this->db->get_where($this->table, [$this->primaryKey => $idOrRow]);
        } else {
            $query = $this->db->get_where($this->table, [$idOrRow => $optionalValue]);
        }

        // Count how many records exist with this ID
        $result = $query->num_rows();

        // INSERT
        if ($result == 0) {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }

        // UPDATE
        if ($optionalValue == null) {
            $this->db->where($this->primaryKey, $idOrRow);
        } else {
            $this->db->where($idOrRow, $optionalValue);
        }

        return $this->db->update($this->table, $data);
    }

    /**
     * Update a record
     *
     * @usage   update(['age' => 29], 12);
     *          update(['age' => 0], 'name', 'jesse');
     *
     * @param  array    $data key/value pair to update
     * @param  integer  $idOrRow (Optional)
     * @param  array    $data
     *
     * @return    boolean result
     */
    public function update($idOrRow, $optionalValue = null, $data)
    {
        if ($optionalValue == null) {
            if (is_array($idOrRow)) {
                $this->db->where($idOrRow);
            } else {
                $this->db->where([$this->primaryKey => $idOrRow]);
            }
        } else {
            $this->db->where([$idOrRow => $optionalValue]);
        }

        return $this->db->update($this->table, $data);
    }

    /**
     * update a record
     */
    public function simpleUpdate($where, $data)
    {
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }

    /**
     * update a record
     */
    public function simpleSetUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->set($data, false);
        return $this->db->update($this->table);
    }

    /**
     * update a record in string mode
     */
    public function updateByString($where, $data)
    {
        return $this->db->query(
                    $this->db->update_string($this->table, $data, $where)
                );
    }

    /**
     * Update batch data into table
     * 
     * @param  array $data
     * @return boolean
     */
    public function updateBatch($data, $by_field, $size = 100)
    {
        return $this->db->update_batch($this->table, $data, $by_field, $size);
    }

    /**
     * Truncate table function
     *
     * @param string $table
     * @return mixed
     */
    public function truncate($table = '')
    {
        if ($this->table && $table === '') {
            $table = $this->table;
        }

        return $this->db->truncate($table);
    }

    /**
     * Delete a record
     *
     * @usage   delete(12)
     *          delete('email', 'test@test.com')
     *          delete([
     *              'name' => 'ted',
     *              'age' => 25
     *          ]);
     *
     * @param   integer|string|array $idOrRow (Optional)
     *          number  = Delete primary key ID
     *          string  = Column Name
     *          array   = key/value pairs
     *
     * @param integer|string|array $optionalValue
     *              (Optional) Use when first param is string
     *
     * @return boolean result
     */
    public function delete($idOrRow, $optionalValue = null)
    {
        if ($optionalValue == null) {
            if (is_array($idOrRow)) {
                $this->db->where($idOrRow);
            } else {
                $this->db->where([$this->primaryKey => $idOrRow]);
            }
        } else {
            $this->db->where($idOrRow, $optionalValue);
        }

        return $this->db->delete($this->table);
    }

    /**
     * Do a soft delete
     *
     * @param array $data
     * @param array  $where
     * @return void
     */ 
    public function softDelete($where, $data)
    {
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }

    //------------------ Custom Method Functionalities --------------------------------------------------
    
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
        $this->db->where($field, $value);
        $query = $this->db->get($this->table);

        if ($query && $query->num_rows() == 0)
        {
            return true;
        }

        return false;

    }

    /**
	 * Left Join
	 *
	 * Do left join portion of the query
	 *
	 * @param	string  table to do join with
	 * @param	string	the join condition
	 * @param	string	whether not to try to escape identifiers
	 * @return	CI_DB_query_builder
	 */
	public function leftJoin($table, $condition, $escape = null)
    {
        $this->db->join($table, $condition, 'left', $escape);
        return $this;
    }

    /**
	 * Right Join
	 *
	 * Do left join portion of the query
	 *
	 * @param	string  table to do join with
	 * @param	string	the join condition
	 * @param	string	whether not to try to escape identifiers
	 * @return	CI_DB_query_builder
	 */
	public function rightJoin($table, $condition, $escape = null)
    {
        $this->db->join($table, $condition, 'right', $escape);
        return $this;
    }

    /**
	 * Inner Join
	 *
	 * Do left join portion of the query
	 *
	 * @param	string  table to do join with
	 * @param	string	the join condition
	 * @param	string	whether not to try to escape identifiers
	 * @return	CI_DB_query_builder
	 */
	public function innerJoin($table, $condition, $escape = null)
    {
        $this->db->join($table, $condition, 'inner', $escape);
        return $this;
    }

    /**
	 * Outer Join
	 *
	 * Do left join portion of the query
	 *
	 * @param	string  table to do join with
	 * @param	string	the join condition
	 * @param	string	whether not to try to escape identifiers
	 * @return	CI_DB_query_builder
	 */
	public function outerJoin($table, $condition, $escape = null)
    {
        $this->db->join($table, $condition, 'outer', $escape);
        return $this;
    }


    //------------------ CodeIgniter Database  Wrappers --------------------------------------------------
    
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
        $this->db->select($select, $escape); 
        return $this; 
    }

    /**
     * Select Maximum function
     *
     * @param string $select
     * @param string $alias
     * @return CI_DB_query_builder
     */
    public function selectMax($select = '', $alias = '') 
    { 
        $this->db->select_max($select, $alias); 
        return $this; 
    }

    /**
     * Select Minimum function
     *
     * @param string $select
     * @param string $alias
     * @return CI_DB_query_builder
     */
    public function selectMin($select = '', $alias = '') 
    { 
        $this->db->select_min($select, $alias); 
        return $this; 
    }

    /**
     * Select Average function
     *
     * @param string $select
     * @param string $alias
     * @return CI_DB_query_builder
     */
    public function selectAvg($select = '', $alias = '') 
    { 
        $this->db->select_avg($select, $alias); 
        return $this; 
    }

    /**
     * Select Sum function
     *
     * @param string $select
     * @param string $alias
     * @return CI_DB_query_builder
     */
    public function selectSum($select = '', $alias = '') 
    { 
        $this->db->select_sum($select, $alias); 
        return $this; 
    }

    /**
     * Distinct function
     *
     * @param boolean $value
     * @return CI_DB_query_builder
     */
    public function distinct($value = true) 
    { 
        $this->db->distinct($value); 
        return $this; 
    }

    /**
     * From function
     *
     * @param  string $from
     * @return CI_DB_query_builder
     */
    public function from($from) 
    { 
        $this->db->from($from); 
        return $this; 
    }

    /**
     * Join function
     *
     * Generates the JOIN portion of the query
	 *
     * @param   string $table table name
     * @param   string $condition the join condition
     * @param   string $type the type of join
	 * @param	string $escape whether not to try to escape identifiers
	 * @return	CI_DB_query_builder
     */
    public function join($table, $condition, $type = '', $escape = null) 
    { 
        $this->db->join($table, $condition, $type, $escape); 
        return $this; 
    }

    /**
     * Where function
     *
     * @param mixed $key
     * @param mixed $value
     * @param boolean $escape
     * @return CI_DB_query_builder
     */
    public function where($key, $value = null, $escape = true) 
    { 
        $this->db->where($key, $value, $escape); 
        return $this; 
    }

    /**
     * orWhere function
     *
     * @param mixed $key
     * @param mixed $value
     * @param boolean $escape
     * @return CI_DB_query_builder
     */
    public function orWhere($key, $value = null, $escape = true) { 
        $this->db->or_where($key, $value, $escape); 
        return $this; 
    }

    /**
     * whereIn function
     *
     * @param mixed $key
     * @param mixed $values
     * @return CI_DB_query_builder
     */
    public function whereIn($key = null, $values = null) 
    { 
        $this->db->where_in($key, $values); 
        return $this; 
    }

    /**
     * orWhereIn function
     *
     * @param mixed $key
     * @param mixed $values
     * @return CI_DB_query_builder
     */
    public function orWhereIn($key = null, $values = null) 
    { 
        $this->db->or_where_in($key, $values); 
        return $this; 
    }

    /**
     * whereNotIn function
     *
     * @param mixed $key
     * @param mixed $values
     * @return CI_DB_query_builder
     */
    public function whereNotIn($key = null, $values = null) 
    { 
        $this->db->where_not_in($key, $values); 
        return $this; 
    }

    /**
     * orWhereNotIn function
     *
     * @param mixed $key
     * @param mixed $values
     * @return CI_DB_query_builder
     */
    public function orWhereNotIn($key = null, $values = null) 
    { 
        $this->db->or_where_not_in($key, $values); 
        return $this; 
    }

    /**
     * Like function
     *
     * @param string $field
     * @param string $match
     * @param string $side
     * @return CI_DB_query_builder
     */
    public function like($field, $match = '', $side = 'both') 
    { 
        $this->db->like($field, $match, $side); 
        return $this; 
    }

    /**
     * notLike function
     *
     * @param string $field
     * @param string $match
     * @param string $side
     * @return CI_DB_query_builder
     */
    public function notLike($field, $match = '', $side = 'both') 
    { 
        $this->db->not_like($field, $match, $side); 
        return $this; 
    }

    /**
     * orLike function
     *
     * @param string $field
     * @param string $match
     * @param string $side
     * @return CI_DB_query_builder
     */
    public function orLike($field, $match = '', $side = 'both') 
    { 
        $this->db->or_like($field, $match, $side); 
        return $this;
    }

    /**
     * orNotLike function
     *
     * @param string $field
     * @param string $match
     * @param string $side
     * @return CI_DB_query_builder
     */
    public function orNotLike($field, $match = '', $side = 'both') 
    { 
        $this->db->or_not_like($field, $match, $side); 
        return $this; 
    }

    /**
     * groupBy function
     *
     * @param string $by
     * @return CI_DB_query_builder
     */
    public function groupBy($by, $escape = null) 
    { 
        $this->db->group_by($by, $escape); 
        return $this; 
    }

    /**
     * Having function
     *
     * @param mixed $key
     * @param string $value
     * @param boolean $escape
     * @return CI_DB_query_builder
     */
    public function having($key, $value = '', $escape = true) 
    { 
        $this->db->having($key, $value, $escape); 
        return $this; 
    }

    /**
     * orHaving function
     *
     * @param mixed $key
     * @param string $value
     * @param boolean $escape
     * @return CI_DB_query_builder
     */
    public function orHaving($key, $value = '', $escape = true) 
    { 
        $this->db->or_having($key, $value, $escape); 
        return $this; 
    }

    /**
     * orderBy function
     *
     * @param string $orderby
     * @param string $direction
     * @return CI_DB_query_builder
     */
    public function orderBy($orderby, $direction = '')
    { 
        $this->db->order_by($this->table.'.'.$orderby, $direction); 
        return $this; 
    }

    /**
     * Limit function
     *
     * @param mixed $value
     * @param string $offset
     * @return CI_DB_query_builder
     */
    public function limit($value, $offset = '') 
    { 
        $this->db->limit($value, $offset); 
        return $this; 
    }

    /**
     * Offset function
     *
     * @param mixed $offset
     * @return CI_DB_query_builder
     */
    public function offset($offset) 
    { 
        $this->db->offset($offset); 
        return $this; 
    }

    /**
     * Set key value
     *
     * @param mixed $key
     * @param string $value
     * @param boolean $escape
     * @return CI_DB_query_builder
     */
    public function set($key, $value = '', $escape = true) 
    { 
        $this->db->set($key, $value, $escape); 
        return $this; 
    }

}
/* end of file Core/core/Models/EasyModel.php */
