<?php
/**
 * 模型：日志分类
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

class emSort {

	var $dbhd;

	function emSort($dbhandle)
	{
		$this->dbhd = $dbhandle;
	}

	function getSorts()
	{
		$res = $this->dbhd->query("SELECT * FROM ".DB_PREFIX."sort ORDER BY taxis ASC");
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
		$this->dbhd->query("update ".DB_PREFIX."sort set $upStr where sid=$sid");
	}

	function addSort($name)
	{
		$sql="insert into ".DB_PREFIX."sort (sortname) values('$name')";
		$this->dbhd->query($sql);
	}
	
	function deleteSort($sid)
	{
		$this->dbhd->query("update ".DB_PREFIX."blog set sortid=-1 where sortid=$sid");
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."sort where sid=$sid");
	}
}

?>
