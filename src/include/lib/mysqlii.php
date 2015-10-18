<?php
/**
 * MySQLi Database Operations
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class MySqlii {

    /**
     * Number of queries
     * @var int
     */
    private $queryCount = 0;

    /**
     * Internal data connection object
     * @var mysqli
     */
    private $conn;

    /**
     * Internal data result
     * @var mysqli_result
     */
    private $result;

    /**
     * Internal object instance
     * @var object MySql
     */
    private static $instance = null;

    private function __construct() {
        if (!class_exists('mysqli')) {
/*vot*/     emMsg(lang('mysqli_not_supported'));
        }

        @$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);

        if ($this->conn->connect_error) {
            switch ($this->conn->connect_errno) {
                case 1044:
                case 1045:
/*vot*/             emMsg(lang('db_credential_error'));
                    break;

                case 1049:
/*vot*/             emMsg(lang('db_not_found'));
                    break;

                case 2003:
/*vot*/             emMsg(lang('db_port_invalid'));
                    break;

                case 2005:
/*vot*/             emMsg(lang('db_unavailable'));
                    break;

                case 2006:
/*vot*/             emMsg(lang('db_server_unavailable'));
                    break;

                default :
/*vot*/             emMsg(lang('db_error_code') . $this->conn->connect_errno);
                    break;
            }
        }

        $this->conn->set_charset('utf8');
    }

    /**
     * Static method that returns the database connection instance
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new MySqlii();
        }

        return self::$instance;
    }

    /**
     * Close database connection
     */
    function close() {
        return $this->conn->close();
    }

    /**
     * Send query statement
     */
    function query($sql, $ignore_err = FALSE) {
        $this->result = $this->conn->query($sql);
        $this->queryCount++;
        if (!$ignore_err && 1046 == $this->geterrno()) {
/*vot*/     emMsg(lang('db_error_name'));
        }
        if (!$ignore_err && !$this->result) {
/*vot*/     emMsg(lang('db_sql_error'). ": {$sql}<br />" . $this->geterror());
        } else {
            return $this->result;
        }
    }

    /**
     * Fetch a row as an associative array / array results from a numerical index
     */
    function fetch_array(mysqli_result $query, $type = MYSQLI_ASSOC) {
        return $query->fetch_array($type);
    }

    function once_fetch_array($sql) {
        $this->result = $this->query($sql);
        return $this->fetch_array($this->result);
    }

    /**
     * Fetch a row as an array of results from a numerical index
     */
    function fetch_row(mysqli_result $query) {
        return $query->fetch_row();
    }

    /**
     * The number of rows obtained
     *
     */
    function num_rows(mysqli_result $query) {
        return $query->num_rows;
    }

    /**
     * Get the number of fields in the result set
     */
    function num_fields(mysqli_result $query) {
        return $query->field_count;
    }

    /**
     * Get the last ID generated from the previous INSERT operation
     */
    function insert_id() {
        return $this->conn->insert_id;
    }

    /**
     * Get mysql error
     */
    function geterror() {
        return $this->conn->error;
    }

    /**
     * Get mysql error code
     */
    function geterrno() {
        return $this->conn->errno;
    }

    /**
     * Get number of affected rows in previous MySQL operation
     */
    function affected_rows() {
        return $this->conn->affected_rows;
    }

    /**
     * Get database version
     */
    function getMysqlVersion() {
        return $this->conn->server_info;
    }

    /**
     * Get the number of database queries
     */
    function getQueryCount() {
        return $this->queryCount;
    }

    /**
     *  Escapes special characters
     */
    function escape_string($sql) {
        return $this->conn->real_escape_string($sql);
    }
}
