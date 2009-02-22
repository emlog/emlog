<?php
/**
 * 模型：友情链接
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id: comment.php 682 2008-10-14 16:08:01Z emloog $
 */


class emLink {

	var $dbhd;
	var $linkTable;

	function emLink($dbhandle)
	{
		$this->dbhd = $dbhandle;
		$this->linkTable = DB_PREFIX.'link';
	}

	function getLinks()
	{
		$res = $this->dbhd->query("SELECT * FROM $this->linkTable ORDER BY taxis ASC");
		$links = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['sitename'] = htmlspecialchars($row['sitename']);
			$row['description'] = subString(htmlClean($row['description'], false),0,80);
			$row['siteurl'] = $row['siteurl'];
			$links[] = $row;
		}
		return $links;
	}

	function updateLink($linkData, $linkId)
	{
		$Item = array();
		foreach ($linkData as $key => $data)
		{
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->dbhd->query("update $this->linkTable set $upStr where id=$linkId");
	}

	function addLink($name, $url, $des)
	{
		$sql="insert into $this->linkTable (sitename,siteurl,description) values('$name','$url','$des')";
		$this->dbhd->query($sql);
	}

	function getOneLink($linkId)
	{
		$sql = "select * from $this->linkTable where id=$linkId ";
		$res = $this->dbhd->query($sql);
		$row = $this->dbhd->fetch_array($res);
		$linkData = array();
		if($row)
		{
			$linkData = array(
			'sitename' => htmlspecialchars(trim($row['sitename'])),
			'siteurl' => htmlspecialchars(trim($row['siteurl'])),
			'description' => htmlspecialchars(trim($row['description']))
			);
		}
		return $linkData;
	}
	
	function deleteLink($linkId)
	{
		$this->dbhd->query("DELETE FROM $this->linkTable where id=$linkId");
	}

}

?>
