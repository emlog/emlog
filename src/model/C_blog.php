<?php
/**
 * Model: Blog Page Management
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

class emBlog {

	var $db;

	function emBlog($dbhandle)
	{
		$this->db = $dbhandle;
	}
	
	/**
	 * Add a new post
	 *
	 * @param array $logData
	 * @return int
	 */
	function addlog($logData)
	{
		$kItem = array();
		$dItem = array();
		foreach ($logData as $key => $data)
		{
			$kItem[] = $key;
			$dItem[] = $data;
		}
		$field = implode(',', $kItem);
		$values = "'".implode("','", $dItem)."'";
		$this->db->query("insert into ".DB_PREFIX."blog ($field) values($values)");
		$logid = $this->db->insert_id();
		return $logid;
	}

	/**
	 * Update the post content
	 *
	 * @param array $logData
	 * @param int $blogId
	 */
	function updateLog($logData, $blogId)
	{
		$author = ROLE == 'admin' ? '' : 'and author='.UID;
		$Item = array();
		foreach ($logData as $key => $data)
		{
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update ".DB_PREFIX."blog set $upStr where gid=$blogId $author");
	}

	/**
	 * Get the number of posts with specified conditions
	 *
	 * @param int $spot //0: foreground 1: Background
	 * @param string $hide
	 * @param string $condition
	 * @param string $type
	 * @return int
	 */
	function getLogNum($hide = 'n', $condition = '', $type = 'blog', $spot = 0)
	{
		$hide_state  = $hide ? "and hide='$hide'" : '';

		if($spot == 0)
		{
			$author = '';
		}else{
			$author = ROLE == 'admin' ? '' : 'and author='.UID;
		}

		$res = $this->db->query("SELECT gid FROM ".DB_PREFIX."blog WHERE type='$type' $hide_state $author $condition");
		$LogNum = $this->db->num_rows($res);
		return $LogNum;
	}

	/**
	 * Get a Single post by ID for Admin
	 *
	 * @param int $blogId
	 * @return array
	 */
	function getOneLogForAdmin($blogId)
	{
		global $lang;
		$author = ROLE == 'admin' ? '' : 'and author='.UID;
		$sql = "select * from ".DB_PREFIX."blog where gid=$blogId $author";
		$res = $this->db->query($sql);
		if ($this->db->affected_rows() < 1)
		{
			formMsg($lang['access_disabled'],'./', 0);
		}
		$row = $this->db->fetch_array($res);
		if($row)
		{
			$row['title'] = htmlspecialchars($row['title']);
			$row['content'] = htmlspecialchars($row['content']);
			$row['excerpt'] = htmlspecialchars($row['excerpt']);
			$row['password'] = htmlspecialchars($row['password']);
			$logData = $row;
			return $logData;
		}else {
			return false;
		}
	}

	/**
	 * Get a Single post by ID for homepage
	 *
	 * @param int $blogId
	 * @return array
	 */
	function getOneLogForHome($blogId)
	{
		$sql = "select * from ".DB_PREFIX."blog where gid=$blogId and hide='n'";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
		if($row)
		{
			$logData = array(
			'log_title'	=> htmlspecialchars($row['title']),
			'date' => $row['date'],
			'logid' => intval($row['gid']),
			'sortid' => intval($row['sortid']),
			'type' => $row['type'],
			'author' => $row['author'],
			'tbscode' => substr(md5(date('Ynd')),0,5),
			'log_content' => rmBreak($row['content']),
			'views'=>intval($row['views']),
			'comnum'=>intval($row['comnum']),
			'tbcount'=>intval($row['tbcount']),
			'top'=>$row['top'],
			'attnum'=>intval($row['attnum']),
			'allow_remark' => $row['allow_remark'],
			'allow_tb' => $row['allow_tb'],
			'password' => $row['password']
			);
			return $logData;
		}else {
			return false;
		}
	}

	/**
	 * Get posts by conditions for Admin
	 *
	 * @param string $condition
	 * @param string $hide_state
	 * @param int $page
	 * @param string $type
	 * @return array
	 */
	function getLogsForAdmin($condition = '', $hide_state = '', $page = 1, $type = 'blog')
	{
		global $lang;
		$start_limit = !empty($page) ? ($page - 1) * ADMIN_PERPAGE_NUM : 0;
		$author = ROLE == 'admin' ? '' : 'and author='.UID;
		$hide_state  = $hide_state ? "and hide='$hide_state'" : '';
		$limit = "LIMIT $start_limit, ".ADMIN_PERPAGE_NUM;
		$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE type='$type' $author $hide_state $condition $limit";
		$res = $this->db->query($sql);
		$logs = array();
		while($row = $this->db->fetch_array($res))
		{
			$row['date'] = date("Y-m-d H:i",$row['date']);
			$row['title'] = !empty($row['title']) ? htmlspecialchars($row['title']) : 'No Title';
			$row['gid'] = $row['gid'];
			$row['comnum'] = $row['comnum'];
			$row['istop'] = $row['top']=='y' ? "<font color=\"red\">[".$lang['recommended']."]</font>" : '';
			$row['attnum'] = $row['attnum'] > 0 ? "<font color=\"green\">[".$lang['attachments'].": ".$row['attnum']."]</font>" : '';
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * Get posts by conditions for Homepage
	 *
	 * @param string $condition
	 * @param int $page
	 * @param int $prePageNum
	 * @return array
	 */
	function getLogsForHome($condition = '', $page = 1, $prePageNum)
	{
		global $lang;
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE type='blog' and hide='n' $condition $limit";
		$res = $this->db->query($sql);
		$logs = array();
		while($row = $this->db->fetch_array($res))
		{
			//$row['date'];
			//$row['top'];
			$row['log_title'] = htmlspecialchars(trim($row['title']));
			$row['logid'] = $row['gid'];
			$cookiePassword = isset($_COOKIE['em_logpwd_'.$row['gid']]) ? addslashes(trim($_COOKIE['em_logpwd_'.$row['gid']])) : '';
			if(!empty($row['password']) && $cookiePassword != $row['password'])
			{
				$row['excerpt'] = '<p>['.$lang['blog_password_protected_info'].']</p>';
			}else{
				if(!empty($row['excerpt']))
				{
					$row['excerpt'] .= '<p><a href="./?post='.$row['logid'].'">'.$lang['read_more'].'&gt;&gt;</a></p>';
				}
			}
			$row['log_description'] = empty($row['excerpt']) ? breakLog($row['content'],$row['gid']) : $row['excerpt'];
			$row['attachment'] = '';
			$row['tag']  = '';
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * Delete the post by ID
	 *
	 * @param int $blogId
	 */
	function deleteLog($blogId)
	{
		global $lang;
		$author = ROLE == 'admin' ? '' : 'and author='.UID;
		$this->db->query("DELETE FROM ".DB_PREFIX."blog where gid=$blogId $author");
		if ($this->db->affected_rows() < 1)
		{
			formMsg($lang['access_disabled'],'./', 0);
		}
		//Comments
		$this->db->query("DELETE FROM ".DB_PREFIX."comment where gid=$blogId");
		//Trackbacks
		$this->db->query("DELETE FROM ".DB_PREFIX."trackback where gid=$blogId");
		//Tags
		$this->db->query("UPDATE ".DB_PREFIX."tag SET gid= REPLACE(gid,',$blogId,',',') WHERE gid LIKE '%".$blogId."%' ");
		$this->db->query("DELETE FROM ".DB_PREFIX."tag WHERE gid=',' ");
		//Attachments
		$query = $this->db->query("select filepath from ".DB_PREFIX."attachment where blogid=$blogId ");
		while ($attach=$this->db->fetch_array($query))
		{
			if (file_exists($attach['filepath']))
			{
				$fpath = str_replace('thum-', '', $attach['filepath']);
				if ($fpath != $attach['filepath'])
				{
					@unlink($fpath);
				}
				@unlink($attach['filepath']);
			}
		}
		$this->db->query("DELETE FROM ".DB_PREFIX."attachment where blogid=$blogId");
	}

	/**
	 * Hide/Show the post by ID
	 *
	 * @param int $blogId
	 * @param string $hideState
	 */
	function hideSwitch($blogId, $hideState)
	{
		$this->db->query("UPDATE ".DB_PREFIX."blog SET hide='$hideState' WHERE gid=$blogId");
		$this->db->query("UPDATE ".DB_PREFIX."comment SET hide='$hideState' WHERE gid=$blogId");
	}

	/**
	 * Make the post date/time
	 *
	 * @param int $timezone
	 * @param string $postDate
	 * @param string $oldDate
	 * @return date
	 */
	function postDate($timezone=8, $postDate=null, $oldDate=null)
	{
		$localtime = time() - ($timezone - 8) * 3600;
		$logDate = $oldDate ? $oldDate : $localtime;
		$unixPostDate = '';
		if($postDate)
		{
			$unixPostDate = @strtotime($postDate);
			if($unixPostDate === false)
			{
				$unixPostDate = $logDate;
			}
		}else{
			return $localtime;
		}
		return $unixPostDate;
	}

	/**
	 * Update the post view count
	 *
	 * @param int $blogId
	 */
	function updateViewCount($blogId)
	{
		$this->db->query("UPDATE ".DB_PREFIX."blog SET views=views+1 WHERE gid=$blogId");
	}

	/**
	 * Make Link to the nearest posts
	 *
	 * @param int $date unix Timestamp
	 * @return array
	 */
	function neighborLog($date)
	{
		$neighborlog = array();
		$neighborlog['nextLog'] = $this->db->once_fetch_array("SELECT title,gid FROM ".DB_PREFIX."blog WHERE date < $date and hide = 'n' and type='blog' ORDER BY date DESC LIMIT 1");
		$neighborlog['prevLog'] = $this->db->once_fetch_array("SELECT title,gid FROM ".DB_PREFIX."blog WHERE date > $date and hide = 'n' and type='blog' ORDER BY date LIMIT 1");
		if($neighborlog['nextLog'])
		{
			$neighborlog['nextLog']['title'] = htmlspecialchars($neighborlog['nextLog']['title']);
		}
		if($neighborlog['prevLog'])
		{
			$neighborlog['prevLog']['title'] = htmlspecialchars($neighborlog['prevLog']['title']);
		}
		return $neighborlog;
	}

	/**
	 * Select the Latest Posts (num)
	 *
	 * @param int $num
	 * @return array
	 */
	function getNewLog($num)
	{
		$sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE hide='n' and type='blog' ORDER BY gid DESC LIMIT 0, $num";
		$res = $this->db->query($sql);
		$logs = array();
		while($row = $this->db->fetch_array($res))
		{
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * Get Random Post
	 *
	 * @param int $num
	 * @return array
	 */
	function getRandLog($num)
	{
		$sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE hide='n' and type='blog' ORDER BY rand() LIMIT 0, $num";
		$res = $this->db->query($sql);
		$logs = array();
		while($row = $this->db->fetch_array($res))
		{
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * Password Authenticate
	 *
	 * @param string $pwd
	 * @param string $pwd2
	 */
	function authPassword($postPwd, $cookiePwd, $logPwd, $logid)
	{
		$pwd = $cookiePwd ? $cookiePwd : $postPwd;
		if($pwd !== addslashes($logPwd))
		{
			echo <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog message</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	margin-top:20px;
	font-size: 12px;
	color: #666666;
	width:580px;
	margin:10px 200px;
	padding:10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
-->
</style>
</head>
<body>
<div class="main">
<form action="" method="post">
{$lang['blog_enter_password']}<br>
<input type="password" name="logpwd" /><input type="submit" value="{$lang['enter']}.." />
<br /><br /><a href="./">&laquo; {$lang['home']}</a>
</form>
</div>
</body>
</html>
EOT;
			if($cookiePwd)
			{
				setcookie('em_logpwd_'.$logid, ' ', time() - 31536000);
			}
			exit;
}else {
	setcookie('em_logpwd_'.$logid, $logPwd);
}
	}
}
