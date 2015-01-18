<?php
/**
 * MySQL data manipulation methods encapsulated class
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class MySql {

    /**
	 * Number of queries
     * @var int
     */
    private $queryCount = 0;

    /**
	 * Internal data connection object
     * @var resourse
     */
    private $conn;

    /**
	 * Internal data result
     * @var resourse
     */
    private $result;

    /**
	 * Internal instance of an object
     * @var object MySql
     */
    private static $instance = null;

    private function __construct() {
        if (!function_exists('mysql_connect')) {
/*vot*/			emMsg(lang('php_mysql_not_supported'));
        }
        if (!$this->conn = @mysql_connect(DB_HOST, DB_USER, DB_PASSWD)) {
            switch ($this->geterrno()) {
                case 2005:
/*vot*/             emMsg(lang('db_database_unavailable'));
                    break;
                case 2003:
/*vot*/             emMsg(lang('db_port_invalid'));
                    break;
                case 2006:
/*vot*/             emMsg(lang('db_server_unavailable'));
                    break;
                case 1045:
/*vot*/             emMsg(lang('db_credential_error'));
                    break;
                default :
/*vot*/             emMsg(lang('db_error_code') . $this->geterrno());
                    break;
            }
        }
        if ($this->getMysqlVersion() > '4.1') {
            mysql_query("SET NAMES 'utf8'");
        }
/*vot*/		@mysql_select_db(DB_NAME, $this->conn) OR emMsg(lang('db_not_found'));
    }

    /**
	 * Static method, Returns the database connection instance
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new MySql();
        }
        return self::$instance;
    }

    /**
	 * Close database connection
     */
    function close() {
        return mysql_close($this->conn);
    }

    /**
	 * Send query
     *
     */
    function query($sql, $ignore_err = FALSE) {
        $this->result = @mysql_query($sql, $this->conn);
        $this->queryCount++;
        if (!$ignore_err && !$this->result) {
/*vot*/			emMsg(lang('db_sql_error').": $sql <br />" . $this->geterror());
        }else {
            return $this->result;
        }
    }

    /**
	 * Get a result row as an associative array
     *
     */
    function fetch_array($query , $type = MYSQL_ASSOC) {
        return mysql_fetch_array($query, $type);
    }

    function once_fetch_array($sql) {
        $this->result = $this->query($sql);
        return $this->fetch_array($this->result);
    }

    /**
	 * Get a result row as an array
     *
     */
    function fetch_row($query) {
        return mysql_fetch_row($query);
    }

    /**
	 * Get the number of result rows
     *
     */
    function num_rows($query) {
        return mysql_num_rows($query);
    }

    /**
	 * Get the number of fields in the result set
     */
    function num_fields($query) {
        return mysql_num_fields($query);
    }
    /**
	 * Get the ID generated from the previous INSERT operation
     */
    function insert_id() {
        return mysql_insert_id($this->conn);
    }

    /**
	 * Get mysql error
     */
    function geterror() {
        return mysql_error();
    }

    /**
	 * Get mysql error number
     */
    function geterrno() {
        return mysql_errno();
    }

    /**
     * Get number of affected rows in previous MySQL operation
     */
    function affected_rows() {
        return mysql_affected_rows();
    }

    /**
	 * Get MySQL Version
     */
    function getMysqlVersion() {
        return mysql_get_server_info();
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
        return mysql_real_escape_string($sql);
    }
}
