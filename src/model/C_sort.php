<?php
/**
 * 模型：日志分类
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */


class emSort {

	var $dbhd;
	var $sortTable;

	function emSort($dbhandle)
	{
		$this->dbhd = $dbhandle;
		$this->sortTable = DB_PREFIX.'sort';
	}

	function getSorts()
	{
		$res = $this->dbhd->query("SELECT * FROM $this->sortTable ORDER BY taxis ASC");
		$sorts = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['sortname'] = htmlspecialchars($row['sortname']);
			$sorts[] = $row;
		}
		return $sorts;
	}

	function updateSort($sortData, $sid)
	{
		$Item = array();
		foreach ($sortData as $key => $data)
		{
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->dbhd->query("update $this->sortTable set $upStr where sid=$sid");
	}

	function addSort($name)
	{
		$sql="insert into $this->sortTable (sortname) values('$name')";
		$this->dbhd->query($sql);
	}
	
	function deleteSort($sid)
	{
		$this->dbhd->query("DELETE FROM $this->sortTable where sid=$sid");
	}

}

?>
