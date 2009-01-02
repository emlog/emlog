<?php
/**
 * 模型：评论管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id: comment.php 682 2008-10-14 16:08:01Z emloog $
 */


class emComment {

	var $dbhd;
	var $commentTable;

	function emComment($dbhandle)
	{
		$this->dbhd = $dbhandle;
		$this->commentTable = DB_PREFIX.'comment';
	}

	/**
	 * 获取评论
	 *
	 * @param int $blogId
	 * @param int $page
	 * @return array $comment
	 */
	function getComment($blogId = null, $hide = null, $page = null)
	{
		$andQuery = $blogId ? "where gid=$blogId" : '';
		$condition = '';
		if($page)
		{
			$startId = ($page - 1) *15;
			$condition = "LIMIT $startId, 15";
		}
		$ishide = $hide ? "and hide='$hide'" : '';
		$sql = "SELECT * FROM $this->commentTable $andQuery $ishide ORDER BY cid DESC $condition";
		$ret = $this->dbhd->query($sql);
		$comments = array();
		while($row = $this->dbhd->fetch_array($ret))
		{
			$row['cname'] = htmlspecialchars($row['poster']);
			$row['mail'] = htmlspecialchars($row['mail']);
			$row['url'] = htmlspecialchars($row['url']);
			$row['content'] = htmlClean($row['comment']);
			$row['date'] = date("Y-m-d H:i",$row['date']);
			$row['reply'] = trim($row['reply']);
			$comments[] = $row;
		}
		return $comments;
	}
	function getOneComment($commentId)
	{
		$sql = "select * from $this->commentTable where cid=$commentId";
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
		$res = $this->dbhd->query("SELECT cid FROM $this->commentTable $andQuery");
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
		$row = $this->dbhd->once_fetch_array("SELECT gid,hide FROM $this->commentTable WHERE cid=$commentId");
		$this->dbhd->query("DELETE FROM $this->commentTable where cid=$commentId");
		$blogId = intval($row['gid']);
		if($row['hide'] == 'n')
		{
			$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET comnum=comnum-1 WHERE gid=$blogId");
		}
	}
	/**
	 * 显示/隐藏评论
	 *
	 * @param int $commentId
	 */
	function hideComment($commentId)
	{
		$row = $this->dbhd->once_fetch_array("SELECT gid,hide FROM $this->commentTable WHERE cid=$commentId");
		$blogId = intval($row['gid']);
		$isHide = $row['hide'];
		if($isHide == 'n')
		{
			$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET comnum=comnum-1 WHERE gid=$blogId");
		}
		$this->dbhd->query("UPDATE $this->commentTable SET hide='y' WHERE cid=$commentId");
	}
	function showComment($commentId)
	{
		$row = $this->dbhd->once_fetch_array("SELECT gid,hide FROM $this->commentTable WHERE cid=$commentId");
		$blogId = intval($row['gid']);
		$isHide = $row['hide'];
		if($isHide == 'y')
		{
			$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET comnum=comnum+1 WHERE gid=$blogId");
		}
		$this->dbhd->query("UPDATE $this->commentTable SET hide='n' WHERE cid=$commentId");
	}

	/**
	 * 回复评论
	 *
	 * @param int $commentId
	 * @param string $reply
	 */
	function replyComment($commentId, $reply)
	{
		$sql="UPDATE $this->commentTable SET reply='$reply' where cid=$commentId ";
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

	/**
	 * 添加评论
	 *
	 * @param unknown_type $name
	 * @param unknown_type $content
	 * @param unknown_type $mail
	 * @param unknown_type $url
	 * @param unknown_type $imgcode
	 * @param unknown_type $comment_code
	 * @param unknown_type $ischkcomment
	 * @param unknown_type $localdate
	 * @param unknown_type $blogId
	 */
	function addComment($name, $content, $mail, $url, $imgcode, $comment_code, $ischkcomment, $localdate, $blogId)
	{
		if( $comment_code == 'y' )
		{
			session_start();
		}
		if ($url && strncasecmp($url,'http://',7))//0 if they are equal
		{
			$url = 'http://'.$url;
		}
		$this->setCommentCookie($name,$mail,$url,$localdate);
		if($this->isLogCanComment($blogId) === false)
		{
			msg('该日志不接受评论','javascript:history.back(-1);');
		}elseif ($this->isCommentExist($blogId, $name, $content) === true){
			msg('评论已存在','javascript:history.back(-1);');
		}elseif (preg_match("/['<>,#|;\/\$\\&\r\t()%@+?^]/",$name) || strlen($name) > 20 || strlen($name) == 0){
			msg('姓名非法!','javascript:history.back(-1);');
		} elseif ($mail != '' && !checkMail($mail)) {
			msg('邮件格式错误!', 'javascript:history.back(-1);');
		} elseif (strlen($content) == '' || strlen($content) > 2000) {
			msg('评论内容非法','javascript:history.back(-1);');
		} elseif ($imgcode == '' && $comment_code == 'y') {
			msg('验证码不能为空','javascript:history.back(-1);');
		} elseif ($comment_code == 'y' && $imgcode != $_SESSION['code']) {
			msg('验证码错误!','javascript:history.back(-1);');
		} else {
			$sql = "INSERT INTO $this->commentTable (date,poster,gid,comment,reply,mail,url,hide) VALUES ('$localdate','$name','$blogId','$content','','$mail','$url','$ischkcomment')";
			$ret = $this->dbhd->query($sql);
			if ($ischkcomment == 'n')
			{
				$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET comnum = comnum + 1 WHERE gid='$blogId'");
				return 0;
			} else {
				return 1;
			}
		}
	}

	function isCommentExist($blogId, $name, $content)
	{
		$query = $this->dbhd->query("SELECT cid FROM $this->commentTable WHERE gid=$blogId AND poster='$name' AND comment='$content'");
		$result = $this->dbhd->num_rows($query);
		if ($result > 0)
		{
			return true;
		}else {
			return false;
		}
	}

	function isLogCanComment($blogId)
	{
		$query = $this->dbhd->query("SELECT allow_remark FROM ".DB_PREFIX."blog WHERE gid=$blogId");
		$show_remark = $this->dbhd->fetch_array($query);
		if ($show_remark['allow_remark'] == 'n')
		{
			return false;
		}else {
			return true;
		}
	}

	function setCommentCookie($name,$mail,$url,$localdate)
	{
		$cookietime = $localdate + 31536000;
		setcookie('commentposter',$name,$cookietime);
		setcookie('postermail',$mail,$cookietime);
		setcookie('posterurl',$url,$cookietime);
	}

}

?>
