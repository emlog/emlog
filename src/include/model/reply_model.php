<?php
/**
 * Reply management
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Reply_Model {

	private $db;

	function __construct()
	{
		$this->db = MySql::getInstance();
	}

	/**
	 * Add reply
	 *
	 * @param array $tData
	 * @return int
	 */
	function addReply($rData) {
	    if (true === $this->isReplyExist($rData['tid'], $rData['name'], $rData['content'])){
	        return false;
	    }
		$kItem = array();
		$dItem = array();
		foreach ($rData as $key => $data) {
			$kItem[] = $key;
			$dItem[] = $data;
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$this->db->query("INSERT INTO " . DB_PREFIX . "reply ($field) VALUES ($values)");
		$rid = $this->db->insert_id();
		return $rid;
	}

	/**
	 * Get replies
	 *
	 * @param int $tid
	 * @param string $hide
	 * @param int $page
	 * @return array
	 */
	function getReplys($tid, $hide = null)
	{
		$andQuery = '1=1';
		$andQuery .= $tid ? " and tid=$tid" : '';
		$andQuery .= $hide ? " and hide='$hide'" : '';

		$sql = "SELECT * FROM ".DB_PREFIX."reply where $andQuery ORDER BY id";

		$ret = $this->db->query($sql);
		$replys = array();
		while($row = $this->db->fetch_array($ret))
		{
			$row['name'] = htmlspecialchars($row['name']);
			$row['content'] = htmlClean($row['content']);
			$row['date'] = smartDate($row['date']);
			//$row['id'];
			//$row['hide'];
			//$row['tid'];
			//$row['ip'];
			$replys[] = $row;
		}
		return $replys;
	}

	/**
	 * Get a number of replies
	 *
	 * @param int $tid
	 * @param string $hide
	 * @return int $replyNum
	 */
	function getReplyNum($tid = null, $hide = null)
	{
		$andQuery = '1=1';
		$andQuery .= $tid ? " and tid=$tid" : '';
		$andQuery .= $hide ? " and hide='$hide'" : '';
	    $sql = "SELECT id FROM ".DB_PREFIX."reply where $andQuery";
		$res = $this->db->query($sql);
		$replyNum = $this->db->num_rows($res);
		return $replyNum;
	}

	/**
	 * Delete reply
	 *
	 * @param int $replyId
	 * @return int Affected twitter id
	 */
	function delReply($replyId)
	{
		$row = $this->db->once_fetch_array("SELECT hide FROM ".DB_PREFIX."reply WHERE id=$replyId");
		$this->db->query("DELETE FROM ".DB_PREFIX."reply where id=$replyId");
		$hide = $row['hide'];
		return $hide;
	}

	/**
	 * Hide reply
	 *
	 * @param int $replyId
	 */
	function hideReply($replyId)
	{
		$this->db->query("UPDATE ".DB_PREFIX."reply SET hide='y' WHERE id=$replyId");
	}
	/**
	 * Show reply
	 *
	 * @param int $replyId
	 */
	function pubReply($replyId)
	{
		$row = $this->db->once_fetch_array("SELECT tid FROM ".DB_PREFIX."reply WHERE id=$replyId");
		$this->db->query("UPDATE ".DB_PREFIX."reply SET hide='n' WHERE id=$replyId");
		$tid = intval($row['tid']);
		return $tid;
	}

	function isReplyExist($tid, $name, $content)
	{
		$query = $this->db->query("SELECT id FROM ".DB_PREFIX."reply WHERE tid=$tid AND name='$name' AND content='$content'");
		$result = $this->db->num_rows($query);
		if ($result > 0){
			return true;
		}else {
			return false;
		}
	}

	function setReplyCookie($name)
	{
		$cookietime = time() + 31536000;
		setcookie('replyposter',$name,$cookietime);
	}

}
