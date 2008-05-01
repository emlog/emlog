<?php
/**
 * twitter生成
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.5
*/

require_once('./common.php');

if($action == '')
{
	$twitter = '';
	$twitter.=getindextw();
	echo $twitter;
}
//新增加
if(ISLOGIN === true && $action == 'add')
{
	$content = isset($_POST['tw'])?addslashes($_POST['tw']):'';
	if(!empty($content))
	{
		$twitter = '';
		$time = time();
		$query = $DB->query("INSERT INTO {$db_prefix}twitter (content,date) VALUES('$content','$time')");
		$MC->mc_twitter('./cache/twitter');
		$twitter.=getindextw();
		echo $twitter;
	}
}
//删除
if(ISLOGIN === true && $action == 'del')
{
	$twid = isset($_GET['twid'])?intval($_GET['twid']):'';
	$twitter = '';
	$query = $DB->query("DELETE FROM {$db_prefix}twitter WHERE id=$twid");
	$MC->mc_twitter('./cache/twitter');
	$twitter.=getindextw();
	echo $twitter;
}
//读取twitter
function getindextw()
{
	global $DB,$db_prefix,$index_twnum;

	$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
	$start_limit = $page?($page - 1) * $index_twnum:0;

	$twitter = '';

	$query = $DB->query("SELECT id FROM {$db_prefix}twitter");
	$twnum = $DB->num_rows($query);

	$query = $DB->query("SELECT * FROM {$db_prefix}twitter ORDER BY id DESC LIMIT $start_limit,$index_twnum");
	while ($rows = $DB->fetch_array($query))
	{
		extract($rows);
		$date = date("Y-m-d H:i",$date);
		$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel($id,'twitter')\">删除</a>":'';
		$twitter .="<li>$content $delbt<br /><span>$date</span></li>";
	}
	$pagenums = ceil($twnum/$index_twnum);
	$NextPage = $page<$pagenums?$page+1:$page;
	$UpPage = $page>1?$page-1:$page;
	if($page!=1 && $page!=$pagenums)
	{
		$twitter.= "<li><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=$UpPage','twitter')\">&laquo;较近的</a><small>$page/$pagenums</small><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=$NextPage','twitter')\">较早的&raquo;</a></li>";
	}elseif ($page == 1 && $pagenums>1)
	{
		$twitter.= "<li><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>";
	}elseif ($page == $pagenums && $pagenums>1)
	{
		$twitter.= "<li><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=$UpPage','twitter')\">&laquo;较近的</a></li>";
	}
	return $twitter;
}

?>