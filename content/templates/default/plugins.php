<?php

/**
 * 模板的系统调用文件
 * 模板启用后，该文件会被系统自动加载。可用于实现类似插件的功能。
 */

defined('EMLOG_ROOT') || exit('access denied!');

// 为下载链接添加按钮样式
function add_download_style($logData, &$result)
{
    // 优化正则表达式以匹配多种下载链接格式
    $pattern = '/<a\s+([^>]*href="[^"]*(?:\?resource_alias=[^&"]*(?:&resource_filename=[^"]*)?|\.(?:zip|rar|7z|gz|bz2|tar|exe|dmg|pkg|deb|rpm))(?:[^"]*)?"[^>]*)>/i';
    $replacement = '<a $1 class="em-download-btn"><span class="iconfont icon-clouddownload"></span> ';
    $result['log_content'] = preg_replace($pattern, $replacement, $logData['log_content']);
}

addAction('article_content_echo', 'add_download_style');

// 定义下载按钮样式
function render_download_btn()
{
    echo <<<EOT
<style>
.em-download-btn {
    background-color: var(--buttonBgColor);
    color: var(--fontColor);
    border: 1px solid var(--buttonBorderColor);
    padding: 10px 20px;
    border-radius: var(--marRadius);
    cursor: pointer;
    font-size: 16px;
    text-decoration: none !important;
}
</style>

EOT;
}

addAction('index_head', 'render_download_btn');
