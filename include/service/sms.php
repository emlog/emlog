<?php

/**
 * Service: Sms
 *
 * @package EMLOG
 */

defined('EMLOG_ROOT') || exit('access denied!');

class Sms
{
    /**
     * 检查当前系统是否已安装并启用短信发送插件（挂载了 send_sms 钩子）
     *
     * @return bool
     */
    public static function isSmsReady()
    {
        return hasAction('send_sms');
    }

    /**
     * 发送登录短信验证码
     *
     * @param string $phone 手机号码
     * @return array array('success' => bool, 'message' => string)
     */
    public static function sendLoginSmsCode($phone)
    {
        if (!self::isSmsReady()) {
            return [
                'success' => false,
                'message' => _lang('sms_plugin_not_found'),
            ];
        }

        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        $randCode = getRandStr(6, false, true);
        $_SESSION['login_phone_code'] = $randCode;
        $_SESSION['login_phone'] = $phone;
        $_SESSION['login_phone_time'] = time();

        $siteTitle = '';
        if (class_exists('Option')) {
            $siteTitle = Option::get('site_title');
            if (empty($siteTitle)) {
                $siteTitle = Option::get('blogname');
            }
        }
        if (empty($siteTitle)) {
            $siteTitle = 'emlog';
        }

        $content = sprintf(_lang('sms_login_content'), $siteTitle, $randCode);
        $smsData = [
            'phone'         => $phone,
            'code'          => $randCode,
            'content'       => $content,
            'template_type' => 'login',
            'params'        => [
                'code' => $randCode,
            ],
        ];

        $ret = null;
        // 执行短信发送预留单次接管式挂载点
        doOnceAction('send_sms', $smsData, $ret);

        $isSuccess = false;
        $errorMsg = _lang('sms_send_failed');

        if ($ret === true) {
            $isSuccess = true;
        } elseif (is_array($ret)) {
            if (!empty($ret['success']) || (isset($ret['status']) && $ret['status'] === 'success')) {
                $isSuccess = true;
            } elseif (!empty($ret['message'])) {
                $errorMsg = $ret['message'];
            } elseif (!empty($ret['msg'])) {
                $errorMsg = $ret['msg'];
            }
        }

        if ($isSuccess) {
            return [
                'success' => true,
                'message' => _lang('phone_code_sent'),
            ];
        }

        // 发送失败清理 session
        unset($_SESSION['login_phone_code'], $_SESSION['login_phone'], $_SESSION['login_phone_time']);

        return [
            'success' => false,
            'message' => $errorMsg,
        ];
    }

    /**
     * 通用短信发送接口（预留扩展）
     *
     * @param string $phone 手机号码
     * @param string $content 短信内容
     * @param string $template_type 短信模板类型
     * @param array $params 短信模板变量
     * @return array array('success' => bool, 'message' => string)
     */
    public static function sendSms($phone, $content, $template_type = 'common', $params = [])
    {
        if (!self::isSmsReady()) {
            return [
                'success' => false,
                'message' => _lang('sms_plugin_not_found'),
            ];
        }

        $smsData = [
            'phone'         => $phone,
            'content'       => $content,
            'template_type' => $template_type,
            'params'        => is_array($params) ? $params : [],
        ];

        $ret = null;
        doOnceAction('send_sms', $smsData, $ret);

        $isSuccess = false;
        $errorMsg = _lang('sms_send_failed');

        if ($ret === true) {
            $isSuccess = true;
        } elseif (is_array($ret)) {
            if (!empty($ret['success']) || (isset($ret['status']) && $ret['status'] === 'success')) {
                $isSuccess = true;
            } elseif (!empty($ret['message'])) {
                $errorMsg = $ret['message'];
            } elseif (!empty($ret['msg'])) {
                $errorMsg = $ret['msg'];
            }
        }

        if ($isSuccess) {
            return [
                'success' => true,
                'message' => '',
            ];
        }

        return [
            'success' => false,
            'message' => $errorMsg,
        ];
    }
}
