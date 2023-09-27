<?php
/**
 * Configuration item
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Option {

    const EMLOG_VERSION = 'pro 2.1.15';
    const EMLOG_VERSION_TIMESTAMP = 1694531815;
    const UPLOADFILE_PATH = '../content/uploadfile/';
    const UPLOADFILE_FULL_PATH = EMLOG_ROOT . '/content/uploadfile/';

    static function get($option) {
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');
        if (empty($options_cache[$option])) {
            switch ($option) {
                case 'posts_name':
                    return '文章';
                default:
                    return '';
            }
        }

        switch ($option) {
            case 'active_plugins':
            case 'navibar':
            case 'widget_title':
            case 'custom_widget':
            case 'widgets1':
            case 'custom_topimgs':
                if (!empty($options_cache[$option])) {
                    return @unserialize($options_cache[$option]);
                }
                return [];
            case 'blogurl':
                if ($options_cache['detect_url'] == 'y') {
                    return realUrl();
                }
                return $options_cache['blogurl'];
            default:
                return $options_cache[$option];
        }
    }

    static function getRoutingTable() {
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
                'model'  => 'Comment_Controller',
                'method' => 'addComment',
                'reg_0'  => '|^.*/\?(action)=(addcom)([\?&].*)?$|',
            ],
            [
                'model'  => 'Plugin_Controller',
                'method' => 'loadPluginShow',
                'reg_0'  => '|^.*/\?(plugin)=([\w\-]+).*([\?&].*)?$|',
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
                'model'  => 'Log_Controller',
                'method' => 'display',
                'reg_0'  => '|^/?([\?&].*)?$|',
            ],
        ];
    }

    static function getAll() {
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');
        $options_cache['site_title'] = $options_cache['site_title'] ?: $options_cache['blogname'];
        $options_cache['site_description'] = $options_cache['site_description'] ?: $options_cache['bloginfo'];
        if (empty($options_cache['emkey'])) {
            $options_cache['site_title'] = '&#x672A;&#x6CE8;&#x518C;&#x7684;&#x7248;&#x672C; ' . $options_cache['site_title'];
        }
        return $options_cache;
    }

    static function getAttType() {
        return explode(',', self::get('att_type'));
    }

    static function getAttMaxSize() {
        return self::get('att_maxsize') * 1024;
    }

    static function getWidgetTitle() {
        return [
            'blogger'     => '个人资料',
            'calendar'    => '日历',
            'tag'         => '标签',
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

    static function getDefWidget() {
        return ['blogger', 'newcomm', 'link', 'search'];
    }

    static function getDefPlugin() {
        return ['tips/tips.php', 'tpl_options/tpl_options.php'];
    }

    /**
     * Update configuration options
     * @param $name
     * @param $value
     * @param $isSyntax is the update value is an expression
     */
    static function updateOption($name, $value, $isSyntax = false) {
        $DB = Database::getInstance();
        $value = $isSyntax ? $value : "'$value'";
        $sql = 'INSERT INTO ' . DB_PREFIX . "options (option_name, option_value) values ('$name', $value) ON DUPLICATE KEY UPDATE option_value=$value, option_name='$name'";
        $DB->query($sql);
    }
}
