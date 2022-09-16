<?php
/**
 * navibar model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Navi_Model {

	private $db;

	const navitype_custom = 0;//自定义
	const navitype_home = 1;  //首页
	const navitype_t = 2;     //笔记
	const navitype_admin = 3; //后台管理
	const navitype_sort = 4;  //分类
	const navitype_page = 5;  //页面

	function __construct() {
		$this->db = Database::getInstance();
	}

	function getNavis() {
		$navis = [];
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "navi ORDER BY pid ASC, taxis ASC");
		while ($row = $this->db->fetch_array($query)) {
			$url = Url::navi($row['type'], $row['type_id'], $row['url']);
			$naviData = array(
				'id'        => (int)$row['id'],
				'naviname'  => htmlspecialchars(trim($row['naviname'])),
				'url'       => htmlspecialchars(trim($url)),
				'newtab'    => $row['newtab'],
				'isdefault' => $row['isdefault'],
				'type'      => (int)$row['type'],
				'typeId'    => (int)$row['type_id'],
				'taxis'     => (int)$row['taxis'],
				'hide'      => $row['hide'],
				'pid'       => (int)$row['pid'],
			);
			if ($row['type'] == Navi_Model::navitype_custom) {
				if ($naviData['pid'] == 0) {
					$naviData['childnavi'] = [];
				} elseif (isset($navis[$row['pid']])) {
					$navis[$row['pid']]['childnavi'][] = $naviData;
				}
			}
			$navis[$row['id']] = $naviData;
		}
		return $navis;
	}

	function updateNavi($naviData, $navid) {
		$Item = [];
		foreach ($naviData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("UPDATE " . DB_PREFIX . "navi SET $upStr WHERE id=$navid");
	}

	function addNavi($name, $url, $taxis, $pid, $newtab, $type = 0, $typeId = 0) {
		if ($taxis > 30000 || $taxis < 0) {
			$taxis = 0;
		}
		$sql = "INSERT INTO " . DB_PREFIX . "navi (naviname,url,taxis,pid,newtab,type,type_id) VALUES('$name','$url', $taxis, $pid, '$newtab', $type, $typeId)";
		$this->db->query($sql);
	}

	function getOneNavi($navid) {
		$sql = "SELECT * FROM " . DB_PREFIX . "navi WHERE id=$navid ";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
		$naviData = [];
		if ($row) {
			$naviData = array(
				'naviname'  => htmlspecialchars(trim($row['naviname'])),
				'url'       => htmlspecialchars(trim($row['url'])),
				'newtab'    => $row['newtab'],
				'isdefault' => $row['isdefault'],
				'type'      => (int)$row['type'],
				'type_id'   => (int)$row['type_id'],
				'pid'       => (int)$row['pid'],
			);
		}
		return $naviData;
	}

	function getNaviNameByUrl($url) {
		$CACHE = Cache::getInstance();
		$navi_cache = $CACHE->readCache('navi');
		foreach ($navi_cache as $val) {
			if ($val['url'] == $url) {
				return $val['naviname'];
			}
		}

		return '';
	}

	function getNaviNameByType($type) {
		$CACHE = Cache::getInstance();
		$navi_cache = $CACHE->readCache('navi');
		foreach ($navi_cache as $val) {
			if ($val['type'] == $type) {
				return $val['naviname'];
			}
		}

		return '';
	}

	function deleteNavi($navid) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "navi WHERE id=$navid");
		$this->db->query("UPDATE " . DB_PREFIX . "navi SET pid=0 WHERE pid=$navid");
	}

}
