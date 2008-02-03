<?php
/**
 * 引用通告主程序
 * @copyright (c) 2008, Emlog All rights reserved.
 * @version emlog-2.5.0
 */

// 加载前台常用函数
require_once("./common.php");

// 加载编码转换函数
require_once ("./lib/C_encode.php");

$charset = strtolower($_REQUEST['charset']);
if (trim($charset)) {
	$charset = in_array($charset, array('gbk', 'big5', 'utf-8')) ? $charset : 'utf-8';
} else {
	$charset = 'utf-8';
}

$blogid = intval($_REQUEST['id']);
$title     = iconv2utf(html2text($_REQUEST['title']));
$excerpt   = trimmed_title(iconv2utf(html2text($_REQUEST['excerpt'])), 255);
$url       = addslashes($_REQUEST['url']);
$blog_name = iconv2utf(html2text($_REQUEST['blog_name']));

if (!empty($blogid) AND !empty($title) AND !empty($excerpt) AND !empty($url) AND !empty($blog_name)) {
	$blog= $DB->fetch_one_array("SELECT allow_tb FROM ".$db_prefix."blog WHERE gid='".$blogid."'");
	if (empty($blog)) {
		$error   = 1;
		$message = '记录不存在';
	}elseif ($blog['allow_tb']=='n') {
		$error   = 1;
		$message = '本文因为某种原因此时不允许引用';
	}else {
		//插入数据
		$query = "INSERT INTO ".$db_prefix."trackback (gid, title, date, excerpt, url, blog_name) VALUES('".$blogid."', '".$title."', '".$localdate."', '".$excerpt."', '".$url."', '".$blog_name."')";
		$DB->query($query);
		//更新文章Trackback数量
		$sql = "SELECT tbid FROM ".$db_prefix."trackback WHERE gid='".intval($blogid)."'";
		$tatol = $DB->num_rows($DB->query($sql));
		$DB->query("UPDATE ".$db_prefix."blog SET tbcount=tbcount+1 WHERE gid='".intval($blogid)."'");
		$error = 0;
		$message = 'Trackback 成功接收';
	}
} else {
	$error = 1;
	$message = '缺少必要参数';
}

header('Content-type: text/xml');	
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<response>\n";
echo "\t<error>".$error."</error>\n";
echo "\t<message>".$message."</message>\n";
echo "</response>\n";

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
function iconv2utf($chs) {
	global $charset;
	if ($charset !== 'utf-8') {
		if (function_exists('mb_convert_encoding')) {
			$chs = mb_convert_encoding($chs, "UTF-8", $charset);
		} elseif (function_exists("iconv")) {
			$chs = iconv($charset, "UTF-8", $chs);
		} else {
			$cov = new Chinese($charset, 'UTF-8');
			$chs = $cov->Convert($chs);
		}
	}
	return $chs;
}
?>