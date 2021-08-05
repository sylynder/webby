<?php

namespace Base\Models;

/**
 * A base model to provide basic actions for all models that inherit from it.
 * Inspired by Joost van Veen @codeigniter.tv and
 * Jesse Boyer @jream.com
 * Expanded by Me (Oteng Kwame Appiah Nti)
 * I think this wil be useful :)
 * Note it is not well documented.
 *
 * @author  Oteng Kwame Appiah Nti <developerkwame@gmail.com>
 * @license MIT
 * @link    <link will be here>
 * @version 1.0
 */

class BaseModel extends \CI_Model
{

    public $database;

    public $table;

    public $primary_key = 'id';

    public $where;

    public $order;

    public $column_order;

    public $column_search;

    /**
     * Support for soft deletes and this model's 'deleted' key
     */
    protected $soft_delete = false;
    protected $soft_delete_key = 'is_deleted';
    protected $temporary_with_deleted = false;
    protected $temporary_only_deleted = false;

    public $ci;

    /**
     * Change the fetch mode if desired
     *
     * @var string $fetch_mode Optionally set to 'object', default is array
     */
    protected $fetch_mode = 'object';

    /**
     * Construct the CI_Model
     */
    public function __construct()
    {
        parent::__construct();
        //$this->database = $this->db;
    }

    //This function is used to escape data in codeigniter
    public function escape(string $string)
    {
        return $this->db->escape($string);
    }

    //This function is to display sql query in the browser
    public function showQuery()
    {
        return $this->db->last_query();
    }

    //All functions below are used for retrieving information from the database
    public function makeDatableQuery()
    {

        $this->db->from($this->table);
        $this->db->where($this->where);

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        $_POST = xss_clean($_POST);
        $i = 0;

        foreach ($this->column_search as $item) // loop column
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

                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }
                //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function makeDatatable()
    {
        $this->makeDatableQuery();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countFilteredWhere()
    {
        $this->makeDatableQuery();
        $query = $this->db->get($this->where);
        return $query->num_rows();
    }

    public function countFiltered()
    {
        $this->makeDatableQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->from($this->table);

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
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

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /*
    Limit by
     */
    public function setLimit($limit)
    {
        return $this->db->limit($limit);
    }

    public function setLimitStart($limit, $start)
    {
        return $this->db->limit($limit, $start);
    }

    /*
     *Order by
     */
    public function orderBy($field, $by)
    {
        return $this->db->order_by($field, $by);
    }

    public function lastInsertKey($primary_key = null)
    {
        if ($this->primary_key != null && $primary_key == null) {
            $primary_key = $this->primary_key;
        }

        $this->db->select_max("{$primary_key}");

        $result = $this->db->get($this->table)->row_array();
        return $result[$primary_key];
    }

    public function lastInsertId()
    {
        return $this->db->insert_id();
    }

    public function query($query)
    {
        return $this->db->query($query);
    }

    public function joinTable($table, $cond, $type = '', $escape = null)
    {
        return $this->db->join($table, $cond, $type, $escape);
    }

    public function getResult($query)
    {
        if ($this->fetch_mode == 'array') {
            return $query->result_array();
        } else {
            return $query->result();
        }
    }

    public function groupBy($by, $escape = null)
    {
        return $this->db->group_by($by, $escape);
    }

    public function having($key, $value = null, $escape = null)
    {
        return $this->db->having($key, $value, $escape);
    }

    /**
     * Grabs data from a table
     *       OR a single record by passing $id,
     *       OR a different field than the primary_key by passing two paramters
     *       OR by passing an array
     *
     * @param integer|string $id_or_row      (Optional)
     *                                       null    = Fetch all table records
     *                                       number  = Fetch where primary key = $id
     *                                       string  = Fetch based on a different column name
     *                                       array   = Fetch based on array criteria
     *
     * @param integer|string $optional_value (Optional)
     * @param string         $order_by (Optional)
     *
     * @return object database results
     */
    public function get($id_or_row = null, $optional_value = null, $order_by = null)
    {

        // Custom order by if desired
        if ($order_by != null) {
            $this->db->order_by($order_by);
        }

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        // Fetch all records for a table
        if ($id_or_row == null) {
            $query = $this->db->get($this->table);
        } elseif (is_array($id_or_row)) {
            $query = $this->db->get_where($this->table, $id_or_row);
        } else {
            if ($optional_value == null) {
                $query = $this->db->get_where($this->table, array($this->primary_key => $id_or_row));
            } else {
                $query = $this->db->get_where($this->table, array($id_or_row => $optional_value));
            }
        }

        if ($this->fetch_mode == 'array') {
            return $query->result_array();
        } else {
            return $query->result();
        }
    }

    public function getSomeFields($fields, $where = null, $limit = null, $order_by = null)
    {
        
        // Custom order by if desired
        if ($order_by != null) {
            $this->db->order_by($order_by);
        }

        if ($limit != null) {
            $this->db->select($fields)->from($this->table)->where($where)->limit($limit);
        } else if ($where != null) {
            $this->db->select($fields)->from($this->table)->where($where);
        } else {
            $this->db->select($fields)->from($this->table);
        }

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        $query = $this->db->get();

        if ($this->fetch_mode == 'array') {
            return $query->result_array();
        } else {
            return $query->result();
        }
    }

    /**
     *
     * @param string or array $field
     * @param string or array $value
     * @param string or array $orwhere
     * @param string $single
     * @return array
     */
    public function getSomeOrWhere($fields, $where = null, $or_where = null, $limit = null, $order_by = null)
    {

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        // Custom order by if desired
        if ($order_by != null) {
            $this->db->order_by($order_by);
        }

        if ($limit != null) {
            $this->db->select($fields)->from($this->table)->where($where)->limit($limit);
        } else if ($where != null) {
            $this->db->select($fields)->from($this->table)->where($where);
        } else {
            $this->db->select($fields)->from($this->table);
        }

        if ($or_where != null) {
            $this->db->or_where($or_where);
        }

        $query = $this->db->get();

        if ($this->fetch_mode == 'array') {
            return $query->result_array();
        } else {
            return $query->result();
        }
        
    }

    public function getSomeFieldsLimit($fields, $limit = null, $where = null)
    {

        if ($where != null) {
            $this->db->select($fields)->from($this->table)->limit($limit);
            $this->db->where($where);
        } else if ($limit != null) {
            $this->db->select($fields)->from($this->table)->limit($limit);
        }

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        $query = $this->db->get();

        if ($this->fetch_mode == 'array') {
            return $query->result_array();
        } else {
            return $query->result();
        }
    }

    /**
     * Get data by a single field or many fields
     * an alternative to the above function
     * @see get(...param)
     * @param array $field
     * @return array
     */
    public function getByFields($value)
    {
        $this->db->select()->from($this->table)->where($value);

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        $query = $this->db->get();
        
        if ($this->fetch_mode == 'object') {
            return $query->first_row('object');
        } else {
            return $query->first_row('array');
        }
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

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        $query = $this->db->get();

        if ($this->fetch_mode == 'object') {
            return $query->first_row('object');
        } else {
            return $query->first_row('array');
        }
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

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        $query = $this->db->get();

        if ($this->fetch_mode == 'object') {
            return $query->first_row('object');
        } else {
            return $query->first_row('array');
        }
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

        if ($this->soft_delete && $this->temporary_with_deleted !== true) {
            $this->db->where($this->soft_delete_key, (bool) $this->temporary_only_deleted);
        }

        $query = $this->db->get();
        if ($this->fetch_mode == 'object') {
            return $query->last_row('object');
        } else {
            return $query->last_row('array');
        }
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
            return $this->selectLast($this->primary_key); //get inserted data
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
     * @param  array $data
     * @return boolean
     */
    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    /**
     * Insert if not exists, if exists Update
     *
     * @usage   insertUpdate(['item' => 10], 25)
     *          insertUpdate(['item' => 10], 'other_key' => 25)
     *
     * @param array $data Associative array [column => value]
     *
     * @param   integer|string $id_or_row (Optional)
     *           null    = Fetch all table records
     *           number  = Fetch where primary key = $id
     *           string  = Fetch based on a different column name
     *
     * @param integer|string $optional_value (Optional)
     *
     * @return integer InsertID|Update Result
     */
    public function insertUpdate($id_or_row, $optional_value = null, $data)
    {
        // First check to see if the field exists
        $this->db->select($this->primary_key);

        if ($optional_value == null) {
            $query = $this->db->get_where($this->table, array($this->primary_key => $id_or_row));
        } else {
            $query = $this->db->get_where($this->table, array($id_or_row => $optional_value));
        }

        // Count how many records exist with this ID
        $result = $query->num_rows();

        // INSERT
        if ($result == 0) {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }

        // UPDATE
        if ($optional_value == null) {
            $this->db->where($this->primary_key, $id_or_row);
        } else {
            $this->db->where($id_or_row, $optional_value);
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
     * @param  integer  $id_or_row (Optional)
     * @param  array    $data
     *
     * @return    boolean result
     */
    public function update($id_or_row, $optional_value = null, $data)
    {
        if ($optional_value == null) {
            if (is_array($id_or_row)) {
                $this->db->where($id_or_row);
            } else {
                $this->db->where(array($this->primary_key => $id_or_row));
            }
        } else {
            $this->db->where(array($id_or_row => $optional_value));
        }

        return $this->db->update($this->table, $data);
    }

    /**
     * update a record
     */
    public function simpleUpdate($data, $where)
    {
        //$this->db->set($data);
        //dd($this->table);
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }

    /**
     * update a record
     */
    public function simpleSetUpdate($data, $where)
    {
        $this->db->where($where);
        $this->db->set($data, false);
        return $this->db->update($this->table);
    }

    /**
     * update a record in string mode
     */
    public function updateByString($data, $where)
    {
        return $this->db->query($this->db->update_string($this->table, $data, $where));
    }

    /**
     * Update Batch data into table
     * @param  array $data
     * @return boolean
     */
    public function updateBatch($data, $filter_field)
    {
        return $this->db->update_batch($this->table, $data, $filter_field);
    }

    /**
     * Where update batch
     * @param [[Type]] array $data    [[Description]]
     * @param [[Type]] string $index  [[Description]]
     * @param [[Type]] mixed $value         [[Description]]
     * @param [[Type]] string $filter [[Description]]
     */
    public function updateBatchWhere(array $data, string $index, $value, string $filter)
    {
        $this->db->where($index, $value);
        $this->db->update_batch($this->table, $data, $filter);
    }

    /**
     * Delete a record
     *
     * @usage   delete(12)
     *          delete('email', 'test@test.com')
     *          delete(array(
     *              'name' => 'ted',
     *              'age' => 25
     *          ));
     *
     * @param   integer|string|array $id_or_row (Optional)
     *          number  = Delete primary key ID
     *          string  = Column Name
     *          array   = key/value pairs
     *
     * @param integer|string|array $optional_value
     *              (Optional) Use when first param is string
     *
     * @return boolean result
     */
    public function delete($id_or_row, $optional_value = null)
    {
        if ($optional_value == null) {
            if (is_array($id_or_row)) {
                $this->db->where($id_or_row);
            } else {
                $this->db->where(array($this->primary_key => $id_or_row));
            }
        } else {
            $this->db->where($id_or_row, $optional_value);
        }

        return $this->db->delete($this->table);
    }

    public function softDelete($data, $where)
    {
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }

}
