<?php
/**
 * 引用通告接收
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'init.php';

$logid = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
$sc = isset($_REQUEST['sc']) ? $_REQUEST['sc'] : '';
$encode = 'utf-8';
$charset = isset($_SERVER['HTTP_ACCEPT_CHARSET']) ? strtolower($_SERVER['HTTP_ACCEPT_CHARSET']) : '';
if ($charset && !strstr($charset, 'utf-8')){
	$encode = $charset;
}
$title     = isset($_REQUEST['title']) ? iconv2utf(html2text(addslashes(trim($_REQUEST['title'])))) : '';
$excerpt   = isset($_REQUEST['excerpt']) ? trimmed_title(iconv2utf(html2text(addslashes(trim($_REQUEST['excerpt'])))), 255) : '';
$url       = isset($_REQUEST['url']) ? addslashes(trim($_REQUEST['url'])) : '';
$blog_name = isset($_REQUEST['blog_name']) ? iconv2utf(html2text(addslashes(trim($_REQUEST['blog_name'])))) : '';
$ipaddr	   = getIp();

if (Option::get('istrackback') == 'y' && $logid && $title && $excerpt && $url && $blog_name){
	if($sc != substr(md5(gmdate('YndG')), 0, 6)){
		showXML('invalid trackback url');
	}

	$DB = MySql::getInstance();

	$blog = $DB->once_fetch_array('SELECT allow_tb FROM '.DB_PREFIX."blog WHERE gid='".$logid."'");
	if (empty($blog)){
		showXML('log not exist');
	}elseif ($blog['allow_tb'] == 'n'){
		showXML('trackback closed');
	}

	$point = 3;

	//5小时内同一ip、博客只能引用一次
	$interval = 3600 * 5;
	$utctimestamp = time();
	$query = $DB->query('SELECT tbid FROM '.DB_PREFIX."trackback WHERE ip='$ipaddr' AND date+$interval>=$utctimestamp");
	if ($DB->num_rows($query)){
		$point -= 1;
	}

	$query = $DB->query('SELECT tbid FROM '.DB_PREFIX."trackback WHERE REPLACE(LCASE(url),'www.','')='".str_replace('www.','',strtolower($url))."' AND date+$interval>=$utctimestamp");
	if ($DB->num_rows($query)){
		$point -= 1;
	}

	if ($point == 3){
		$query = 'INSERT INTO '.DB_PREFIX."trackback (gid, title, date, excerpt, url, blog_name,ip) VALUES($logid, '$title', '$utctimestamp', '$excerpt', '$url', '$blog_name','$ipaddr')";
		$DB->query($query);
		$DB->query('UPDATE '.DB_PREFIX."blog SET tbcount=tbcount+1 WHERE gid='".intval($logid)."'");
		$CACHE->updateCache('sta');
		showXML('success', 0);
	}else {
		showXML('refuse trackback');
	}
}else{
	showXML('param error');
}

function showXML($message, $error = 1){
	header('Content-type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<response>\n";
	echo "<error>$error</error>\n";
	echo "<message>$message</message>\n";
	echo "</response>\n";
	exit;
}
//HTML转换为纯文本
function html2text($content){
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
function trimmed_title($text, $limit=12){
	$val = csubstr($text, 0, $limit);
	return $val[1] ? $val[0]."..." : $val[0];
}
function csubstr($text, $start=0, $limit=12){
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
		if(func_num_args() >= 3){
			if (count($ar[0])>$limit){
				$more = TRUE;
				$text = join('', array_slice($ar[0],0,$limit))."...";
			}
			$more = TRUE;
			$text = join('', array_slice($ar[0],0,$limit));
		} else {
			$more = FALSE;
			$text =  join('', array_slice($ar[0],0));
		}
		return array($text, $more);
	}
}
//转换到UTF-8编码
function iconv2utf($chs){
	global $encode;
	if ($encode != 'utf-8'){
		if (function_exists('mb_convert_encoding')){
			$chs = mb_convert_encoding($chs, 'UTF-8', $encode);
		} elseif (function_exists('iconv')){
			$chs = iconv($encode, 'UTF-8', $chs);
		}
	}
	return $chs;
}
