<?php
/**
 * links model
 * @package EMLOG (www.emlog.net)
 */

class Link_Model {

	private $db;

	function __construct() {
		$this->db = Database::getInstance();
	}

	function getLinks() {
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "link ORDER BY taxis ASC");
		$links = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['sitename'] = htmlspecialchars($row['sitename']);
			$row['description'] = htmlClean($row['description'], false);
			$row['siteurl'] = $row['siteurl'];
			$links[] = $row;
		}
		return $links;
	}

	function updateLink($linkData, $linkId) {
		$Item = [];
		foreach ($linkData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update " . DB_PREFIX . "link set $upStr where id=$linkId");
	}

	function addLink($name, $url, $des) {
		$sql = "insert into " . DB_PREFIX . "link (sitename,siteurl,description) values('$name','$url','$des')";
		$this->db->query($sql);
	}

	function deleteLink($linkId) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "link where id=$linkId");
	}

}
