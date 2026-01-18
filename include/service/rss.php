<?php

/**
 * Service: Rss
 *
 * @package EMLOG
 * 
 */

class Rss
{
    /**
     * Generate RSS
     */
    public function generate()
    {
        $Log_Model = new Log_Model();
        $User_Model = new User_Model();
        $num = Option::get('rss_output_num');
        $articles = $Log_Model->getList('', 'n', 1, 'blog', $num);

        $Parsedown = new Parsedown();
        $Parsedown->setBreaksEnabled(true);

        $items = '';
        foreach ($articles as $value) {
            $id = $value['gid'];
            $title = $this->cleanXmlContent($value['title']);

            $userInfo = $User_Model->getOneUser($value['author']);
            $nickname = isset($userInfo['nickname']) ? htmlspecialchars($this->cleanXmlContent($userInfo['nickname'])) : '';

            $content = $Parsedown->text($value['content']);
            if (!empty($value['password'])) {
                $content = '<p>[该文章已设置加密]</p>';
            } elseif (Option::get('rss_output_fulltext') == 'n') {
                if (!empty($value['excerpt'])) {
                    $content = $value['excerpt'];
                } else {
                    $content = extractHtmlData($content, 330);
                }
                $content .= ' <a href="' . Url::log($id) . '">阅读全文&gt;&gt;</a>';
            }
            $content = $this->cleanXmlContent($content);
            $content = str_replace(']]>', ']]&gt;', $content);

            $link = Url::log($id);
            $pubdate = date('r', $value['date']);

            doAction('rss_display');

            $items .= <<< END

<item>
    <title>{$title}</title>
    <link>$link</link>
    <description><![CDATA[{$content}]]></description>
    <pubDate>$pubdate</pubDate>
    <dc:creator>$nickname</dc:creator>
    <guid>$link</guid>
</item>
END;
        }

        $blogName = Option::get('blogname');
        $blogUrl = Option::get('blogurl');
        $blogInfo = Option::get('bloginfo');
        $blogLink = BLOG_URL;

        $rss = <<< END
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:atom="http://www.w3.org/2005/Atom"
>
<channel>
<title><![CDATA[{$blogName}]]></title> 
<atom:link href="{$blogUrl}rss.php" rel="self" type="application/rss+xml" />
<description><![CDATA[{$blogInfo}]]></description>
<link>{$blogLink}</link>
<language>zh-cn</language>
<generator>emlog</generator>
{$items}
</channel>
</rss>
END;
        echo $rss;
    }

    /**
     * 清理 XML 内容中的无效字符
     * @param string $string
     * @return string
     */
    private function cleanXmlContent($string)
    {
        $string = preg_replace('/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $string);
        $string = iconv('UTF-8', 'UTF-8//IGNORE', $string);
        return $string;
    }
}
