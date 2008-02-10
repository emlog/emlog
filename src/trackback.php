<?php
/**
 * 引用通告主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

// 加载前台常用函数
require_once("./common.php");

$blogid = intval($_GET['id']);
$charset = strtolower($_GET['charset']);
$encode = in_array($charset, array('gbk', 'utf-8')) ? $charset : 'utf-8';

$title     = iconv2utf(html2text($_POST['title']));
$excerpt   = trimmed_title(iconv2utf(html2text($_POST['excerpt'])), 255);
$url       = addslashes($_POST['url']);
$blog_name = iconv2utf(html2text($_POST['blog_name']));

if ($istrackback=='y' && $blogid && $title && $excerpt && $url && $blog_name)
{
	$blog = $DB->fetch_one_array("SELECT allow_tb FROM ".$db_prefix."blog WHERE gid='".$blogid."'");
	if (empty($blog)) {
		showXML('记录不存在');
	}elseif ($blog['allow_tb']=='n') {
		showXML('该文章不允许引用');
	}else {
		//插入数据
		$query = "INSERT INTO ".$db_prefix."trackback (gid, title, date, excerpt, url, blog_name) VALUES('".$blogid."', '".$title."', '".$localdate."', '".$excerpt."', '".$url."', '".$blog_name."')";
		$DB->query($query);
		//更新文章Trackback数量
		$sql = "SELECT tbid FROM ".$db_prefix."trackback WHERE gid='".intval($blogid)."'";
		$tatol = $DB->num_rows($DB->query($sql));
		$DB->query("UPDATE ".$db_prefix."blog SET tbcount=tbcount+1 WHERE gid='".intval($blogid)."'");
		showXML('Trackback 成功接收',0);
	}
} else {
	showXML('Trackback 引用被拒绝');
}

//发送消息页面
function showXML($message, $error = 1) {
	header('Content-type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<response>\n";
	echo "\t<error>".$error."</error>\n";
	echo "\t<message>".$message."</message>\n";
	echo "</response>\n";
	exit;
}

// HTML转换为纯文本
function html2text($content) {
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
function trimmed_title($text, $limit=12) {
	$val = csubstr($text, 0, $limit);
	return $val[1] ? $val[0]."..." : $val[0];
}
function csubstr($text, $start=0, $limit=12) {
	if (function_exists('mb_substr')) {
		$more = (mb_strlen($text) > $limit) ? TRUE : FALSE;
		$text = mb_substr($text, 0, $limit, 'UTF-8');
		return array($text, $more);
	} elseif (function_exists('iconv_substr')) {
		$more = (iconv_strlen($text) > $limit) ? TRUE : FALSE;
		$text = iconv_substr($text, 0, $limit, 'UTF-8');
		return array($text, $more);
	} else {
		preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);   
		if(func_num_args() >= 3) {   
			if (count($ar[0])>$limit) {
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
function iconv2utf($chs) {
	global $encode;
	if ($encode != 'utf-8') {
		if (function_exists('mb_convert_encoding')) {
			$chs = mb_convert_encoding($chs, 'UTF-8', $encode);
		} elseif (function_exists('iconv')) {
			$chs = iconv($encode, 'UTF-8', $chs);
		}
	}
	return $chs;
}
?>