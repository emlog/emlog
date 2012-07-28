<?php
/**
 * 导航
 * @copyright (c) Emlog All Rights Reserved
 */

class Navi_Model {

	private $db;

	function __construct()
	{
		$this->db = MySql::getInstance();
	}

	function getNavis()
	{
		$res = $this->db->query("SELECT * FROM ".DB_PREFIX."navi ORDER BY taxis ASC");
		$navis = array();
		while($row = $this->db->fetch_array($res))
		{
			$row['naviname'] = htmlspecialchars($row['naviname']);
			//$row['url'] = $row['url'];
			//$row['isdefault'] = $row['isdefault'];
			$navis[] = $row;
		}
		return $navis;
	}

	function updateNavi($naviData, $navid)
	{
		$Item = array();
		foreach ($naviData as $key => $data)
		{
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update ".DB_PREFIX."navi set $upStr where id=$navid");
	}

	function addNavi($name, $url, $taxis, $newtab)
	{
		if($taxis > 30000 || $taxis < 0) {
			$taxis = 0;
		}
		$sql="insert into ".DB_PREFIX."navi (naviname,url,taxis,newtab) values('$name','$url', $taxis, '$newtab')";
		$this->db->query($sql);
	}

	function getOneNavi($navid)
	{
		$sql = "select * from ".DB_PREFIX."navi where id=$navid ";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
		$naviData = array();
		if($row)
		{
			$naviData = array(
			'naviname' => htmlspecialchars(trim($row['naviname'])),
			'url' => htmlspecialchars(trim($row['url'])),
			'newtab' => $row['newtab'],
			'isdefault' => $row['isdefault'],
			);
		}
		return $naviData;
	}

	function getNaviNameByUrl($url) {
		$CACHE = Cache::getInstance();
		$navi_cache = $CACHE->readCache('navi');
		
		foreach($navi_cache as $val) {
			if ($val['url'] == $url) {
				return $val['naviname'];
			}
		}

		return '';
	}

	function deleteNavi($navid)
	{
		$this->db->query("DELETE FROM ".DB_PREFIX."navi where id=$navid");
	}

}
