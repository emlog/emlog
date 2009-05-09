<?php
/**
 * 引用通告接收主程序
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

require_once('init.php');

$blogid = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
$ec = isset($_REQUEST['ec']) ? strtolower($_REQUEST['ec']) : '';
$sc = isset($_REQUEST['sc']) ? $_REQUEST['sc'] : '';
$encode = 'utf-8';
$charset = isset($_SERVER['HTTP_ACCEPT_CHARSET']) ? strtolower($_SERVER['HTTP_ACCEPT_CHARSET']) : '';
if ($charset && !strstr($charset, 'utf-8')) 
{
	$encode = $charset;
}

$title     = isset($_REQUEST['title']) ? iconv2utf(html2text(addslashes(trim($_REQUEST['title'])))) : '';
$excerpt   = isset($_REQUEST['excerpt']) ? trimmed_title(iconv2utf(html2text(addslashes(trim($_REQUEST['excerpt'])))), 255) : '';
$url       = isset($_REQUEST['url']) ? addslashes(trim($_REQUEST['url'])) : '';
$blog_name = isset($_REQUEST['blog_name']) ? iconv2utf(html2text(addslashes(trim($_REQUEST['blog_name'])))) : '';
$ipaddr	   = getIp();

if ($istrackback=='y' && $blogid && $title && $excerpt && $url && $blog_name)
{
	if($sc != substr(md5(date('Ynd')),0,5))
	{
		showXML('引用地址已失效');
	}
	
	$blog = $DB->once_fetch_array("SELECT allow_tb FROM ".DB_PREFIX."blog WHERE gid='".$blogid."'");
	if (empty($blog))
	{
		showXML('日志不存在');
	}elseif ($blog['allow_tb']=='n'){
		showXML('该日志不允许引用');
	}

	$visible = false;
	$point = 0;
	$source_content = '';
	$source_content = fopen_url($url);
	$this_server = str_replace(array('www.', 'http://'), '', $_SERVER['HTTP_HOST']);
	
	//获取接受来的url原代码和本服务器的hostname
	if (empty($source_content))
	{
		//没有获得原代码就-1分
		$point -= 1;
	}else {
		if (strpos(strtolower($source_content), strtolower($this_server)) !== FALSE)
		{
			//对比链接，如果原代码中包含本站的hostname就+1分，这个未必成立
			$point += 1;
		}
		if (strpos(strtolower($source_content), strtolower($title)) !== FALSE)
		{
			//对比标题，如果原代码中包含发送来的title就+1分，这个基本可以成立
			$point += 1;
		}
		if (strpos(strtolower($source_content), strtolower($excerpt)) !== FALSE)
		{
			//对比内容，如果原代码中包含发送来的excerpt就+1分，这个由于标签或者其他原因，未必成立
			$point += 1;
		}
	}
	$interval = 3600*5;
	$timestamp = time();
	//设置防范时间间隔 同一ip每5小时能引用一次
	$query = $DB->query("SELECT tbid FROM ".DB_PREFIX."trackback WHERE ip='$ipaddr' AND date+$interval>=$timestamp");
	if ($DB->num_rows($query))
	{
		$point -= 2;
	}

	$query = $DB->query("SELECT tbid FROM ".DB_PREFIX."trackback WHERE REPLACE(LCASE(url),'www.','')='".str_replace('www.','',strtolower($url))."'");
	//对比数据库中的url和接收来的
	if ($DB->num_rows($query))
	{
		$point -= 1;
	}
	
	$visible = ($point < 2) ? false : true;

	if ($visible === true)
	{
		//插入数据
		$query = "INSERT INTO ".DB_PREFIX."trackback (gid, title, date, excerpt, url, blog_name,ip) VALUES($blogid, '$title', '$localdate', '$excerpt', '$url', '$blog_name','$ipaddr')";
		$DB->query($query);
		//更新文章Trackback数量
		$DB->query("UPDATE ".DB_PREFIX."blog SET tbcount=tbcount+1 WHERE gid='".intval($blogid)."'");
		$CACHE->mc_sta();
		$CACHE->mc_user();
		showXML('成功接收', 0);
	}else {
		showXML('主动拒绝引用');
	}
}else{
	showXML('参数错误');
}

//发送消息页面
function showXML($message, $error = 1)
{
	header('Content-type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<response>\n";
	echo "<error>$error</error>\n";
	echo "<message>$message</message>\n";
	echo "</response>\n";
	exit;
}

// HTML转换为纯文本
function html2text($content)
{
	$content = preg_replace("/<style .*?<\/style>/is", "", $content);
	$content = preg_replace("/<script .*?<\/script>/is", "", $content);
	$content = preg_replace("/<br\s*\/?>/i", "\n", $content);
	$content = preg_replace("/<\/?p>/i", "\n", $content);
	$content = preg_replace("/<\/?td>/i", "\n", $content);
	$content = preg_replace("/<\/?div>/i", "\n", $content);
	$content = preg_replace("/<\/?blockquote>/i", "\n", $content);
	$content = preg_replace("/<\/?li>/i", "\n", $content);
	$content = strip_tags($content);
	$content = preg_replace("/\&\#.*?\;/i", "", $content);
	return $content;
}
//格式化标题，截取过长的标题并转化编码为utf8
function trimmed_title($text, $limit=12)
{
	$val = csubstr($text, 0, $limit);
	return $val[1] ? $val[0]."..." : $val[0];
}
function csubstr($text, $start=0, $limit=12)
{
	if (function_exists('mb_substr')){
		$more = (mb_strlen($text) > $limit) ? TRUE : FALSE;
		$text = mb_substr($text, 0, $limit, 'UTF-8');
		return array($text, $more);
	} elseif (function_exists('iconv_substr')) {
		$more = (iconv_strlen($text) > $limit) ? TRUE : FALSE;
		$text = iconv_substr($text, 0, $limit, 'UTF-8');
		return array($text, $more);
	} else {
		preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);
		if(func_num_args() >= 3)
		{
			if (count($ar[0])>$limit)
			{
				$more = TRUE;
				$text = join("",array_slice($ar[0],0,$limit))."...";
			}
			$more = TRUE;
			$text = join("",array_slice($ar[0],0,$limit));
		} else {
			$more = FALSE;
			$text =  join("",array_slice($ar[0],0));
		}
		return array($text, $more);
	}
}
//转换到UTF-8编码
function iconv2utf($chs)
{
	global $encode;
	if ($encode != 'utf-8')
	{
		if (function_exists('mb_convert_encoding'))
		{
			$chs = mb_convert_encoding($chs, 'UTF-8', $encode);
		} elseif (function_exists('iconv')){
			$chs = iconv($encode, 'UTF-8', $chs);
		}
	}
	return $chs;
}
?>