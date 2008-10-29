<?php
/**
 * 模型：撰写日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id: comment.php 682 2008-10-14 16:08:01Z emloog $
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
	function getLogNum($hide = 'n')
	{
		$DraftNum = '';
		$res = $this->dbhd->query("SELECT gid FROM $this->blogTable WHERE hide='$hide'");
		$LogNum = $this->dbhd->num_rows($res);
		return $LogNum;
	}

	/**
	 * 获取单条日志
	 *
	 * @param int $blogId
	 * @return array
	 */
	function getOneLog($blogId,  $hide='')
	{
		$hideState = $hide == 'n' ? "and hide='n'" :'';
		$sql = "select * from $this->blogTable where gid=$blogId $hideState";
		$res = $this->dbhd->query($sql);
		$row = $this->dbhd->fetch_array($res);
		if($row)
		{
			$logData = array(
			'blogtitle' => htmlspecialchars($row['title']),
			'log_title' => htmlspecialchars($row['title']),
			'post_time' => date('Y-n-j G:i l',$row['date']),
			'logid' => intval($row['gid']),
			'tbscode' => substr(md5(date('Ynd')),0,5),
			'log_content' => rmBreak($row['content']),
			'allow_remark' => $row['allow_remark'],
			'allow_tb' => $row['allow_tb']
			);
			return $logData;
		}else {
			return false;
		}
	}

	/**
	 * 获取日志
	 *
	 * @param string $subSql
	 * @param int $page
	 * @return array
	 */
	function getLog($subSql, $hide_state, $page = 1)
	{
		$start_limit = !empty($page) ? ($page - 1) *15 : 0;
		$sql = "SELECT gid,title,date,top,comnum,views FROM $this->blogTable WHERE hide='$hide_state' $subSql LIMIT $start_limit, 15";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['title'] = htmlspecialchars($row['title']);
			$gid = $row['gid'];
			$postTime = date("Y-m-d H:i",$row['date']);
			$istop = $row['top']=='y' ? "<font color=\"red\">[推荐]</font>" : '';
			$query=$this->dbhd->query("SELECT blogid FROM ".DB_PREFIX."attachment WHERE blogid='".$row['gid']."' ");
			$attach_num = $this->dbhd->num_rows($query);
			$attach = $attach_num > 0 ? "<font color=\"green\">[附件:".$attach_num."]</font>" : '';

			$logs[] = array(
			'title'=>!empty($row['title']) ? $row['title'] : 'No Title',
			'gid'=>$gid,
			'date'=>$postTime,
			'comnum'=>$row['comnum'],
			'views'=>$row['views'],
			'istop'=>$istop,
			'attach'=>$attach
			);
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
		$this->dbhd->query("UPDATE ".DB_PREFIX."tag SET usenum=usenum-1,gid= REPLACE(gid,',$blogId,',',') WHERE gid LIKE '%".$blogId."%' ");
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."tag WHERE usenum=0 ");
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
	 *
	 */
	function postDate($timezone=8, $hour=null, $min=null,$sec=null, $month=null, $day=null,$year=null)
	{
		$localtime = $timezone != 8 ? time() - ($timezone - 8) * 3600 : time();
		$postTime = $localtime;
		if($hour && $min && $sec && $month && $day && $year)
		{
			$postTime = @gmmktime($hour, $min, $sec, $month, $day, $year);
			if($postTime === false)
			{
				$postTime = $localtime;
			}
		}
		return $postTime;
	}

	function neighborLog($blogId)
	{
		$neighborlog = array();
		$neighborlog['nextLog'] = $this->dbhd->fetch_one_array("SELECT title,gid FROM ".DB_PREFIX."blog WHERE gid < $blogId AND hide = 'n' ORDER BY gid DESC  LIMIT 1");
		$neighborlog['prevLog'] = $this->dbhd->fetch_one_array("SELECT title,gid FROM ".DB_PREFIX."blog WHERE gid > $blogId AND hide = 'n' LIMIT 1");
		return $neighborlog;
	}



}

?>
