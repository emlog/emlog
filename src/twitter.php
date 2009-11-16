<?php
/**
 * twitter
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id$
*/

require_once('common.php');

if ($action == '')
{
	$twitter = '';
	$twitter.= getindextw();
	echo $twitter;
}
//add twitter
if (ROLE == 'admin' && $action == 'add')
{
	$content = isset($_POST['tw']) ? addslashes($_POST['tw']) : '';
	if (!empty($content))
	{
		$twitter = '';
		$query = $DB->query("INSERT INTO ".DB_PREFIX."twitter (content,date) VALUES('$content','$localdate')");
		$CACHE->mc_twitter();
		$CACHE->mc_sta();
		$twitter.=getindextw();
		echo $twitter;
	}
}
//del twitter
if (ROLE == 'admin' && $action == 'del')
{
	$twid = isset($_GET['twid']) ? intval($_GET['twid']) : '';
	$twitter = '';
	$query = $DB->query("DELETE FROM ".DB_PREFIX."twitter WHERE id=$twid");
	$CACHE->mc_twitter();
	$CACHE->mc_sta();
	$twitter.=getindextw();
	echo $twitter;
}
//get twitter
function getindextw()
{
	global $DB,$index_twnum;

	$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
	$start_limit = $page ? ($page - 1) * $index_twnum : 0;

	$twitter = '';

	$query = $DB->query("SELECT id FROM ".DB_PREFIX."twitter");
	$twnum = $DB->num_rows($query);

	$query = $DB->query("SELECT * FROM ".DB_PREFIX."twitter ORDER BY id DESC LIMIT $start_limit,$index_twnum");
	while ($rows = $DB->fetch_array($query))
	{
		extract($rows);
		$content = htmlspecialchars($content);
		$date = smartyDate($date);
		$delbt = ROLE == 'admin' ? "<a href=\"javascript:void(0);\" onclick=\"isdel($id,'twitter')\">删除</a>" : '';
		$twitter .= "<li>$content $delbt<br /><span>$date</span></li>";
	}
	$pagenums = ceil($twnum / $index_twnum);
	$NextPage = $page < $pagenums ? $page+1 : $page;
	$UpPage = $page > 1 ? $page - 1 : $page ;
	if ($page != 1 && $page != $pagenums)
	{
		$twitter.= "<li><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=$UpPage','twitter')\">&laquo;较近的</a><small>$page/$pagenums</small><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=$NextPage','twitter')\">较早的&raquo;</a></li>";
	} elseif ($page == 1 && $pagenums > 1) {
		$twitter.= "<li><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>";
	} elseif ($page == $pagenums && $pagenums > 1) {
		$twitter.= "<li><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=$UpPage','twitter')\">&laquo;较近的</a></li>";
	}
	return $twitter;
}

?>