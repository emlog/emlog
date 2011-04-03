<?php
/**
 * 评论管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Comment_Model {
	/**
	 * 内部数据对象
	 * @var MySql
	 */
	private $db;

	function __construct()
	{
		$this->db = MySql::getInstance();
	}

	/**
	 * 获取评论
	 *
	 * @param int $spot 0：前台 1：后台
	 * @param int $blogId
	 * @param string $hide
	 * @param int $page
	 * @return array
	 */
	function getComments($spot = 0, $blogId = null, $hide = null, $page = null)
	{
		$andQuery = '1=1';
		$andQuery .= $blogId ? " and a.gid=$blogId" : '';
		$andQuery .= $hide ? " and a.hide='$hide'" : '';
		$condition = '';
		if($page)
		{
			$perpage_num = Option::get('admin_perpage_num');
			$startId = ($page - 1) * $perpage_num;
			$condition = "LIMIT $startId, ".$perpage_num;
		}
		if($spot == 0)
		{
			$sql = "SELECT * FROM ".DB_PREFIX."comment as a where $andQuery ORDER BY a.cid ASC $condition";
		}else{
			$andQuery .= ROLE != 'admin' ? ' and b.author='.UID : '';
			$sql = "SELECT *,a.hide,a.date FROM ".DB_PREFIX."comment as a, ".DB_PREFIX."blog as b where $andQuery and a.gid=b.gid ORDER BY a.cid DESC $condition";
		}
		$ret = $this->db->query($sql);
		$comments = array();
		while($row = $this->db->fetch_array($ret))
		{
			$row['cname'] = htmlspecialchars($row['poster']);
			$row['mail'] = htmlspecialchars($row['mail']);
			$row['url'] = htmlspecialchars($row['url']);
			$row['content'] = htmlClean($row['comment']);
			$row['date'] = smartDate($row['date']);
			$row['children'] = array();
			if($spot == 0) $row['level'] = isset($comments[$row['pid']]) ? $comments[$row['pid']]['level'] + 1 : 0;
			//$row['hide'];
			//$row['title'];
			//$row['gid'];
			$comments[$row['cid']] = $row;
		}
		if($spot == 0) {
			foreach($comments as $cid => $comment) {
				$pid = $comment['pid'];
				if($pid != 0 && isset($comments[$pid])) {
					if($comments[$cid]['level'] > 4) {
						$comments[$cid]['pid'] = $pid = $comments[$pid]['pid'];
					}
					$comments[$pid]['children'][] = $cid;
				}
			}
			$comments = array_reverse($comments, true);
		}
		return $comments;
	}
	function getOneComment($commentId)
	{
		$timezone = Option::get('timezone');
		$sql = "select * from ".DB_PREFIX."comment where cid=$commentId";
		$res = $this->db->query($sql);
		$commentArray = $this->db->fetch_array($res);
		$commentArray['comment'] = htmlClean(trim($commentArray['comment']));
		$commentArray['poster'] = trim($commentArray['poster']);
		$commentArray['date'] = gmdate("Y-m-d H:i",$commentArray['date'] + $timezone * 3600);
		return $commentArray;
	}
	/**
	 * 获取查询评论的数目
	 *
	 * @param int $blogId
	 * @return int $comNum
	 */
	function getCommentNum($blogId = null, $hide = null)
	{
		$comNum = '';
		$andQuery = '1=1';
		$andQuery .= $blogId ? " and a.gid=$blogId" : '';
		$andQuery .= $hide ? " and a.hide='$hide'" : '';
		if (ROLE == 'admin')
		{
			$sql = "SELECT count(*) FROM ".DB_PREFIX."comment as a where $andQuery";
		}else {
			$sql = "SELECT count(*) FROM ".DB_PREFIX."comment as a, ".DB_PREFIX."blog as b where $andQuery and a.gid=b.gid and b.author=".UID;
		}
		$res = $this->db->once_fetch_array($sql);
		$comNum = $res['count(*)'];
		return $comNum;
	}
	/**
	 * 删除评论
	 *
	 * @param int $commentId
	 */
	function delComment($commentId)
	{
		$row = $this->db->once_fetch_array("SELECT gid FROM ".DB_PREFIX."comment WHERE cid=$commentId");
		$blogId = intval($row['gid']);
		$commentIds = array($commentId);
		/* 获取子评论ID */
		$query = $this->db->query("SELECT cid,pid FROM ".DB_PREFIX."comment WHERE gid=$blogId AND cid>$commentId ");
		while($row = $this->db->fetch_array($query)) {
			if(in_array($row['pid'],$commentIds)) {
				$commentIds[] = $row['cid'];
			}
		}
		$commentIds = implode(',',$commentIds);
		$this->db->query("DELETE FROM ".DB_PREFIX."comment WHERE cid IN ($commentIds)");
		$this->updateCommentNum($blogId);
	}
	/**
	 * 隐藏评论
	 *
	 * @param int $commentId
	 */
	function hideComment($commentId)
	{
		$row = $this->db->once_fetch_array("SELECT gid FROM ".DB_PREFIX."comment WHERE cid=$commentId");
		$blogId = intval($row['gid']);
		$commentIds = array($commentId);
		/* 获取子评论ID */
		$query = $this->db->query("SELECT cid,pid FROM ".DB_PREFIX."comment WHERE gid=$blogId AND cid>$commentId ");
		while($row = $this->db->fetch_array($query)) {
			if(in_array($row['pid'],$commentIds)) {
				$commentIds[] = $row['cid'];
			}
		}
		$commentIds = implode(',',$commentIds);
		$this->db->query("UPDATE ".DB_PREFIX."comment SET hide='y' WHERE cid IN ($commentIds)");
		$this->updateCommentNum($blogId);
	}
	/**
	 * 显示评论
	 *
	 * @param int $commentId
	 */
	function showComment($commentId)
	{
		$row = $this->db->once_fetch_array("SELECT gid,pid FROM ".DB_PREFIX."comment WHERE cid=$commentId");
		$blogId = intval($row['gid']);
		$commentIds = array($commentId);
		/* 获取父评论ID */
		while($row['pid'] != 0) {
			$commentId = intval($row['pid']);
			$commentIds[] = $commentId;
			$row = $this->db->once_fetch_array("SELECT pid FROM ".DB_PREFIX."comment WHERE cid=$commentId");
		}
		$commentIds = implode(',',$commentIds);
		$this->db->query("UPDATE ".DB_PREFIX."comment SET hide='n' WHERE cid IN ($commentIds)");
		$this->updateCommentNum($blogId);
	}
	/**
	 * 回复评论
	 *
	 * @param int $blogId
	 * @param int $commentId
	 * @param string $content
	 * @param string $hide
	 */
	function replyComment($blogId, $pid, $content, $hide)
	{
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
		if(isset($user_cache[UID])) {
			$name = $user_cache[UID]['name'];
			$mail = $user_cache[UID]['mail'];
			$url = BLOG_URL;
			$ipaddr = getIp();
			$utctimestamp = time();
			$this->db->query("INSERT INTO ".DB_PREFIX."comment (date,poster,gid,comment,mail,url,hide,ip,pid)
					VALUES ('$utctimestamp','$name','$blogId','$content','$mail','$url','$hide','$ipaddr','$pid')");
			$this->updateCommentNum($blogId);
		}
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
				foreach($comments as $val)
				{
					$this->delComment($val);
				}
				break;
			case 'hidecom':
				foreach($comments as $val)
				{
					$this->hideComment($val);
				}
				break;
			case 'showcom':
				foreach($comments as $val)
				{
					$this->showComment($val);
				}
				break;
		}
	}
	/**
	 * 更新日志评论数目
	 *
	 * @param int $blogId
	 */
	function updateCommentNum($blogId)
	{
		$sql = "SELECT count(*) FROM ".DB_PREFIX."comment WHERE gid=$blogId AND hide='n'";
		$res = $this->db->once_fetch_array($sql);
		$comNum = $res['count(*)'];
		$this->db->query("UPDATE ".DB_PREFIX."blog SET comnum=$comNum WHERE gid=$blogId");
		return $comNum;
	}

	function addComment($name, $content, $mail, $url, $imgcode, $blogId, $pid) 
	{
		$ipaddr = getIp();
		$utctimestamp = time();
		$ischkcomment = Option::get('ischkcomment');
		$sql = 'INSERT INTO '.DB_PREFIX."comment (date,poster,gid,comment,mail,url,hide,ip,pid)
				VALUES ('$utctimestamp','$name','$blogId','$content','$mail','$url','$ischkcomment','$ipaddr','$pid')";
		$ret = $this->db->query($sql);
		$cid = $this->db->insert_id();
		$CACHE = Cache::getInstance();
		if ($ischkcomment == 'n') {
			$this->db->query('UPDATE '.DB_PREFIX."blog SET comnum = comnum + 1 WHERE gid='$blogId'");
			$CACHE->updateCache(array('sta', 'comment'));
            doAction('comment_saved');
            header('Location: ' . Url::log($blogId).'#'.$cid);
		} else {
		    $CACHE->updateCache('sta');
		    doAction('comment_saved');
		    emMsg('评论发表成功，请等待管理员审核', Url::log($blogId));
		}
	}

	function isCommentExist($blogId, $name, $content)
	{
		$query = $this->db->query("SELECT cid FROM ".DB_PREFIX."comment WHERE gid=$blogId AND poster='$name' AND comment='$content'");
		$result = $this->db->num_rows($query);
		if ($result > 0)
		{
			return true;
		}else {
			return false;
		}
	}

	function isNameAndMailValid($name, $mail)
	{
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
		foreach($user_cache as $user) {
			if($user['name'] == $name || ($mail != '' && $user['mail'] == $mail)) {
				return false;
			}
		}
		return true;
	}
	function isLogCanComment($blogId)
	{
		$query = $this->db->query("SELECT allow_remark FROM ".DB_PREFIX."blog WHERE gid=$blogId");
		$show_remark = $this->db->fetch_array($query);
		if ($show_remark['allow_remark'] == 'n' || $show_remark === false)
		{
			return false;
		}else {
			return true;
		}
	}

	function setCommentCookie($name,$mail,$url)
	{
		$cookietime = time() + 31536000;
		setcookie('commentposter',$name,$cookietime);
		setcookie('postermail',$mail,$cookietime);
		setcookie('posterurl',$url,$cookietime);
	}

}
