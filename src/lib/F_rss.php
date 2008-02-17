<?php
/**
 * Rss输出函数库
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

error_reporting(7);
//获取url地址
function GetURL()
{
	global $db_prefix;
	$path = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$path = str_replace("/rss.php","",$path);
	Return $path;
}
//获取日志信息
function GetBlog()
{
	global $db_prefix,$DB;
	$sql = "SELECT * FROM {$db_prefix}blog  WHERE hide='n' ORDER BY gid DESC limit 0,20";
	$result = $DB->query($sql);
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
//获取日志数目
function GetBlogNum()
{
	$blog_t =  GetBlog();
	return count($blog_t);
}
//截取字符
function subString($strings,$start,$length) 
{
	$str = substr($strings, $start, $length);
	$char = 0;
	for($i = 0; $i < strlen($str); $i++) {
			if (ord($str[$i]) > 128)
                $char++;
		}
		$str2 = substr($strings, $start, $length+1);
			if ($char%2 == 1){
                if ($length <= strlen($strings)) {
                    $str2 = $str2 .= "...";
                }
                return $str2;
            }
            if ($char%2 == 0) {
                if ($length <= strlen($strings)) {
                    $str = $str .= "...";
                }
                return $str;
            }
}
//日志分割
function breakLog($content)
{
	$a = explode('[break]',$content);
	if(!empty($a[1]))
		$a[0].='......';
	return $a[0];
}

$URL		= GetURL();
$site		=  $config_cache;
$blog		= GetBlog();
$blognum	 = GetBlogNum();
$author = $user_cache['name'];
?>