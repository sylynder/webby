<?php

/**
 * Schema
 *
 * Expressive table definitions
 *
 * @author 		Jamie Rumbelow <http://jamierumbelow.net>
 * @author      Kwame Oteng Appiah-Nti <http://developerkwame.com>
 * @version		1.0.0
 * @copyright 	(c)2011 Jamie Rumbelow
 * @copyright   (c)2022 Kwame Oteng Appiah-Nti
 */

namespace Base\Migrations;

use Base\Console\ConsoleColor;

class Schema
{

    /**
     * CI variable
     *
     * @var
     */
    protected static $ci;
    
    /**
     * Types variable
     *
     * @var array
     */
    public static $types = [
        'integer'     => 'INT',
        'int'         => 'INT',
        'bigint'      => 'BIGINT',
        'mediumint'   => 'MEDIUMINT',
        'tinyint'     => 'TINYINT',
        'decimal'     => 'DECIMAL',
        'float'       => 'FLOAT',
        'string'      => 'VARCHAR',
        'varchar'     => 'VARCHAR',
        'char'        => 'CHAR',
        'text'        => 'TEXT',
        'tinytext'    => 'TINYTEXT',
        'longtext'    => 'LONGTEXT',
        'blob'        => 'BLOB',
        'date'        => 'DATE',
        'datetime'    => 'DATETIME',
        'timestamp'   => 'TIMESTAMP',
        'boolean'     => 'TINYINT',
        'tinyint'     => 'TINYINT'
    ];

    public function __construct()
    {
        self::$ci = ci();
    }

    public static function ci()
    {
        return self::$ci = ci();
    }

    /**
     * Create Table Factory
     *
     * @param string $tableName
     * @param Closure $callback
     * @return mixed
     */
    public static function create(string $tableName, \Closure $callback)
    {
        $table = new \Base\Migrations\Table($tableName);

        if ($callback === false) {
            return $table;
        }

        $callback($table);
        $table->createTable();
        
    }

    public static function withSQL(string $query = '')
    {
        return static::ci()->db->query($query);
    }

    /**
     * Add Column
     *
     * @param string $table
     * @param string $name
     * @param string $type
     * @param array $options
     * @param string $afterColumn
     * @return mixed
     */
    public static function addColumn($table = '', $name = '', $type = '', $options = [], $afterColumn = '')
    {
        $column = [];

        if (isset(self::$types[strtolower($type)])) {
            $column = ['type' => self::$types[$type]];
        } elseif ($type == 'bigincrement') {
            $column = ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true];
        } elseif ($type == 'autoincrement') {
            $column = ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true];
        } elseif ($type == 'timestamps') {
            self::addColumn($table, 'created_at', 'datetime');
            self::addColumn($table, 'updated_at', 'datetime');
            return;
        }

        self::$ci->load->dbforge();

        self::$ci->dbforge->add_column($table, [$name => array_merge($column, $options)], $afterColumn);
    }

    /**
     * Remove Column
     *
     * @param string $table
     * @param string $name
     * @return void
     */
    public static function removeColumn($table = '', $name = '')
    {
        self::$ci->load->dbforge();

        self::$ci->dbforge->drop_column($table, $name);
    }

    /**
     * Rename Column
     *
     * @param  string $table
     * @param  string $name
     * @param  string $newName
     * @return void
     */
    public static function renameColumn($table = '', $name = '', $newName = '')
    {
        static::ci()->load->dbforge();

        $exists = self::$ci->db->field_exists($name, $table);
        
        if (!$exists) {
            echo ConsoleColor::yellow("The " . $name . " field does not exist in the '".$table. "' table \n");
            exit;
        }

        $fieldData = self::$ci->db->field_data($table);
        $types = [];
        $maxlengths = [];

        foreach ($fieldData as $column) {
            $types[$column->name] = $column->type;
            $maxlengths[$column->name] = $column->max_length;
        }

        static::ci()->dbforge->modify_column($table, [$name => ['name' => $newName, 'type' => $types[$name], 'constraint' => $maxlengths[$name]]]);
    }

    /**
     * Modify Column
     *
     * @param string $table
     * @param string $name
     * @param string $type
     * @param array $options
     * @return void
     */
    public static function modifyColumn($table = '', $name = '', $type = '', $options = [])
    {
        $column = ['type' => self::$types[strtolower($type)]];

        static::ci()->load->dbforge();

        static::ci()->dbforge->modify_column($table, [$name => array_merge($column, $options)]);
    }

    /**
     * Drop Table
     *
     * @param string $table
     * @return void
     */
    public static function dropTable($table, $ifExists = false)
    {
        static::ci()->dbforge->drop_table($table, $ifExists);
    }
}
