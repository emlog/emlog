<?php
/**
 * 模型：撰写日志
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

class emBlog {

	var $dbhd;
	var $blogTable;

	function emBlog($dbhandle)
	{
		$this->dbhd = $dbhandle;
		$this->blogTable = DB_PREFIX.'blog';
	}

	/**
	 * 存储日志到数据库
	 *
	 * @param array $logData
	 * @return int logid
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
		$this->dbhd->query("insert into $this->blogTable ($field) values($values)");
		$logid = $this->dbhd->insert_id();
		return $logid;
	}

	/**
	 * 更新日志内容
	 *
	 * @param array $logData
	 * @param int $blogId
	 */
	function updateLog($logData,$blogId)
	{
		$Item = array();
		foreach ($logData as $key => $data)
		{
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->dbhd->query("update $this->blogTable set $upStr where gid=$blogId");
	}

	/**
	 * 获取指定条件的日志条数
	 *
	 * @param unknown_type $blogId
	 * @return unknown
	 */
	function getLogNum($hide = 'n', $condition = '')
	{
		$DraftNum = '';
		$res = $this->dbhd->query("SELECT gid FROM $this->blogTable WHERE hide='$hide' $condition");
		$LogNum = $this->dbhd->num_rows($res);
		return $LogNum;
	}

	/**
	 * 获取单条日志
	 *
	 * @param int $blogId
	 * @return array
	 */
	function getOneLog($blogId,  $hide='', $type='admin')
	{
		$hideState = $hide == 'n' ? "and hide='n'" :'';
		$sql = "select * from $this->blogTable where gid=$blogId $hideState";
		$res = $this->dbhd->query($sql);
		$row = $this->dbhd->fetch_array($res);
		if($row)
		{
			switch ($type)
			{
				case 'admin':
					$row['title'] = htmlspecialchars($row['title']);
					$row['content'] = htmlspecialchars($row['content']);
					$row['excerpt'] = htmlspecialchars($row['excerpt']);
					$row['password'] = htmlspecialchars($row['password']);
					$logData = $row;
					break;
				case 'homepage':
					$logData = array(
					'log_title'	=> htmlspecialchars($row['title']),
					'post_time' => date('Y-n-j G:i l',$row['date']),
					'logid' => intval($row['gid']),
					'sortid' => intval($row['sortid']),
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
					break;
			}
			return $logData;
		}else {
			return false;
		}
	}

	/**
	 * 获取日志
	 *
	 * @param string $condition
	 * @param int $page
	 * @return array
	 */
	function getLog($condition, $hide_state, $page = 1, $prePageNum = 15, $type='admin')
	{
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$sql = "SELECT * FROM $this->blogTable WHERE hide='$hide_state' $condition LIMIT $start_limit, $prePageNum";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			switch ($type)
			{
				case 'admin':
					$row['date'] = date("Y-m-d H:i",$row['date']);
					$row['title'] = !empty($row['title']) ? htmlspecialchars($row['title']) : 'No Title';
					$row['gid'] = $row['gid'];
					$row['comnum'] = $row['comnum'];
					$row['istop'] = $row['top']=='y' ? "<font color=\"red\">[推荐]</font>" : '';
					$row['attnum'] = $row['attnum'] > 0 ? "<font color=\"green\">[附件:".$row['attnum']."]</font>" : '';
					break;
				case 'homepage':
					$row['post_time'] = date('Y-n-j G:i l',$row['date']);
					$row['log_title'] = htmlspecialchars(trim($row['title']));
					$row['logid'] = $row['gid'];
					$cookiePassword = isset($_COOKIE['em_logpwd_'.$row['gid']]) ? addslashes(trim($_COOKIE['em_logpwd_'.$row['gid']])) : '';
					if(!empty($row['password']) && !$cookiePassword)
					{
						$row['excerpt'] = '<p>[该日志已设置加密]</p>';
					}else{
						if(!empty($row['excerpt']))
						{
							$row['excerpt'] .= '<p><a href="./?action=showlog&gid='.$row['logid'].'">阅读全文&gt;&gt;</a></p>';
						}
					}
					$row['log_description'] = empty($row['excerpt']) ? breakLog($row['content'],$row['gid']) : $row['excerpt'];
					$row['toplog'] = $row['top'];
					$row['attachment'] = '';//attachment
					$row['tag']  = '';//tag
					break;
			}
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 删除日志
	 *
	 * @param unknown_type $gid
	 */
	function deleteLog($blogId)
	{
		$this->dbhd->query("DELETE FROM $this->blogTable where gid=$blogId");
		//评论
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."comment where gid=$blogId");
		//引用
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."trackback where gid=$blogId");
		//标签
		$this->dbhd->query("UPDATE ".DB_PREFIX."tag SET gid= REPLACE(gid,',$blogId,',',') WHERE gid LIKE '%".$blogId."%' ");
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."tag WHERE gid=',' ");
		//附件
		$query = $this->dbhd->query("select filepath from ".DB_PREFIX."attachment where blogid=$blogId ");
		while ($attach=$this->dbhd->fetch_array($query))
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
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."attachment where blogid=$blogId");
	}

	/**
	 * 隐藏/显示日志
	 *
	 * @param int $blogId
	 * @param string $hideState
	 */
	function hideSwitch($blogId, $hideState)
	{
		$this->dbhd->query("UPDATE $this->blogTable SET hide='$hideState' WHERE gid=$blogId");
		$this->dbhd->query("UPDATE ".DB_PREFIX."comment SET hide='$hideState' WHERE gid=$blogId");
	}

	/**
	 * 获取日志发布时间
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
		}
		return $unixPostDate;
	}

	/**
	 * 增加阅读次数
	 *
	 * @param int $blogId
	 */
	function updateViewCount($blogId)
	{
		$this->dbhd->query("UPDATE $this->blogTable SET views=views+1 WHERE gid=$blogId");
	}

	/**
	 * 获取相邻日志
	 *
	 * @param int $blogId
	 * @return array
	 */
	function neighborLog($blogId)
	{
		$neighborlog = array();
		$neighborlog['nextLog'] = $this->dbhd->once_fetch_array("SELECT title,gid FROM $this->blogTable WHERE gid < $blogId AND hide = 'n' ORDER BY gid DESC  LIMIT 1");
		$neighborlog['prevLog'] = $this->dbhd->once_fetch_array("SELECT title,gid FROM $this->blogTable WHERE gid > $blogId AND hide = 'n' LIMIT 1");
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
	 * 获取指定数量最新日志
	 *
	 * @param int $num
	 * @return array
	 */
	function getNewLog($num)
	{
		$sql = "SELECT gid,title FROM $this->blogTable WHERE hide='n' ORDER BY gid DESC LIMIT 0, $num";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 随机获取指定数量日志
	 *
	 * @param int $num
	 * @return array
	 */
	function getRandLog($num)
	{
		$sql = "SELECT gid,title FROM $this->blogTable WHERE hide='n' ORDER BY rand() LIMIT 0, $num";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 加密日志访问验证
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
请输入该日志的访问密码<br>
<input type="password" name="logpwd" /><input type="submit" value="进入.." />
<br /><br /><a href="./index.php">&laquo;返回首页</a>
</form>
</div>
</body>
</html>
EOT;
exit;
		}else {
			setcookie('em_logpwd_'.$logid, $logPwd);
		}
	}
}

?>