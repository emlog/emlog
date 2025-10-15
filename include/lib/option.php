<?php

/**
 * Configuration item
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Option
{
    const EMLOG_VERSION = 'pro 2.5.23';
    const EMLOG_VERSION_TIMESTAMP = 1760538567;
    const UPLOADFILE_PATH = '../content/uploadfile/';
    const UPLOADFILE_FULL_PATH = EMLOG_ROOT . '/content/uploadfile/';

    static function get($option)
    {
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');

        switch ($option) {
            case 'active_plugins':
            case 'widget_title':
            case 'custom_widget':
            case 'widgets1':
                if (!empty($options_cache[$option])) {
                    return @unserialize($options_cache[$option]);
                }
                return [];
            case 'blogurl':
                if ($options_cache['detect_url'] == 'y') {
                    return realUrl();
                }
                return $options_cache['blogurl'];
            case 'posts_name':
                if (empty($options_cache['posts_name'])) {
                    return '文章';
                }
            default:
                return isset($options_cache[$option]) ? $options_cache[$option] : '';
        }
    }

    /** 
     * 获取路由表
     * reg_0、reg_1、reg_2、reg_3 分别对应SEO设置中4种文章链接模式
     */
    static function getRoutingTable()
    {
        return [
            [
                'model'  => 'calendar',
                'method' => 'generate',
                'reg_0'  => '|^.*/\?action=cal|',
            ],
            [
                'model'  => 'Log_Controller',
                'method' => 'displayContent',
                'reg_0'  => '|^.*/\?(post)=(\d+)(&(comment-page)=(\d+))?([\?&].*)?$|',
                'reg_1'  => '|^.*/(post)-(\d+)\.html(/(comment-page)-(\d+))?/?([\?&].*)?$|',
                'reg_2'  => '|^.*/(post)/(\d+)(/(comment-page)-(\d+))?/?$|',
                'reg_3'  => '|^/?!/posts([^\./\?=]+)(\.html)?(/(comment-page)-(\d+))?/?([\?&].*)?$|',
            ],
            [
                'model'  => 'Record_Controller',
                'method' => 'display',
                'reg_0'  => '|^.*/\?(record)=(\d{6,8})(&(page)=(\d+))?([\?&].*)?$|',
                'reg'    => '|^.*/(record)/(\d{6,8})/?((page)/(\d+))?/?([\?&].*)?$|',
            ],
            [
                'model'  => 'Sort_Controller',
                'method' => 'display',
                'reg_0'  => '|^.*/\?(sort)=(\d+)(&(page)=(\d+))?([\?&].*)?$|',
                'reg'    => '|^.*/(sort)/([^\./\?=]+)/?((page)/(\d+))?/?([\?&].*)?$|',
            ],
            [
                'model'  => 'Tag_Controller',
                'method' => 'display',
                'reg_0'  => '|^.*/\?(tag)=([^&]+)(&(page)=(\d+))?([\?&].*)?$|',
                'reg'    => '|^.*/(tag)/([^/?]+)/?((page)/(\d+))?/?([\?&].*)?$|',
            ],
            [
                'model'  => 'Author_Controller',
                'method' => 'display',
                'reg_0'  => '|^.*/\?(author)=(\d+)(&(page)=(\d+))?([\?&].*)?$|',
                'reg'    => '|^.*/(author)/(\d+)/?((page)/(\d+))?/?([\?&].*)?$|',
            ],
            [
                'model'  => 'Log_Controller',
                'method' => 'display',
                'reg_0'  => '|^.*/\?(page)=(\d+)([\?&].*)?$|',
                'reg'    => '|^.*/(page)/(\d+)/?([\?&].*)?$|',
            ],
            [
                'model'  => 'Search_Controller',
                'method' => 'display',
                'reg_0'  => '|^.*/\?(keyword)=([^/&]+)(&(page)=(\d+))?([\?&].*)?$|',
            ],
            [
                'model'  => 'Log_Controller',
                'method' => 'index',
                'reg_0'  => '|^.*/\?(action)=([a-z]+)([\?&].*)?$|',
            ],
            [
                'model'  => 'Plugin_Controller',
                'method' => 'loadPluginShow',
                'reg_0'  => '|^.*/\?(plugin)=([\w\-]+).*([\?&].*)?$|',
            ],
            [
                'model'  => 'User_Controller',
                'method' => 'index',
                'reg_0'  => '|\/(user)(?:\/([\w\-]+))?|',
            ],
            [
                'model'  => 'User_Controller',
                'method' => 'index',
                'reg_0'  => '|^.*/\?(uc)=(\w+)([\?&].*)?$|',
            ],
            [
                'model'  => 'Plugin_Controller',
                'method' => 'loadPluginShow',
                'reg_0'  => '|\/(plugin)/([\w\-]+)|',
            ],
            [
                'model'  => 'Log_Controller',
                'method' => 'display',
                'reg_0'  => '|\/posts(\?.*)?|',
            ],
            [
                'model'  => 'Log_Controller',
                'method' => 'displayContent',
                'reg_0'  => '|^.*?/([^/\.=\?]+)(\.html)?(/(comment-page)-(\d+))?/?([\?&].*)?$|',
            ],
            [
                'model'  => 'Api_Controller',
                'method' => 'starter',
                'reg_0'  => '|^.*/\?(rest-api)=(\w+)([\?&].*)?$|',
            ],
            [
                'model'  => 'Download_Controller',
                'method' => 'index',
                'reg_0'  => '|^.*/\?(resource_alias)=(\w+)(&(resource_filename)=([^&]+))?.*$|',
            ],
            [
                'model'  => 'Log_Controller',
                'method' => 'display',
                'reg_0'  => '|^/?([\?&].*)?$|',
            ],
        ];
    }

    static function getAll()
    {
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');
        $options_cache['site_title'] = $options_cache['site_title'] ?: $options_cache['blogname'];
        $options_cache['site_description'] = $options_cache['site_description'] ?: $options_cache['bloginfo'];
        if (empty($options_cache['emkey'])) {
            $options_cache['site_title'] = '&#x672A;&#x6B63;&#x7248;&#x6CE8;&#x518C;&#x7684;&#x7248;&#x672C; ' . $options_cache['site_title'];
        }
        return $options_cache;
    }

    static function getAttType()
    {
        return explode(',', self::get('att_type'));
    }

    static function getAttMaxSize()
    {
        return self::get('att_maxsize') * 1024;
    }

    static function getAdminAttType()
    {
        if (defined('UPLOAD_ATT_TYPE')) {
            return explode(',', UPLOAD_ATT_TYPE);
        } else {
            return [
                'rar',
                'zip',
                '7z',
                'gz',
                'gif',
                'jpg',
                'jpeg',
                'png',
                'webp',
                'avif',
                'txt',
                'pdf',
                'docx',
                'doc',
                'xls',
                'xlsx',
                'key',
                'ppt',
                'pptx',
                'mp3',
                'mp4',
                'mkv',
                'mov',
                'webm',
                'avi',
                'exe',
            ];
        }
    }

    static function getAdminAttMaxSize()
    {
        return (defined('UPLOAD_MAX_SIZE') ? UPLOAD_MAX_SIZE : 2097152) * 1024;
    }

    static function getWidgetTitle()
    {
        return [
            'blogger'     => '个人资料',
            'calendar'    => '日历',
            'tag'         => '标签',
            'twitter'     => '微语',
            'sort'        => '分类',
            'archive'     => '存档',
            'newcomm'     => '最新评论',
            'newlog'      => '最新文章',
            'hotlog'      => '热门文章',
            'link'        => '链接',
            'search'      => '搜索',
            'custom_text' => '自定义组件'
        ];
    }

    static function getDefWidget()
    {
        return ['blogger', 'newcomm', 'link', 'search'];
    }

    static function getDefPlugin()
    {
        return ['tips/tips.php', 'tpl_options/tpl_options.php'];
    }

    /**
     * Update configuration options
     * @param $name
     * @param $value
     * @param $isSyntax is the update value is an expression
     */
    static function updateOption($name, $value, $isSyntax = false)
    {
        $DB = Database::getInstance();
        $value = $isSyntax ? $value : "'$value'";
        $sql = 'INSERT INTO ' . DB_PREFIX . "options (option_name, option_value) values ('$name', $value) ON DUPLICATE KEY UPDATE option_value=$value, option_name='$name'";
        $DB->query($sql);
    }
}
