<?php
/**
 * 数据库操作类
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.5
 */

class MySql {

	var $queryCount = 0;
	var $conn;
	var $result;

	function MySql($dbHost = '', $dbUser = '', $dbPass = '', $dbName = '')
	{
		if(!$this->conn = @mysql_connect($dbHost, $dbUser, $dbPass))
		{
			sysMsg("连接数据库失败,可能是mysql数据库用户名或密码错误");
		}
		if($this->getMysqlVersion() >'4.1')
		{
			mysql_query("SET NAMES 'utf8'");
		}

		@mysql_select_db($dbName, $this->conn) OR sysMsg("未找到指定数据库");
	}

	/**
	 * 关闭数据库连接
	 *
	 * @return blooean
	 */
	function close()
	{
		return mysql_close($this->conn);
	}

	/**
	 * 发送查询语句
	 *
	 * @param string $sql
	 * @return blooean
	 */
	function query($sql)
	{
		$this->result = @ mysql_query($sql,$this->conn);
		$this->queryCount++;
		if(!$this->result)
		{
			sysMsg("SQL语句执行错误：$sql <br />".$this->geterror());
		} else {
			return $this->result;
		}
	}

	/**
	 * 从结果集中取得一行作为关联数组，或数字数组
	 *
	 * @param resource $query
	 * @return array
	 */
	function fetch_array($query)
	{
		return mysql_fetch_array($query);
	}
	
	/**
	 * 取得结果集中一条记录
	 *
	 * @param resource $query
	 * @return integer
	 */
	function fetch_row($query)
	{
		return mysql_fetch_row($query);
	}

	/**
	 * 取得行的数目
	 *
	 * @param resource $query
	 * @return integer
	 */
	function num_rows($query)
	{
		return mysql_num_rows($query);
	}

	/**
	 * 取得结果集中字段的数目
	 *
	 * @param resource $query
	 * @return integer
	 */
	function num_fields($query)
	{
		return mysql_num_fields($query);
	}
	/**
	 * 取得上一步 INSERT 操作产生的 ID 
	 *
	 * @return integer
	 */
	function insert_id()
	{
		return mysql_insert_id($this->conn);
	}
	function fetch_one_array($sql)
	{
		$this->result = $this->query($sql);
		return $this->fetch_array($query);
	}

	/**
	 * 获取mysql错误
	 *
	 * @return unknown
	 */
	function geterror()
	{
		return mysql_error();
	}

	/**
	 * 取得数据库版本信息
	 *
	 * @return string
	 */
	function getMysqlVersion()
	{
		return mysql_get_server_info();
	}
}

?>