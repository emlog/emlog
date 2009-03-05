<?php
/**
 * RSS输出主程序
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

error_reporting(E_ALL);

require_once('./config.php');
require_once(EMLOG_ROOT.'/lib/F_base.php');
require_once(EMLOG_ROOT.'/lib/C_mysql.php');
require_once(EMLOG_ROOT.'/lib/C_cache.php');

//初始化数据库类
$DB = new MySql(DB_HOST, DB_USER, DB_PASSWD,DB_NAME);
//cache
$options_cache = mkcache::readCache('options');
$user_cache = mkcache::readCache('blogger');

$sort = isset($_GET['sort']) ? intval($_GET['sort']) : '';

$URL = GetURL();
$site =  $options_cache;
$blog = GetBlog($sort);
$blognum = GetBlogNum();
$author = $user_cache['name'];

header("Content-type:application/xml");

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title><![CDATA[{$site['blogname']}]]></title> 
<description><![CDATA[{$site['bloginfo']}]]></description>
<link>http://$URL</link>
<language>zh-cn</language>
<generator>www.emlog.net</generator>

END;
foreach($blog as $value)
{
	$link = "http://".$URL."/?action=showlog&amp;gid=".$value['id'];
	$abstract = str_replace('[break]','',$value['content']);
	$pubdate =  date('r',$value['date']);
	echo <<< END

<item>
	<title>{$value['title']}</title>
	<link>$link</link>
	<description><![CDATA[{$abstract}]]></description>
	<pubDate>$pubdate</pubDate>
	<author>$author</author>
	<guid>$link</guid>

</item>
END;
}
echo <<< END
</channel>
</rss>
END;

/**
 * 获取url地址
 *
 * @return unknown
 */
function GetURL()
{
	$path = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$path = str_replace("/rss.php","",$path);
	Return $path;
}

/**
 * 获取日志信息
 *
 * @return array
 */
function GetBlog($sort = null)
{
	global $DB,$URL;
	$subsql = $sort ? " and sortid=$sort" : '';
	$sql = "SELECT * FROM ".DB_PREFIX."blog  WHERE hide='n' $subsql ORDER BY gid DESC limit 0,20";
	$result = $DB->query($sql);
	$blog = array();
	while ($re = $DB->fetch_array($result))
	{
		$re['id'] 		= $re['gid'];
		$re['title']    = htmlspecialchars($re['title']);
		$re['date']		= $re['date'];
		$re['content']	= $re['content'];
		if(!empty($re['password']))
		{
			$re['excerpt'] = '<p>[该日志已设置加密]</p>';
		}else{
			if(!empty($re['excerpt']))
			{
				$re['excerpt'] .= '<p><a href="http://'.$URL.'/?action=showlog&gid='.$re['id'].'">阅读全文&gt;&gt;</a></p>';
			}
		}
		$re['content'] = empty($re['excerpt']) ? $re['content'] : $re['excerpt'];

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