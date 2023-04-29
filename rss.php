<?php
/**
 * RSS
 * @package EMLOG
 * @link https://www.emlog.net
 */

require_once './init.php';

header('Content-type: application/xml');
$Log_Model = new Log_Model();
$articles = $Log_Model->getLogsForRss(Option::get('rss_output_num'));

echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:atom="http://www.w3.org/2005/Atom"
>
<channel>
<title><![CDATA[' . Option::get('blogname') . ']]></title> 
<atom:link href="'.Option::get('blogurl').'rss.php" rel="self" type="application/rss+xml" />
<description><![CDATA[' . Option::get('bloginfo') . ']]></description>
<link>' . BLOG_URL . '</link>
<language>zh-cn</language>
<generator>www.emlog.net</generator>';
if (!empty($articles)) {
    foreach ($articles as $value) {
        $link = Url::log($value['id']);
        $abstract = str_replace('[break]', '', $value['content']);
        $pubdate = date('r', $value['date']);
        $author = $value['nickname'];
        doAction('rss_display');
        echo <<< END

<item>
    <title>{$value['title']}</title>
    <link>$link</link>
    <description><![CDATA[{$abstract}]]></description>
    <pubDate>$pubdate</pubDate>
    <dc:creator>$author</dc:creator>
    <guid>$link</guid>
</item>
END;
    }
}
echo <<< END
</channel>
</rss>
END;
