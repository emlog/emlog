<?php
/**
 * 数据库操作类
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

class MySql {
         
	var $user,$pass,$host,$db;
	var $id,$data,$fields,$row,$row_num,$insertid,$version,$query_num=0;
	
	function MySql($host,$user,$pass,$db)
	{
		$this->host = $host;
		$this->pass = $pass;
		$this->user = $user;
		$this->db = $db;
		$this->dbconnect($this->host, $this->user, $this->pass);
		$this->selectdb($this->db);
		if($this->version() >'4.1')
			mysql_query("SET NAMES 'utf8'");
	}
	function dbconnect($host,$user,$pass)
	{
			$this->id = @ mysql_connect($host,$user,$pass) OR
			sysMsg("连接数据库失败,可能是mysql数据库用户名或密码错误");
	}
	function selectdb($db)
	{
		@ mysql_select_db($db,$this->id) or sysMsg("未找到指定数据库");
	}

	function query($sql)
	{
		$query = @ mysql_query($sql,$this->id);
			$this->query_num();
			return $query;
	}
		
	function fetch_array($query)
	{
			$this->data = @mysql_fetch_array($query);
			return $this->data;
	}
	function query_num()
	{
			$this->query_num++;
	}
	function num_fields($query)
	{
			$this->fields = @mysql_num_fields($query);
			return $this->fields;
	}
	function fetch_row($query)
	{
			$this->row = @mysql_fetch_row($query);
			return $this->row;
	}

	function num_rows($query)
	{
			$this->row_num = @mysql_num_rows($query);
			return $this->row_num;
	}
			
	function insert_id()
	{
			$this->insertid = mysql_insert_id();
			return $this->insertid;
	}
	function version()
	{
			$this->version = mysql_get_server_info();
			return $this->version;
	}
	function fetch_one_array($sql)
	{
			$query = $this->query($sql);
			$this->data = $this->fetch_array($query);
			return $this->data;
	}
	function geterror()
	{
		return mysql_error();
	}
}
     
?>