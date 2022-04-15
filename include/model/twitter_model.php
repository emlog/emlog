<?php
/**
 * 笔记
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Twitter_Model {

	private $db;

	function __construct() {
		$this->db = Database::getInstance();
	}

	function addTwitter($tData) {
		$kItem = [];
		$dItem = [];
		foreach ($tData as $key => $data) {
			$kItem[] = $key;
			$dItem[] = $data;
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$this->db->query("INSERT INTO " . DB_PREFIX . "twitter ($field) VALUES ($values)");
		return $this->db->insert_id();
	}

	function getTwitterNum() {
		$author = 'and author=' . UID;
		$data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "twitter WHERE 1=1 $author");
		return $data['total'];
	}

	function getTwitters($page = 1, $perpage_num = 20) {
		$start_limit = !empty($page) ? ($page - 1) * $perpage_num : 0;
		$author = 'and author=' . UID;
		$limit = "LIMIT $start_limit, " . $perpage_num;
		$sql = "SELECT * FROM " . DB_PREFIX . "twitter WHERE 1=1 $author ORDER BY id DESC $limit";
		$res = $this->db->query($sql);
		$tws = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['t'] = nl2br(htmlspecialchars($row['content']));
			$row['date'] = smartDate($row['date']);
			$tws[] = $row;
		}
		return $tws;
	}

	function delTwitter($tid) {
		$author = User::isAdmin() ? '' : 'and author=' . UID;
		$query = $this->db->query("select img from " . DB_PREFIX . "twitter where id=$tid $author");
		$row = $this->db->fetch_array($query);

		// del tw
		$this->db->query("DELETE FROM " . DB_PREFIX . "twitter where id=$tid $author");
		if ($this->db->affected_rows() < 1) {
			emMsg('权限不足！', './');
		}
		// del pic
		if (!empty($row['img'])) {
			$fpath = str_replace('thum-', '', $row['img']);
			if ($fpath != $row['img']) {
				@unlink('../' . $fpath);
			}
			@unlink('../' . $row['img']);
		}
	}
}
