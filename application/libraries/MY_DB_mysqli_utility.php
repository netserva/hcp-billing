<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * CodeIgniter.
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 *
 * @see		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * MySQLi Utility Class.
 *
 * @category	Database
 *
 * @author		ExpressionEngine Dev Team
 *
 * @see		http://codeigniter.com/user_guide/database/
 */
class MY_DB_mysqli_utility extends CI_DB_utility
{
    /**
     * List databases.
     *
     * @return bool
     */
    public function _list_databases()
    {
        return 'SHOW DATABASES';
    }

    // --------------------------------------------------------------------

    /**
     * Optimize table query.
     *
     * Generates a platform-specific query so that a table can be optimized
     *
     * @param	string	the table name
     * @param mixed $table
     *
     * @return object
     */
    public function _optimize_table($table)
    {
        return 'OPTIMIZE TABLE '.$this->db->_escape_identifiers($table);
    }

    // --------------------------------------------------------------------

    /**
     * Repair table query.
     *
     * Generates a platform-specific query so that a table can be repaired
     *
     * @param	string	the table name
     * @param mixed $table
     *
     * @return object
     */
    public function _repair_table($table)
    {
        return 'REPAIR TABLE '.$this->db->_escape_identifiers($table);
    }

    // --------------------------------------------------------------------

    /**
     * MySQLi Export.
     *
     * @param	array	Preferences
     * @param mixed $params
     *
     * @return mixed
     */
    public function _backup($params = [])
    {
        if (0 == count($params)) {
            return false;
        }

        // Extract the prefs for simplicity
        extract($params);

        // Build the output
        $output = '';
        foreach ((array) $tables as $table) {
            // Is the table in the "ignore" list?
            if (in_array($table, (array) $ignore, true)) {
                continue;
            }

            // Get the table schema
            $query = $this->db->query('SHOW CREATE TABLE `'.$this->db->database.'`.`'.$table.'`');

            // No result means the table name was invalid
            if (false === $query) {
                continue;
            }

            // Write out the table schema
            $output .= '#'.$newline.'# TABLE STRUCTURE FOR: '.$table.$newline.'#'.$newline.$newline;

            if (true == $add_drop) {
                $output .= 'DROP TABLE IF EXISTS '.$table.';'.$newline.$newline;
            }

            $i = 0;
            $result = $query->result_array();
            foreach ($result[0] as $val) {
                if ($i++ % 2) {
                    $output .= $val.';'.$newline.$newline;
                }
            }

            // If inserts are not needed we're done...
            if (false == $add_insert) {
                continue;
            }

            // Grab all the data from the current table
            $query = $this->db->query("SELECT * FROM {$table}");

            if (0 == $query->num_rows()) {
                continue;
            }

            // Fetch the field names and determine if the field is an
            // integer type.  We use this info to decide whether to
            // surround the data with quotes or not

            $i = 0;
            $field_str = '';
            $is_int = [];
            while ($field = mysqli_fetch_field($query->result_id)) {
                // Most versions of MySQL store timestamp as a string
                $is_int[$i] = (
                    in_array(
                    strtolower($field->type),
                    ['tinyint', 'smallint', 'mediumint', 'int', 'bigint'], //, 'timestamp'),
                    true
                )
                ) ? true : false;

                // Create a string of field names
                $field_str .= '`'.$field->name.'`, ';
                ++$i;
            }

            // Trim off the end comma
            $field_str = preg_replace('/, $/', '', $field_str);

            // Build the insert string
            foreach ($query->result_array() as $row) {
                $val_str = '';

                $i = 0;
                foreach ($row as $v) {
                    // Is the value NULL?
                    if (null === $v) {
                        $val_str .= 'NULL';
                    } else {
                        // Escape the data if it's not an integer
                        if (false == $is_int[$i]) {
                            $val_str .= $this->db->escape($v);
                        } else {
                            $val_str .= $v;
                        }
                    }

                    // Append a comma
                    $val_str .= ', ';
                    ++$i;
                }

                // Remove the comma at the end of the string
                $val_str = preg_replace('/, $/', '', $val_str);

                // Build the INSERT string
                $output .= 'INSERT INTO '.$table.' ('.$field_str.') VALUES ('.$val_str.');'.$newline;
            }

            $output .= $newline.$newline;
        }

        return $output;
    }
}

// End of file mysqli_utility.php
// Location: ./system/database/drivers/mysqli/mysqli_utility.php
