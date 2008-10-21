<?php
/**
 * 模型：评论管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id: comment.php 682 2008-10-14 16:08:01Z emloog $
 */


class comment {

	var $dbhd;

	function comment($dbhandle)
	{
		$this->dbhd = $dbhandle;
	}

	/**
	 * 获取评论
	 *
	 * @param int $blogId
	 * @param int $page
	 * @return array $comment
	 */
	function getComment($blogId = null, $page = 1)
	{
		if($blogId)
		{
			$andQuery = "where gid=$blogId";
		}else{
			$andQuery = '';
		}
		if (!empty($page))
		{
			$start_limit = ($page - 1) *15;
		} else {
			$start_limit = 0;
			$page = 1;
		}
		$sql = "SELECT * FROM ".DB_PREFIX."comment $andQuery ORDER BY cid DESC LIMIT $start_limit, 15";
		$ret = $this->dbhd->query($sql);
		$comment = array();
		while($row = $this->dbhd->fetch_array($ret))
		{
			$row['comment'] = subString(htmlClean2($row['comment']),0,30);
			$row['date'] = date("Y-m-d H:i",$row['date']);
			$row['reply'] = trim($row['reply']);
			$comment[] = $row;
		}
		return $comment;
	}

	/**
	 * 获取查询评论的数目
	 *
	 * @param int $blogId
	 * @return int $comNum
	 */
	function getCommentNum($blogId)
	{
		$comNum = '';
		$andQuery = $blogId ? "where gid=$blogId" : '';
		$res = $this->dbhd->query("SELECT cid FROM ".DB_PREFIX."comment $andQuery");
		$comNum = $this->dbhd->num_rows($res);
		return $comNum;
	}

}

?>
