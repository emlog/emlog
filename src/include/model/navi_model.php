<?php
/**
 * 导航
 * @copyright (c) Emlog All Rights Reserved
 */

class Navi_Model {

	private $db;

	const navitype_custom  = 0;
	const navitype_home    = 1;
    const navitype_t       = 2;
    const navitype_admin   = 3;
    const navitype_sort    = 4;
    const navitype_page    = 5;

    function __construct() {
		$this->db = Database::getInstance();
	}

	function getNavis() {
        $navis = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "navi ORDER BY pid ASC, taxis ASC");
		while ($row = $this->db->fetch_array($query)) {
			$url = Url::navi($row['type'], $row['type_id'], $row['url']);
			$naviData = array(
                    'id' => intval($row['id']),
                    'naviname' => htmlspecialchars(trim($row['naviname'])),
                    'url' => htmlspecialchars(trim($url)),
                    'newtab' => $row['newtab'],
                    'isdefault' => $row['isdefault'],
                    'type' => intval($row['type']),
                    'typeId' => intval($row['type_id']),
                    'taxis' => intval($row['taxis']),
                    'hide' => $row['hide'],
                    'pid' => intval($row['pid']),
                    );
            if ($row['type'] == Navi_Model::navitype_custom) {
                if($naviData['pid'] == 0) {
                    $naviData['childnavi'] = array();
                } elseif (isset($navis[$row['pid']])) {
                    $navis[$row['pid']]['childnavi'][] = $naviData;
                }
            }
            $navis[$row['id']] = $naviData;
		}
        return $navis;
	}

	function updateNavi($naviData, $navid) {
		$Item = array();
		foreach ($naviData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update ".DB_PREFIX."navi set $upStr where id=$navid");
	}

	function addNavi($name, $url, $taxis, $pid, $newtab, $type = 0, $typeId = 0) {
		if($taxis > 30000 || $taxis < 0) {
			$taxis = 0;
		}
		$sql="insert into ".DB_PREFIX."navi (naviname,url,taxis,pid,newtab,type,type_id) values('$name','$url', $taxis, $pid, '$newtab', $type, $typeId)";
		$this->db->query($sql);
	}

	function getOneNavi($navid) {
		$sql = "select * from ".DB_PREFIX."navi where id=$navid ";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
		$naviData = array();
		if($row) {
			$naviData = array(
				'naviname' => htmlspecialchars(trim($row['naviname'])),
				'url' => htmlspecialchars(trim($row['url'])),
				'newtab' => $row['newtab'],
				'isdefault' => $row['isdefault'],
				'type' => intval($row['type']),
				'type_id' => intval($row['type_id']),
                'pid' => intval($row['pid']),
			);
		}
		return $naviData;
	}

    function getNaviNameByUrl($url) {
		$CACHE = Cache::getInstance();
		$navi_cache = $CACHE->readCache('navi');
		foreach($navi_cache as $val) {
			if ($val['url'] == $url){
				return $val['naviname'];
			}
		}

		return '';
	}

	function getNaviNameByType($type) {
		$CACHE = Cache::getInstance();
		$navi_cache = $CACHE->readCache('navi');
		foreach($navi_cache as $val) {
			if ($val['type'] == $type) {
				return $val['naviname'];
			}
		}

		return '';
	}

	function deleteNavi($navid) {
		$this->db->query("DELETE FROM ".DB_PREFIX."navi where id=$navid");
		$this->db->query("UPDATE ".DB_PREFIX."navi set pid=0 where pid=$navid");
	}

}
