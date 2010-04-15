<?php
/**
 * 友情链接
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.0
 * $Id$
 */

class emLink {
	/**
	 * 内部数据对象
	 * @var MySql
	 */
	private $db;

	function __construct()
	{
		$this->db = MySql::getInstance();
	}

	function getLinks()
	{
		$res = $this->db->query("SELECT * FROM ".DB_PREFIX."link ORDER BY taxis ASC");
		$links = array();
		while($row = $this->db->fetch_array($res))
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
		$this->db->query("update ".DB_PREFIX."link set $upStr where id=$linkId");
	}

	function addLink($name, $url, $des)
	{
		$sql="insert into ".DB_PREFIX."link (sitename,siteurl,description) values('$name','$url','$des')";
		$this->db->query($sql);
	}

	function getOneLink($linkId)
	{
		$sql = "select * from ".DB_PREFIX."link where id=$linkId ";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
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
		$this->db->query("DELETE FROM ".DB_PREFIX."link where id=$linkId");
	}

}
