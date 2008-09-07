<?php
/**
 * 撰写日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

$pid = isset($_GET['pid']) ? $_GET['pid'] : '';

if($action == '')
{
	include getViews('header');
	//已有tags
	$query = $DB->query("select tagname from {$db_prefix}tag");
	$oldtags = '';
	while($tags = $DB->fetch_array($query))
	{
		$oldtags .=" <a href=\"javascript: inserttag('".$tags['tagname']."','tags');\">".$tags['tagname']."</a> "	;
	}
	//时间
	$year = date('Y');
	$month = date('m');
	$day = date('d');
	$hour = date('H');
	$minute = date('i');
	$second	 = date('s');

	require_once(getViews('add_log'));
	include getViews('footer');
	cleanPage();
}

//添加日志
if($action== 'addlog')
{
	if($pid == 'draft')
	{
		$ishide='y';
		$ok_msg = '日志成功保存为草稿！';
		$ok_url = 'admin_log.php?pid=draft';
	}else{
		$ishide = 'n';
		$ok_msg = '日志成功发布！';
		$ok_url = 'admin_log.php';
	}
	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
	$edittime = isset($_POST['edittime']) ? intval(isset($_POST['edittime'])) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$blogid = isset($_POST['as_logid']) ? intval(trim($_POST['as_logid'])) : -1;//如被自动保存为草稿则有blog id号
	$pingurl  = isset($_POST['pingurl']) ? addslashes($_POST['pingurl']) : '';
	$allow_remark = isset($_POST['allow_remark']) ? addslashes($_POST['allow_remark']) : '';
	$allow_tb = isset($_POST['allow_tb']) ? addslashes($_POST['allow_tb']) : '';
	$tbmsg = '';

	//查询嵌入到日志中的附件id 存入数组
	preg_match_all("/ematt:([0-9]+)/i",$content, $matches );
	$cont_attid = serialize($matches[1]);

	//时间处理
	if($timezone!=8)
	{
		$oversec = ($timezone-8)*3600;
		$localtime = time()-$oversec;
	}else{
		$localtime = time();
	}
	if($edittime)
	{
		$newtime = @gmmktime(intval($_POST['newhour']),intval($_POST['newmin']),
		intval($_POST['newsec']),intval($_POST['newmonth']),
		intval($_POST['newday']),intval($_POST['newyear'])) - $timezone * 3600;
		if(empty($newtime))
		$newtime = $localtime;
	} else{
		$newtime = $localtime;
	}

	//日志写入数据库
	if($blogid > 0)
	{
		$sql=" UPDATE {$db_prefix}blog SET
				title='$title',
				date='$newtime',
				allow_remark='$allow_remark',
				allow_tb='$allow_tb',
				content='$content',
				hide='$ishide',
				attcache='$cont_attid'
				WHERE gid='$blogid' ";
		$DB->query($sql);
		//获取当前添加日志ID
		$logid = $blogid;
	}else{
		$sql="insert into {$db_prefix}blog (`title`,`date`,`content`,`hide`,`allow_remark`,`allow_tb`,`attcache`) values('$title','$newtime','$content','$ishide','$allow_remark','$allow_tb','$cont_attid')";
		$DB->query($sql);
		//获取当前添加日志ID
		$logid=$DB->insert_id();
	}
	//写入tag
	if (!empty($tagstring))
	{
		$tag = explode(',',$tagstring);
		$tag = formatArray($tag);
		for ($i = 0; $i < count($tag); $i++)
		{
			$result = $DB->fetch_one_array("SELECT tagname FROM {$db_prefix}tag WHERE `tagname`='".trim($tag[$i])."' ");
			if(empty($result)) {
				$query="INSERT INTO {$db_prefix}tag (`tagname`,`gid`) VALUES('".$tag[$i]."',',$logid,')";
				$DB->query($query);
			}else{
				$query="UPDATE {$db_prefix}tag SET `usenum`=`usenum`+1, `gid`=concat(`gid`,'$logid,') where `tagname` = '".$tag[$i]."' ";
				$DB->query($query);
			}
		}
		$MC->mc_tags('../cache/tags');
	}
	// 发送Trackback部分
	if(!empty($pingurl))
	{
		$url = $blogurl."index.php?action=showlog&gid=".$logid;
		$hosts = explode("\n", $pingurl);
		$tbmsg = '';
		foreach ($hosts as $key => $value)
		{
			$host = trim($value);
			if(strstr(strtolower($host), "http://") || strstr(strtolower($host), "https://"))
			{
				$data ="url=".rawurlencode($url)."&title=".rawurlencode($title)."&blog_name=".rawurlencode($blogname)."&excerpt=".rawurlencode($content);
				$result = strtolower(sendPacket($host, $data));
				if (strstr($result, "<error>0</error>") === false) {
					$tbmsg .= "(引用{$key}:发送失败)";
				} else {
					$tbmsg .= "(引用{$key}:发送成功)";
				}
			}
		}
	}
	$MC->mc_sta('../cache/sta');
	$MC->mc_record('../cache/records');
	$MC->mc_logtags('../cache/log_tags');
	$MC->mc_logatts('../cache/log_atts',$cont_attid);
	formMsg("$ok_msg\t$tbmsg",$ok_url,1);
}

//自动保存
if($action == 'autosave')
{
	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$logid = isset($_POST['as_logid']) ? intval((trim($_POST['as_logid']))) : '';

	if($logid >= 0)//编辑草稿
	{
		$sql=" UPDATE {$db_prefix}blog SET title='$title',content='$content' WHERE gid='$logid' ";
		$DB->query($sql);
		echo "autosave_gid:{$logid}_df:{$dftnum}_";
	}else{
		//日志写入数据库
		$time = time();
		$sql="insert into {$db_prefix}blog (`title`,`date`,`content`,`hide`,`allow_remark`,`allow_tb`,`attcache`) values('$title','$time','$content','y','y','y','')";
		$DB->query($sql);
		//获取当前添加日志ID
		$logid=$DB->insert_id();
		$dftnum = $DB->num_rows($DB->query("SELECT gid FROM {$db_prefix}blog WHERE hide='y'"));
		echo "autosave_gid:{$logid}_df:{$dftnum}_";
	}
}
?>