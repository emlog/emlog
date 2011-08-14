<?php
/**
 * 碎语twitter
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Twitter_Model {
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
	 * @param int $spot 0:前台 1:后台
	 * @return int
	 */
	function getTwitterNum($spot = 0) {
	    $author = ROLE == 'admin' || ROLE == 'visitor' || $spot == 0 ? '' : 'and author=' . UID;
		$res = $this->db->query("SELECT id FROM " . DB_PREFIX . "twitter WHERE 1=1 $author");
		$twNum = $this->db->num_rows($res);
		return $twNum;
	}

	/**
	 * 获取碎语列表
	 *
	 * @param int $page
	 * @param int $spot 0:前台 1:后台
	 * @return array
	 */
	function getTwitters($page = 1, $spot = 0) {
		$perpage_num = $spot == 1 ? Option::get('admin_perpage_num') : Option::get('index_twnum');
		$start_limit = !empty($page) ? ($page - 1) * $perpage_num : 0;
		$author = ROLE == 'admin' || ROLE == 'visitor' || $spot == 0 ? '' : 'and author=' . UID;
		$limit = "LIMIT $start_limit, " . $perpage_num;
		$sql = "SELECT * FROM " . DB_PREFIX . "twitter WHERE 1=1 $author ORDER BY id DESC $limit";
		$res = $this->db->query($sql);
		$tws = array();
		while ($row = $this->db->fetch_array($res)) {
		    $row['id'] = $row['id'];
		    $row['t'] = $row['content'];
			$row['date'] = smartDate($row['date']);
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
			emMsg('权限不足！', './');
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
	 * 格式化碎语内容
	 *
	 * @param string $t
	 */
    function formatTwitter($t) {
        //识别URL
        $t = htmlspecialchars(preg_replace("/http:\/\/[\w-.?\/=&%:]*/i", "[+@] href=\"\$0\" target=\"_blank\"[@+]\$0[-@+]", $t), ENT_NOQUOTES);
        $t = str_replace(array('[+@]','[@+]','[-@+]'), array('<a','>','</a>'), $t);
        return $t;
    }
}
