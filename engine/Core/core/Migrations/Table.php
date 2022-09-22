<?php

 /**
 * Schema Table Definition
 * 
 * This class helps to define tables
 * and it's columns 
 *
 * @author      Kwame Oteng Appiah-Nti <http://developerkwame.com>
 * @version		1.0.0
 * @copyright   (c)2022 Kwame Oteng Appiah-Nti
 */

namespace Base\Migrations;

use Base\Migrations\Types;
use Base\Console\ConsoleColor;

class Table
{

    /**
     * CI variable
     *
     * @var
     */
    protected $ci;
    
    /**
     * Table Name variable
     *
     * @var string
     */
    protected $name = '';

    /**
     * Definition variable
     *
     * @var array
     */
    protected $definition = [
        'columns' => [],
        'keys' => []
    ];

    protected $null = false;

    public function __construct($tableName = '')
    {
        $this->name = $tableName;
        $this->ci = ci();
        $this->ci->load->dbforge();
    }

    /**
     * Make column nullable
     *
     * @return Table
     */
    public function nulled()
    {
        $this->null = true;

        return $this;
    }

    /**
     * Columns
     *
     * @return
     */
    public function columns()
    {
        return $this->definition['columns'];
    }

    /**
     * Keys
     *
     * @return
     */
    public function keys()
    {
        return $this->definition['keys'];
    }

    /**
     * Table Name
     *
     * @return string
     */
    public function tableName()
    {
        return $this->name;
    }

    /**
     * Create Table
     *
     * @return mixed
     */
    public function createTable()
    {
        $this->ci->dbforge->add_field($this->columns());

        foreach ($this->keys() as $key => $primary) {
            $this->ci->dbforge->add_key($key, $primary);
        }

        if (!$this->tableExists($this->tableName())) {
            $this->ci->dbforge->create_table($this->tableName());
            return true;
        }

        return false;

    }

    /**
     * Table Exists
     *
     * @param string $table
     * @return bool
     */
    public function tableExists($table)
    {
        return $this->ci->db->table_exists($table) ? true : false;
    }

    /* ---------------------------------Column Methods---------------------------------- */

    public function define($definition)
    {
		$this->ci->dbforge->add_field($definition);
    }

    public function field($columnName, $type = Types::VARCHAR, $attributes = [], $options = [])
    {
        $type = strtoupper($type);
        $attributes = array_merge(['type' => $type], $attributes);
        $this->addDefinitionRule($columnName, $attributes, $options);
    }

    public function integer($columnName, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::INT
        ], $options);
    }

    public function tinyint($columnName, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::TINYINT
        ], $options);
    }

    public function decimal($columnName, $constraint = '10,2', $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::DECIMAL,
            'constraint' => $constraint,
            'unsigned'  => false
        ], $options);
    }

    public function autoincrement($columnName, $options = [])
    {
        $this->integer($columnName, array_merge([
            'unsigned' => true,
            'auto_increment' => true
        ], $options));

        $this->key($columnName, true);
    }

    public function string($columnName, $constraint = 200, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::VARCHAR,
            'constraint' => $constraint
        ], $options);
    }

    public function varchar($columnName, $constraint = 200, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::VARCHAR,
            'constraint' => $constraint
        ], $options);
    }

    public function char($columnName, $constraint = 2, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::CHAR,
            'constraint' => $constraint
        ], $options);
    }

    public function text($columnName, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::TEXT
        ], $options);
    }

    public function longtext($columnName, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::LONGTEXT
        ], $options);
    }

    public function boolean($columnName, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::BOOLEAN
        ], $options);
    }

    public function date($columnName, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::DATE
        ], $options);
    }

    public function datetime($columnName, $options = [])
    {
        $this->addDefinitionRule($columnName, [
            'type' => Types::DATETIME
        ], $options);
    }

    public function timestamps($options = [], $deletedAt = false)
    {
        $this->datetime('created_at', $options);
        $this->datetime('updated_at', $options);

        if ($deletedAt) {
            $this->datetime('deleted_at', $options);
        } 
    }

    public function datetimes($options = [], $deletedAt = false)
    {
        $this->datetime('created_at', $options);
        $this->datetime('updated_at', $options);

        if ($deletedAt) {
            $this->datetime('deleted_at', $options);
        }
    }

    public function useractions($constraint = 40, $options = [], $deletedBy = false)
    {
        $this->createdby($constraint, $options);
        $this->updatedby($constraint, $options);

        if ($deletedBy) {
            $this->deletedby($constraint, $options);
        }
    }

    public function createdby($constraint = 40, $options = [], $columnName = 'created_by')
    {
        $this->field($columnName, Types::VARCHAR, [
            'constraint' => $constraint,
            'null' => true,
            'default' => null
        ], $options);
    }

    public function updatedby($constraint = 40, $options = [], $columnName = 'updated_by')
    {
        $this->field($columnName, Types::VARCHAR, [
            'constraint' => $constraint,
            'null' => true,
            'default' => null
        ], $options);
    }

    public function deletedby($constraint = 40, $options = [], $columnName = 'deleted_by')
    {
        $this->field($columnName, Types::VARCHAR,[
            'constraint' => $constraint,
            'null' => true,
            'default' => null
        ], $options);
    }

    /* ---------------------------------Helper Methods---------------------------------- */

    public function primaryKey($columnName)
    {
        $this->key($columnName, true);
    }

    public function key($columnName, $primary = false)
    {
        $this->definition['keys'][$columnName] = $primary;
    }

    public function addDefinitionRule($columnName, $rule, $options)
    {
        if (
            array_key_exists('null', $options) 
            || array_key_exists('null', $rule)
        ) {
            $options = array_merge(['default' => null], $options);
        }

        if (array_key_exists('length', $options) ) {
            $options = array_merge(['constraint' => $options['length']], $options);
            unset($options['length']);
        }

        $this->definition['columns'][$columnName] = array_merge($rule, $options);
    }
}
