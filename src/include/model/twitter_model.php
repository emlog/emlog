<?php
/**
 * 微语
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Twitter_Model {

	private $db;

	function __construct() {
		$this->db = MySql::getInstance();
	}

	/**
	 * 写入微语
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
	 * 获取指定条件的微语条数
	 *
	 * @param int $spot 0:前台 1:后台
	 * @return int
	 */
	function getTwitterNum($spot = 0) {
		$author = ROLE == ROLE_ADMIN || ROLE == ROLE_VISITOR || $spot == 0 ? '' : 'and author=' . UID;
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "twitter WHERE 1=1 $author");
		return $data['total'];
	}

	/**
	 * 获取微语列表
	 *
	 * @param int $page
	 * @param int $spot 0:前台 1:后台
	 * @return array
	 */
	function getTwitters($page = 1, $spot = 0) {
		$perpage_num = $spot == 1 ? Option::get('admin_perpage_num') : Option::get('index_twnum');
		$start_limit = !empty($page) ? ($page - 1) * $perpage_num : 0;
		$author = ROLE == ROLE_ADMIN || ROLE == ROLE_VISITOR || $spot == 0 ? '' : 'and author=' . UID;
		$limit = "LIMIT $start_limit, " . $perpage_num;
		$sql = "SELECT * FROM " . DB_PREFIX . "twitter WHERE 1=1 $author ORDER BY id DESC $limit";
		$res = $this->db->query($sql);
		$tws = array();
		while ($row = $this->db->fetch_array($res)) {
			$row['id'] = $row['id'];
			$row['t'] = emoFormat($row['content']);
			$row['date'] = smartDate($row['date']);
			$row['replynum'] = $row['replynum'];
			$tws[] = $row;
		}
		return $tws;
	}

	function delTwitter($tid) {
		$author = ROLE == ROLE_ADMIN ? '' : 'and author=' . UID;
        $query = $this->db->query("select img from " . DB_PREFIX . "twitter where id=$tid $author");
        $row = $this->db->fetch_array($query);

        // del tw
		$this->db->query("DELETE FROM " . DB_PREFIX . "twitter where id=$tid $author");
		if ($this->db->affected_rows() < 1) {
			emMsg('权限不足！', './');
		}
		// del reply
		$this->db->query("DELETE FROM " . DB_PREFIX . "reply where tid=$tid");
        // del pic
		if (!empty($row['img'])) {
			$fpath = str_replace('thum-', '', $row['img']);
			if ($fpath != $row['img']) {
				@unlink('../' . $fpath);
			}
			@unlink('../' . $row['img']);
		}
	}
	
	/**
	 * 更新微语回复数目
	 *
	 * @param int $tid
	 * @param string $do '+1' or '-1'
	 */
	function updateReplyNum($tid, $do) {
		$this->db->query("UPDATE ".DB_PREFIX."twitter SET replynum = replynum $do WHERE id='$tid'");
	}

	function formatTwitter($t) {
		//识别URL
		$t = htmlspecialchars(preg_replace("/http:\/\/[\w-.?\/=&%:]*/i", "[+@] href=\"\$0\" target=\"_blank\"[@+]\$0[-@+]", $t), ENT_NOQUOTES);
		$t = str_replace(array('[+@]','[@+]','[-@+]'), array('<a','>','</a>'), $t);
		return $t;
	}
}
