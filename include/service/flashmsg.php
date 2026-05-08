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
     * 确保 Session 已启动，供 Flash 消息读写使用。
     *
     * @return bool
     */
    private static function ensureSessionStarted()
    {
        if (function_exists('session_status')) {
            if (session_status() === PHP_SESSION_ACTIVE) {
                return true;
            }
        } elseif (session_id() !== '') {
            return true;
        }

        if (headers_sent()) {
            return false;
        }

        return session_start();
    }

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
        if (!self::ensureSessionStarted()) {
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
        if (!self::ensureSessionStarted()) {
            return array();
        }
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

    /**
     * 渲染用户管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderUserAlerts($sessionKey = 'user_flash_messages')
    {
        $alertMap = array(
            'active_unfb' => array('type' => 'success', 'text' => _lang('active_unforbid')),
            'active_update' => array('type' => 'success', 'text' => _lang('edit_success')),
            'active_add' => array('type' => 'success', 'text' => _lang('active_add_user')),
            'error_email' => array('type' => 'danger', 'text' => _lang('error_email_empty')),
            'error_exist_email' => array('type' => 'danger', 'text' => _lang('error_exist_email')),
            'error_pwd_len' => array('type' => 'danger', 'text' => _lang('password_min_length')),
            'error_pwd2' => array('type' => 'danger', 'text' => _lang('password_inconsistent')),
            'error_del_a' => array('type' => 'danger', 'text' => _lang('error_del_founder')),
            'error_del_b' => array('type' => 'danger', 'text' => _lang('error_edit_founder')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染用户编辑页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderUserEditAlerts($sessionKey = 'user_edit_flash_messages')
    {
        $alertMap = array(
            'error_nickname' => array('type' => 'danger', 'text' => _lang('nickname_required')),
            'error_email' => array('type' => 'danger', 'text' => _lang('email_username_empty')),
            'error_exist' => array('type' => 'danger', 'text' => _lang('username_exists')),
            'error_exist_email' => array('type' => 'danger', 'text' => _lang('error_exist_email')),
            'error_pwd_len' => array('type' => 'danger', 'text' => _lang('password_min_length')),
            'error_pwd2' => array('type' => 'danger', 'text' => _lang('password_inconsistent')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染微语管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderTwitterAlerts($sessionKey = 'twitter_flash_messages')
    {
        $alertMap = array(
            'active_t' => array('type' => 'success', 'text' => _lang('publish_success')),
            'active_set' => array('type' => 'success', 'text' => _lang('save_success')),
            'error_a' => array('type' => 'danger', 'text' => _lang('content_required')),
            'error_forbid' => array('type' => 'danger', 'text' => _lang('twitter_post_forbidden')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染标签管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderTagAlerts($sessionKey = 'tag_flash_messages')
    {
        $alertMap = array(
            'active_add' => array('type' => 'success', 'text' => _lang('add_tag_success')),
            'active_edit' => array('type' => 'success', 'text' => _lang('edit_tag_success')),
            'error_a' => array('type' => 'danger', 'text' => _lang('select_tag')),
            'error_exist' => array('type' => 'danger', 'text' => _lang('tag_exists')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染分类管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderSortAlerts($sessionKey = 'sort_flash_messages')
    {
        $alertMap = array(
            'active_save' => array('type' => 'success', 'text' => _lang('save_success')),
            'error_a' => array('type' => 'danger', 'text' => _lang('sort_name_required')),
            'error_c' => array('type' => 'danger', 'text' => _lang('alias_format_error')),
            'error_d' => array('type' => 'danger', 'text' => _lang('alias_exists_error')),
            'error_e' => array('type' => 'danger', 'text' => _lang('alias_reserved_error')),
            'error_f' => array('type' => 'danger', 'text' => _lang('sort_self_parent_error')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染导航管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderNavbarAlerts($sessionKey = 'navbar_flash_messages')
    {
        $alertMap = array(
            'active_edit' => array('type' => 'success', 'text' => _lang('edit_success')),
            'active_add' => array('type' => 'success', 'text' => _lang('add_success')),
            'error_a' => array('type' => 'danger', 'text' => _lang('navi_error_a')),
            'error_c' => array('type' => 'danger', 'text' => _lang('navi_error_c')),
            'error_d' => array('type' => 'danger', 'text' => _lang('navi_error_d')),
            'error_e' => array('type' => 'danger', 'text' => _lang('navi_error_e')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染媒体库页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderMediaAlerts($sessionKey = 'media_flash_messages')
    {
        $alertMap = array(
            'active_mov' => array('type' => 'success', 'text' => _lang('move_success')),
            'active_edit' => array('type' => 'success', 'text' => _lang('edit_success')),
            'active_add' => array('type' => 'success', 'text' => _lang('add_success')),
            'error_url' => array('type' => 'danger', 'text' => _lang('url_format_error')),
            'error_a' => array('type' => 'danger', 'text' => _lang('name_required')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染页面管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderPageAlerts($sessionKey = 'page_flash_messages')
    {
        $alertMap = array(
            'active_hide_n' => array('type' => 'success', 'text' => _lang('publish_success')),
            'active_hide_y' => array('type' => 'success', 'text' => _lang('page_draft_success')),
            'active_pubpage' => array('type' => 'success', 'text' => _lang('save_success')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染评论管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderCommentAlerts($sessionKey = 'comment_flash_messages')
    {
        $alertMap = array(
            'active_show' => array('type' => 'success', 'text' => _lang('comment_audit_success')),
            'active_hide' => array('type' => 'success', 'text' => _lang('hide_success')),
            'active_top' => array('type' => 'success', 'text' => _lang('top_success')),
            'active_untop' => array('type' => 'success', 'text' => _lang('top_cancel_success')),
            'active_edit' => array('type' => 'success', 'text' => _lang('edit_success')),
            'active_rep' => array('type' => 'success', 'text' => _lang('reply_success')),
            'error_a' => array('type' => 'danger', 'text' => _lang('select_operate_comment')),
            'error_b' => array('type' => 'danger', 'text' => _lang('select_operation')),
            'error_c' => array('type' => 'danger', 'text' => _lang('reply_empty_error')),
            'error_d' => array('type' => 'danger', 'text' => _lang('content_too_long')),
            'error_e' => array('type' => 'danger', 'text' => _lang('comment_empty_error')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染数据管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderDataAlerts($sessionKey = 'data_flash_messages')
    {
        $alertMap = array(
            'active_backup' => array('type' => 'success', 'text' => _lang('backup_success')),
            'active_import' => array('type' => 'success', 'text' => _lang('import_success')),
            'error_a' => array('type' => 'danger', 'text' => _lang('select_backup_to_delete')),
            'error_b' => array('type' => 'danger', 'text' => _lang('backup_filename_error')),
            'error_c' => array('type' => 'danger', 'text' => _lang('zip_not_support_import')),
            'error_d' => array('type' => 'danger', 'text' => _lang('upload_backup_error')),
            'error_e' => array('type' => 'danger', 'text' => _lang('invalid_backup_file')),
            'error_f' => array('type' => 'danger', 'text' => _lang('zip_not_support_export')),
            'active_mc' => array('type' => 'success', 'text' => _lang('cache_update_success')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染组件管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderWidgetsAlerts($sessionKey = 'widgets_flash_messages')
    {
        $alertMap = array(
            'activated' => array('type' => 'success', 'text' => _lang('save_success')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染授权页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderAuthAlerts($sessionKey = 'auth_flash_messages')
    {
        $alertMap = array(
            'error_b' => array('type' => 'danger', 'text' => _lang('reg_failed_msg')),
            'error_article' => array('type' => 'danger', 'text' => _lang('reg_failed_msg')),
            'error_store' => array('type' => 'danger', 'text' => _lang('reg_failed_msg')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染模板管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderTemplateAlerts($sessionKey = 'template_flash_messages')
    {
        $alertMap = array(
            'activated' => array('type' => 'success', 'text' => _lang('tpl_change_success')),
            'activate_install' => array('type' => 'success', 'text' => _lang('tpl_install_success')),
            'activate_upgrade' => array('type' => 'success', 'text' => _lang('tpl_update_success')),
            'error_f' => array('type' => 'danger', 'text' => _lang('tpl_delete_error_permission')),
            'error_a' => array('type' => 'danger', 'text' => _lang('tpl_only_zip_support')),
            'error_b' => array('type' => 'danger', 'text' => _lang('tpl_upload_dir_permission')),
            'error_d' => array('type' => 'danger', 'text' => _lang('tpl_select_zip')),
            'error_e' => array('type' => 'danger', 'text' => _lang('tpl_install_error_standard')),
            'error_g' => array('type' => 'danger', 'text' => _lang('upload_size_exceeded')),
            'error_c' => array('type' => 'danger', 'text' => _lang('php_zip_not_support')),
            'error_i' => array('type' => 'danger', 'text' => _lang('emlog_not_registered')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染插件管理页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderPluginAlerts($sessionKey = 'plugin_flash_messages')
    {
        $alertMap = array(
            'activate_install' => array('type' => 'success', 'text' => _lang('plugin_install_success')),
            'activate_upgrade' => array('type' => 'success', 'text' => _lang('plugin_update_success')),
            'active_error' => array('type' => 'danger', 'text' => _lang('plugin_enable_failed')),
            'error_a' => array('type' => 'danger', 'text' => _lang('plugin_delete_failed_permission')),
            'error_b' => array('type' => 'danger', 'text' => _lang('plugin_upload_failed_permission')),
            'error_c' => array('type' => 'danger', 'text' => _lang('php_zip_not_support')),
            'error_d' => array('type' => 'danger', 'text' => _lang('select_zip_plugin')),
            'error_e' => array('type' => 'danger', 'text' => _lang('plugin_install_failed_invalid')),
            'error_f' => array('type' => 'danger', 'text' => _lang('plugin_only_zip')),
            'error_g' => array('type' => 'danger', 'text' => _lang('upload_size_exceeded')),
            'error_i' => array('type' => 'danger', 'text' => _lang('emlog_not_registered')),
            'error_sys' => array('type' => 'danger', 'text' => _lang('system_plugin_warning')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染登录页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderSigninAlerts($sessionKey = 'account_signin_flash_messages')
    {
        $alertMap = array(
            'succ_reg' => array('type' => 'success', 'text' => _lang('register_success_login')),
            'succ_reset' => array('type' => 'success', 'text' => _lang('reset_success_login')),
            'err_ckcode' => array('type' => 'danger', 'text' => _lang('captcha_error')),
            'err_login' => array('type' => 'danger', 'text' => _lang('user_pass_error')),
            'err_forbid' => array('type' => 'danger', 'text' => _lang('account_forbidden')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染注册页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderSignupAlerts($sessionKey = 'account_signup_flash_messages')
    {
        $alertMap = array(
            'err_ckcode' => array('type' => 'danger', 'text' => _lang('captcha_error')),
            'err_mail_code' => array('type' => 'danger', 'text' => _lang('email_code_error')),
            'error_login' => array('type' => 'danger', 'text' => _lang('email_format_error')),
            'error_exist' => array('type' => 'danger', 'text' => _lang('email_exist_error')),
            'error_pwd_len' => array('type' => 'danger', 'text' => _lang('password_min_length')),
            'error_pwd2' => array('type' => 'danger', 'text' => _lang('password_inconsistent')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染找回密码第1步页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderResetAlerts($sessionKey = 'account_reset_flash_messages')
    {
        $alertMap = array(
            'error_mail' => array('type' => 'danger', 'text' => _lang('reg_email_error')),
            'error_sendmail' => array('type' => 'danger', 'text' => _lang('email_code_send_failed')),
            'err_ckcode' => array('type' => 'danger', 'text' => _lang('captcha_error')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染找回密码第2步页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderReset2Alerts($sessionKey = 'account_reset2_flash_messages')
    {
        $alertMap = array(
            'succ_mail' => array('type' => 'success', 'text' => _lang('email_code_sent')),
            'err_mail_code' => array('type' => 'danger', 'text' => _lang('email_code_error')),
            'error_pwd_len' => array('type' => 'danger', 'text' => _lang('password_min_length')),
            'error_pwd2' => array('type' => 'danger', 'text' => _lang('password_inconsistent')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染 API 设置页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderSettingApiAlerts($sessionKey = 'setting_api_flash_messages')
    {
        $alertMap = array(
            'ok_reset' => array('type' => 'success', 'text' => _lang('api_key_reset_success')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }

    /**
     * 渲染应用商店页的 Flash 提示 HTML。
     *
     * @param string $sessionKey Session 键名
     * @return string
     */
    public static function renderStoreAlerts($sessionKey = 'store_flash_messages')
    {
        $alertMap = array(
            'error' => array('type' => 'danger', 'text' => _lang('store_unavailable')),
        );
        return self::renderAlertsByMap($sessionKey, $alertMap);
    }
}
