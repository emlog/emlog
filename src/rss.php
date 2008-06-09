<?php
/**
 * RSS输出主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.5
 */

error_reporting(7);
require_once("./config.php");
require_once("./lib/C_mysql.php");
require_once('./cache/config');
require_once('./cache/blogger');

//初始化数据库类
$DB = new MySql($host, $user, $pass,$db);
unset($host, $user, $pass,$db);

require_once("./lib/F_rss.php");

header("Content-type:application/xml");

print <<< END
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title><![CDATA[{$site[blogname]}]]></title> 
<description><![CDATA[$site[bloginfo]]]></description>
<link>http://$URL</link>
<language>zh-cn</language>
<generator>www.emlog.net</generator>

END;
foreach($blog as $value)
{
$link = "http://".$URL."/?action=showlog&amp;gid=".$value['id'];
$abstract = str_replace('[break]','',$value['content']);
$pubdate =  date('r',$value['date']);
print <<< END

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
print <<< END
</channel>
</rss>
END;

?>