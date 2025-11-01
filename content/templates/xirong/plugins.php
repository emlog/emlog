<?php
/**
 * 息壤信息咨询服务主题 - 插件系统
 * 模板启用后自动加载，可用于扩展功能
 */

defined('EMLOG_ROOT') || exit('access denied!');

/**
 * 在文章内容输出前添加分享按钮
 */
function xr_add_share_buttons($logData, &$result)
{
    // 仅在文章详情页添加分享功能
    if (!isset($result['log_content'])) {
        return;
    }

    $shareButtons = '
    <div class="xr-share-buttons" style="margin: 2rem 0; padding: 1.5rem; background: var(--color-surface); border-radius: var(--radius-lg); text-align: center;">
        <p style="margin-bottom: 1rem; color: var(--color-text-secondary); font-size: 0.875rem;">分享这篇文章</p>
        <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
            <button onclick="window.open(\'https://twitter.com/intent/tweet?url=\' + encodeURIComponent(location.href), \'_blank\')"
                    class="xr-btn xr-btn-outline" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                Twitter
            </button>
            <button onclick="window.open(\'https://www.facebook.com/sharer/sharer.php?u=\' + encodeURIComponent(location.href), \'_blank\')"
                    class="xr-btn xr-btn-outline" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                Facebook
            </button>
            <button onclick="navigator.clipboard.writeText(location.href).then(() => alert(\'链接已复制到剪贴板！\'))"
                    class="xr-btn xr-btn-outline" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                复制链接
            </button>
        </div>
    </div>';

    // 在文章内容后添加分享按钮
    $result['log_content'] .= $shareButtons;
}

// 注册钩子（可选，默认关闭）
// addAction('article_content_echo', 'xr_add_share_buttons');

/**
 * 为外部链接添加安全属性
 */
function xr_secure_external_links($logData, &$result)
{
    if (!isset($result['log_content'])) {
        return;
    }

    // 为外部链接添加 rel="noopener noreferrer"
    $pattern = '/<a\s+([^>]*href=["\']https?:\/\/(?!' . preg_quote($_SERVER['HTTP_HOST'], '/') . ')[^"\']*["\'][^>]*)>/i';
    $replacement = '<a $1 rel="noopener noreferrer" target="_blank">';

    $result['log_content'] = preg_replace($pattern, $replacement, $result['log_content']);
}

// 注册钩子（默认启用）
addAction('article_content_echo', 'xr_secure_external_links');

/**
 * 添加阅读时间估算
 */
function xr_add_reading_time($logData, &$result)
{
    if (!isset($result['log_content'])) {
        return;
    }

    $content = strip_tags($result['log_content']);
    $wordCount = mb_strlen($content, 'UTF-8');
    $readingTime = ceil($wordCount / 300); // 假设每分钟阅读300字

    // 可以在这里将阅读时间添加到文章元数据中
    // 实际使用需要在模板中调用
}

// 可以根据需要添加更多自定义功能
