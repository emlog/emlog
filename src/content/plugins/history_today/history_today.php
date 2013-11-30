<?php
/*
Plugin Name: 历史上的今天
Version: 1.0
Plugin URL:
Description: 在显示日志页面增加历史上的今天发表的文章
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

function history_today($logData = array())
{
	$DB = MySql::getInstance();
	$CACHE = Cache::getInstance();
	extract($logData);
	global $value;
	if(!empty($value['content']))
	{
		$logid = $value['id'];
		$date = $value['date'];
		global $abstract;
	}
	$year = gmdate('Y',$date);
	$month = gmdate('n',$date);
	$day = gmdate('j',$date);
	$sql = "SELECT gid,title,date FROM ".DB_PREFIX."blog WHERE hide='n' AND type='blog' AND gid!=$logid AND FROM_UNIXTIME(date,'%Y')!='$year' AND FROM_UNIXTIME(date,'%c')='$month' AND FROM_UNIXTIME(date,'%e')='$day'";
	$history_todays = array();
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
		$row['gid'] = intval($row['gid']);
		$row['title'] = htmlspecialchars($row['title']);
		$history_todays[] = $row;
	}
	$out = '';
	if(!empty($history_todays))
	{
		$out .= "<div class=\"related_post\">";
		$out .= "<h3>历史上的今天：</h3>\r\n<ul>";
		foreach($history_todays as $val)
		{
			$out .= "<li><a href=\"".Url::log($val['gid'])."\">{$val['title']}</a> <span>".gmdate('Y年',$val['date'])."</span></li>";
		}
		$out .= "</ul>\r\n</div>";
	}
	if(!empty($value['content']))
	{
		if(0)
		{
			$abstract .= $out;
		}
	}else{
		echo $out;
	}
}
addAction('log_related','history_today');
addAction('rss_display','history_today');

?>
