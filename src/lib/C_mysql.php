<?php
/**
 * Database operations
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */


/**
 * MYSQL data manipulation methods
 * 
 */

class MySql {

	var $queryCount = 0;
	var $conn;
	var $result;

	function MySql($dbHost = '', $dbUser = '', $dbPass = '', $dbName = '')
	{
		global $lang;
		if (!function_exists('mysql_connect'))
		{
			emMsg($lang['mysql_not_supported']);
		}
		if (!$this->conn = @mysql_connect($dbHost, $dbUser, $dbPass))
		{
			emMsg($lang['db_connect_error']);
		}
		if ($this->getMysqlVersion() >'4.1')
		{
			mysql_query("SET NAMES 'utf8'");
		}

		@mysql_select_db($dbName, $this->conn) OR emMsg($lang['db_not_found']);
	}

	/**
	 * Close database connection
	 *
	 * @return boolean
	 */
	function close()
	{
		return mysql_close($this->conn);
	}

	/**
	 * Send query
	 *
	 * @param string $sql
	 * @return boolean
	 */
	function query($sql)
	{
		$this->result = @ mysql_query($sql,$this->conn);
		$this->queryCount++;
		if (!$this->result)
		{
			emMsg($lang['sql_statement_error'].": $sql <br />".$this->geterror());
		} else {
			return $this->result;
		}
	}

	/**
	 * Get a result row as an associative array
	 *
	 * @param resource $query
	 * @return array
	 */
	function fetch_array($query)
	{
		return mysql_fetch_array($query);
	}

	function once_fetch_array($sql)
	{
		$this->result = $this->query($sql);
		return $this->fetch_array($this->result);
	}
	
	/**
	 * Get a result row as an array
	 *
	 * @param resource $query
	 * @return integer
	 */
	function fetch_row($query)
	{
		return mysql_fetch_row($query);
	}

	/**
	 * Get a number of resulting rows
	 *
	 * @param resource $query
	 * @return integer
	 */
	function num_rows($query)
	{
		return mysql_num_rows($query);
	}

	/**
	 * Get a number of fields
	 *
	 * @param resource $query
	 * @return integer
	 */
	function num_fields($query)
	{
		return mysql_num_fields($query);
	}

	/**
	 * Get the last ID generated after INSERT operation
	 *
	 * @return integer
	 */
	function insert_id()
	{
		return mysql_insert_id($this->conn);
	}

	/**
	 * Get mysql error
	 *
	 * @return unknown
	 */
	function geterror()
	{
		return mysql_error();
	}
	
	/**
	 * Get number of affected rows in previous MySQL operation
	 *
	 * @return int
	 */
	function affected_rows()
	{
		return mysql_affected_rows();
	}

	/**
	 * Get MySQL Version
	 *
	 * @return string
	 */
	function getMysqlVersion()
	{
		return mysql_get_server_info();
	}
}

?>