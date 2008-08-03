<?php
/**
 * Rss输出函数库
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

/**
 * 获取url地址
 *
 * @return unknown
 */
function GetURL()
{
	global $db_prefix;
	$path = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$path = str_replace("/rss.php","",$path);
	Return $path;
}

/**
 * 获取日志信息
 *
 * @return array
 */
function GetBlog()
{
	global $db_prefix,$DB;
	$sql = "SELECT * FROM {$db_prefix}blog  WHERE hide='n' ORDER BY gid DESC limit 0,20";
	$result = $DB->query($sql);
	$blog = array();
	while($re = $DB->fetch_array($result))
	{
		$re['id'] 		= $re['gid'];
		$re['title']		= htmlspecialchars($re['title']);
		$re['date']		= $re['date'];
		$re['content']	= $re['content'];

		$blog[] = $re;
	}
	return $blog;
}

/**
 * 获取日志数目
 *
 * @return unknown
 */
function GetBlogNum()
{
	$blog_t =  GetBlog();
	return count($blog_t);
}
?>