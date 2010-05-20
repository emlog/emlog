<?php
/**
 * RSS输出
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.0
 * $Id$
 */

require_once 'common.php';

header('Content-type: application/xml');

$sort = isset($_GET['sort']) ? intval($_GET['sort']) : '';

$URL = BLOG_URL;
$blog = GetBlog($sort);

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title><![CDATA[{$blogname}]]></title> 
<description><![CDATA[{$bloginfo}]]></description>
<link>http://</link>
<language>zh-cn</language>
<generator>www.emlog.net</generator>

END;
foreach($blog as $value)
{
	$link = "http://".$URL."/?post=".$value['id'];
	$abstract = str_replace('[break]','',$value['content']);
	$pubdate =  gmdate('r',$value['date']);
	$author = $user_cache[$value['author']]['name'];
	doAction('rss_display');
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
 * 获取日志信息
 *
 * @return array
 */
function GetBlog($sort = null) {
	global $DB;
	$subsql = $sort ? "and sortid=$sort" : '';
	$sql = "SELECT * FROM ".DB_PREFIX."blog  WHERE hide='n' and type='blog' $subsql ORDER BY date DESC limit 0," . RSS_OUTPUT_NUM;
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
				$re['excerpt'] .= '<p><a href="http://'.BLOG_URL.'/?post='.$re['id'].'">阅读全文&gt;&gt;</a></p>';
			}
		}
		$re['content'] = empty($re['excerpt']) ? $re['content'] : $re['excerpt'];

		$blog[] = $re;
	}
	return $blog;
}
