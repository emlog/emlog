<?php
/**
 * 模型：碎语twitter
 *
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
$Id: class.twittter.php 1596 2010-03-02 12:09:48Z Colt.hawkins $
 */

class emTwitter {
	/**
	 * 内部数据对象
	 * @var MySql
	 */
	private $db;

	function __construct() {
		$this->db = MySql::getInstance();
	}

	/**
	 * 写入碎语
	 *
	 * @param array $tData
	 * @return int
	 */
	function addTwitter($tData) {
		$kItem = array();
		$dItem = array();
		foreach ($tData as $key => $data) {
			$kItem[] = $key;
			$dItem[] = $data;
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$this->db->query("INSERT INTO " . DB_PREFIX . "twitter ($field) VALUES ($values)");
		$logid = $this->db->insert_id();
		return $logid;
	}

	/**
	 * 获取指定条件的碎语条数
	 *
	 * @return int
	 */
	function getTwitterNum() {
	    $author = ROLE == 'admin' || ROLE == 'visitor' ? '' : 'and author=' . UID;
		$res = $this->db->query("SELECT id FROM " . DB_PREFIX . "twitter WHERE 1=1 $author");
		$twNum = $this->db->num_rows($res);
		return $twNum;
	}

	/**
	 * 获取碎语列表
	 *
	 * @param int $page
	 * @return array
	 */
	function getTwitters($page = 1) {
		global $timezone;
		$start_limit = !empty($page) ? ($page - 1) * ADMIN_PERPAGE_NUM : 0;
		$author = ROLE == 'admin' || ROLE == 'visitor' ? '' : 'and author=' . UID;
		$limit = "LIMIT $start_limit, " . ADMIN_PERPAGE_NUM;
		$sql = "SELECT * FROM " . DB_PREFIX . "twitter WHERE 1=1 $author ORDER BY id DESC $limit";
		$res = $this->db->query($sql);
		$tws = array();
		while ($row = $this->db->fetch_array($res)) {
		    $row['id'] = $row['id'];
		    $row['t'] = $row['content'];
			$row['date'] = smartyDate($row['date']);
			$row['replynum'] = $row['replynum'];
			$tws[] = $row;
		}
		return $tws;
	}

	/**
	 * 删除碎语
	 *
	 * @param int $tid
	 */
	function delTwitter($tid) {
		$author = ROLE == 'admin' ? '' : 'and author=' . UID;
		$this->db->query("DELETE FROM " . DB_PREFIX . "twitter where id=$tid $author");
		if ($this->db->affected_rows() < 1) {
			formMsg('权限不足！', './', 0);
		}
		// delete reply
		$this->db->query("DELETE FROM " . DB_PREFIX . "reply where tid=$tid");
	}
	
	/**
	 * 更新碎语回复数目
	 *
	 * @param int $tid
	 * @param string $do '+1' or '-1'
	 */
	function updateReplyNum($tid, $do) {
	    $this->db->query("UPDATE ".DB_PREFIX."twitter SET replynum = replynum $do WHERE id='$tid'");
	}

	/**
	 * 获取指定数量最新碎语
	 *
	 * @param int $num
	 * @return array
	 */
	function getNewLog($num) {
		$sql = "SELECT gid,title FROM " . DB_PREFIX . "blog WHERE hide='n' and type='blog' ORDER BY gid DESC LIMIT 0, $num";
		$res = $this->db->query($sql);
		$logs = array();
		while ($row = $this->db->fetch_array($res)) {
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}
}
