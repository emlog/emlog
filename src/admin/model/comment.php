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
	function getOneComment($commentId)
	{
		$sql = "select * from ".DB_PREFIX."comment where cid=$commentId";
		$res = $this->dbhd->query($sql);
		$commentArray = $this->dbhd->fetch_array($res);
		return $commentArray;
	}
	/**
	 * 获取查询评论的数目
	 *
	 * @param int $blogId
	 * @return int $comNum
	 */
	function getCommentNum($blogId = null)
	{
		$comNum = '';
		$andQuery = $blogId ? "where gid=$blogId" : '';
		$res = $this->dbhd->query("SELECT cid FROM ".DB_PREFIX."comment $andQuery");
		$comNum = $this->dbhd->num_rows($res);
		return $comNum;
	}
	/**
	 * 删除评论
	 *
	 * @param int $commentId
	 */
	function delComment($commentId)
	{
		$row = $this->dbhd->fetch_one_array("SELECT gid FROM ".DB_PREFIX."comment WHERE cid=$commentId");
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."comment where cid=$commentId");
		$blogId = intval($row['gid']);
		$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET comnum=comnum-1 WHERE gid=$blogId");
	}
	/**
	 * 显示/隐藏评论
	 *
	 * @param int $commentId
	 */
	function hideComment($commentId)
	{
		$row = $this->dbhd->fetch_one_array("SELECT gid,hide FROM ".DB_PREFIX."comment WHERE cid=$commentId");
		$blogId = intval($row['gid']);
		$isHide = $row['hide'];
		if($isHide == 'n')
		{
			$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET comnum=comnum-1 WHERE gid=$blogId");
		}
		$this->dbhd->query("UPDATE ".DB_PREFIX."comment SET hide='y' WHERE cid=$commentId");
	}
	function showComment($commentId)
	{
		$row = $this->dbhd->fetch_one_array("SELECT gid,hide FROM ".DB_PREFIX."comment WHERE cid=$commentId");
		$blogId = intval($row['gid']);
		$isHide = $row['hide'];
		if($isHide == 'y')
		{
			$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET comnum=comnum+1 WHERE gid=$blogId");
		}
		$this->dbhd->query("UPDATE ".DB_PREFIX."comment SET hide='n' WHERE cid=$commentId");
	}

	/**
	 * 回复评论
	 *
	 * @param int $commentId
	 * @param string $reply
	 */
	function replyComment($commentId, $reply)
	{
		$sql="UPDATE ".DB_PREFIX."comment SET reply='$reply' where cid=$commentId ";
		$this->dbhd->query($sql);
	}

	/**
	 * 批量处理评论
	 *
	 * @param string $action
	 * @param array $comments
	 */
	function batchComment($action, $comments)
	{
		switch ($action)
		{
			case 'delcom':
				foreach($comments as $key=>$val)
				{
					$this->delComment($key);
				}
				break;
			case 'hidecom':
				foreach($comments as $key=>$val)
				{
					$this->hideComment($key);
				}
				break;
			case 'showcom':
				foreach($comments as $key=>$val)
				{
					$this->showComment($key);
				}
				break;
		}
	}

}

?>
