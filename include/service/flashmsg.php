<?php

/**
 * Service: FlashMsg
 *
 * @package EMLOG
 *
 */
class FlashMsg
{
    /**
     * 构建带查询参数的 URL。
     *
     * @param string $path URL 路径
     * @param array $params 查询参数
     * @return string
     */
    public static function buildUrl($path, $params = array())
    {
        if (empty($params)) {
            return $path;
        }
        return $path . '?' . http_build_query($params);
    }

    /**
     * 写入一次性 Flash 消息。
     *
     * @param string $sessionKey Session 键名
     * @param string $messageKey 消息键名
     */
    public static function addFlashMessage($sessionKey, $messageKey)
    {
        if (empty($sessionKey) || empty($messageKey)) {
            return;
        }
        if (empty($_SESSION[$sessionKey]) || !is_array($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = array();
        }
        if (!in_array($messageKey, $_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey][] = $messageKey;
        }
    }

    /**
     * 读取并消费一次性 Flash 消息。
     *
     * @param string $sessionKey Session 键名
     * @return array
     */
    public static function consumeFlashMessages($sessionKey)
    {
        $messages = isset($_SESSION[$sessionKey]) && is_array($_SESSION[$sessionKey]) ? $_SESSION[$sessionKey] : array();
        unset($_SESSION[$sessionKey]);
        return $messages;
    }

    /**
     * 跳转到指定 URL，并可选写入 Flash 消息。
     *
     * @param string $path URL 路径
     * @param array $params 查询参数
     * @param string $sessionKey Session 键名
     * @param string $messageKey 消息键名
     */
    public static function redirectWithFlash($path, $params = array(), $sessionKey = '', $messageKey = '')
    {
        if (!empty($sessionKey) && !empty($messageKey)) {
            self::addFlashMessage($sessionKey, $messageKey);
        }
        emDirect(self::buildUrl($path, $params));
    }

    /**
     * 后台模块跳转并写入 Flash 消息。
     *
     * @param string $module 模块名（不含 .php）
     * @param string $messageKey 消息键名
     * @param array $params 查询参数
     * @param string $sessionKey Session 键名，留空时按模块名自动生成
     * @param string $anchor URL 锚点
     */
    public static function redirectAdmin($module, $messageKey = '', $params = array(), $sessionKey = '', $anchor = '')
    {
        $module = trim($module);
        if ($module === '') {
            return;
        }

        $path = './' . $module . '.php';
        $flashKey = $sessionKey === '' ? $module . '_flash_messages' : $sessionKey;
        if ($messageKey !== '') {
            self::addFlashMessage($flashKey, $messageKey);
        }

        $url = self::buildUrl($path, $params);
        if ($anchor !== '') {
            $url .= '#' . ltrim($anchor, '#');
        }
        emDirect($url);
    }

    /**
     * 账户相关页面跳转并写入 Flash 消息。
     *
     * @param string $pageAction 目标 action
     * @param string $messageKey 消息键名
     * @param array $extraParams 额外查询参数
     */
    public static function redirectAccount($pageAction, $messageKey = '', $extraParams = array())
    {
        $params = array_merge(array('action' => $pageAction), $extraParams);
        self::redirectWithFlash('./account.php', $params, 'account_' . $pageAction . '_flash_messages', $messageKey);
    }

    /**
     * 渲染指定场景的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @param array $alertMap 消息映射表，格式：key => ['type' => '', 'text' => '']
     * @return string
     */
    public static function renderAlertsByMap($sessionKey, $alertMap)
    {
        $messages = self::consumeFlashMessages($sessionKey);
        if (empty($messages) || empty($alertMap)) {
            return '';
        }

        $html = '';
        foreach ($messages as $messageKey) {
            if (!isset($alertMap[$messageKey])) {
                continue;
            }

            $alertType = isset($alertMap[$messageKey]['type']) ? $alertMap[$messageKey]['type'] : 'info';
            $alertText = isset($alertMap[$messageKey]['text']) ? $alertMap[$messageKey]['text'] : '';
            $html .= '<div class="alert alert-' . $alertType . '">' . $alertText . '</div>';
        }

        return $html;
    }

    /**
     * 渲染文章管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderArticleAlerts($sessionKey = 'article_flash_messages')
    {
        $alertMap = array(
            'active_up' => array('type' => 'success', 'text' => _lang('top_success')),
            'active_down' => array('type' => 'success', 'text' => _lang('top_cancel_success')),
            'error_a' => array('type' => 'danger', 'text' => _lang('select_article')),
            'error_b' => array('type' => 'danger', 'text' => _lang('select_operation')),
            'active_post' => array('type' => 'success', 'text' => _lang('publish_success')),
            'active_move' => array('type' => 'success', 'text' => _lang('move_success')),
            'active_change_author' => array('type' => 'success', 'text' => _lang('change_author_success')),
            'active_hide' => array('type' => 'success', 'text' => _lang('to_draft_success')),
            'active_savedraft' => array('type' => 'success', 'text' => _lang('draft_save_success')),
            'active_savelog' => array('type' => 'success', 'text' => _lang('save_success')),
            'active_ck' => array('type' => 'success', 'text' => _lang('audit_success')),
            'active_unck' => array('type' => 'success', 'text' => _lang('audit_uncheck_success')),
            'error_post_per_day' => array('type' => 'danger', 'text' => _lang('daily_limit')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染链接管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderLinkAlerts($sessionKey = 'link_flash_messages')
    {
        $alertMap = array(
            'active_save' => array('type' => 'success', 'text' => _lang('save_success')),
            'active_del' => array('type' => 'success', 'text' => _lang('link_delete_success')),
            'active_hide' => array('type' => 'success', 'text' => _lang('hide_success')),
            'active_show' => array('type' => 'success', 'text' => _lang('link_show_success')),
            'error_a' => array('type' => 'danger', 'text' => _lang('link_required')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }
}
