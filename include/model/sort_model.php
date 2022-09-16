<?php
/**
 * article sort model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Sort_Model {

	private $db;

	function __construct() {
		$this->db = Database::getInstance();
	}

	function getSorts() {
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "sort ORDER BY taxis ASC");
		$sorts = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['sortname'] = htmlspecialchars($row['sortname']);
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
		$this->db->query("UPDATE " . DB_PREFIX . "sort SET $upStr WHERE sid=$sid");
	}

	function addSort($name, $alias, $pid, $description, $template) {
		$sql = "INSERT INTO " . DB_PREFIX . "sort (sortname,alias,pid,description,template) VALUES('$name','$alias',$pid,'$description', '$template')";
		$this->db->query($sql);
	}

	function deleteSort($sid) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET sortid=-1 WHERE sortid=$sid");
		$this->db->query("UPDATE " . DB_PREFIX . "sort SET pid=0 WHERE pid=$sid");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sort WHERE sid=$sid");
	}

	function getOneSortById($sid) {
		$sql = "SELECT * FROM " . DB_PREFIX . "sort WHERE sid=$sid";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
		$sortData = [];
		if ($row) {
			$sortData = array(
				'sortname'    => htmlspecialchars(trim($row['sortname'])),
				'alias'       => $row['alias'],
				'pid'         => $row['pid'],
				'description' => htmlspecialchars(trim($row['description'])),
				'template'    => !empty($row['template']) ? htmlspecialchars(trim($row['template'])) : 'log_list',
			);
		}
		return $sortData;
	}

	function getSortName($sid) {
		if ($sid > 0) {
			$res = $this->db->query("SELECT sortname FROM " . DB_PREFIX . "sort WHERE sid = $sid");
			$row = $this->db->fetch_array($res);
			$sortName = htmlspecialchars($row['sortname']);
		} else {
			$sortName = '未分类';
		}
		return $sortName;
	}
}
