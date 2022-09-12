<?php
/**
 * media sort model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class MediaSort_Model {

	private $db;
	private $table;
	private $table_media;

	function __construct() {
		$this->db = Database::getInstance();
		$this->table = DB_PREFIX . 'media_sort';
		$this->table_media = DB_PREFIX . 'attachment';
	}

	function getSorts() {
		$res = $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC");
		$sorts = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['sortname'] = htmlspecialchars($row['sortname']);
			$row['id'] = htmlspecialchars($row['id']);
			$sorts[] = $row;
		}
		return $sorts;
	}

	function updateSort($sortData, $sid) {
		$Item = [];
		foreach ($sortData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update " . DB_PREFIX . "sort set $upStr where sid=$sid");
	}

	function addSort($name) {
		$sql = "insert into " . $this->table . " (sortname) values('$name')";
		$this->db->query($sql);
	}

	function deleteSort($id) {
		$this->db->query("update " . $this->table_media . " set sortid=0 where sortid=$id");
		$this->db->query("DELETE FROM " . $this->table . " where id=$id");
	}

	function getSortName($sid) {
		if ($sid > 0) {
			$res = $this->db->query("SELECT sortname FROM " . $this->table . " WHERE sid = $sid");
			$row = $this->db->fetch_array($res);
			$sortName = htmlspecialchars($row['sortname']);
		} else {
			$sortName = '未分类';
		}
		return $sortName;
	}

}
