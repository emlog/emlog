<?php
/**
 * twitter
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id$
*/

require_once 'common.php';

if ($action == '')
{
	$twitter = '';
	$twitter.= getindextw();
	echo $twitter;
}
//add twitter
if (ISLOGIN === true && $action == 'add')
{
	$content = isset($_POST['tw']) ? addslashes($_POST['tw']) : '';
	if (!empty($content))
	{
		$twitter = '';
		$query = $DB->query("INSERT INTO ".DB_PREFIX."twitter (content,author,date) VALUES('$content',".UID.",'$localdate')");
		$CACHE->mc_sta();
		$twitter.=getindextw();
		echo $twitter;
	}
}
//del twitter
if (ISLOGIN === true && $action == 'del')
{
	$twid = isset($_GET['twid']) ? intval($_GET['twid']) : '';
	$author = ROLE == 'admin' ? '' : 'and author='.UID;
	$twitter = '';
	$query = $DB->query("DELETE FROM ".DB_PREFIX."twitter WHERE id=$twid $author");
	$CACHE->mc_sta();
	$twitter.=getindextw();
	echo $twitter;
}
//get twitter
function getindextw()
{
	global $DB,$user_cache,$index_twnum;

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
		$by = $author != 1 ? 'by:'.$user_cache[$author]['name'] : '';
		$delbt = ISLOGIN === true && $author == UID || ROLE == 'admin' ? "<a href=\"javascript:void(0);\" onclick=\"isdel($id,'twitter','".DYNAMIC_BLOGURL."')\">删除</a>" : '';
		$twitter .= "<li>$content $delbt<p>$by $date</p></li>";
	}
	$pagenums = ceil($twnum / $index_twnum);
	$NextPage = $page < $pagenums ? $page+1 : $page;
	$UpPage = $page > 1 ? $page - 1 : $page ;
	if($pagenums > 1){
		$twitter.= "
			<p>
			<a href=\"javascript:void(0);\" onclick=\"sendinfo('".DYNAMIC_BLOGURL."twitter.php?p=$UpPage','twitter')\" title=\"上一页\">&laquo;&laquo;</a>
			<small>$page/$pagenums</small>
			<a href=\"javascript:void(0);\" onclick=\"sendinfo('".DYNAMIC_BLOGURL."twitter.php?p=$NextPage','twitter')\" title=\"下一页\">&raquo;&raquo;</a>
			</p>";
	}
	return $twitter;
}
