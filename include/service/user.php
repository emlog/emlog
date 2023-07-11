<?php
/**
 * Service: User
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class User {

    const ROLE_ADMIN = 'admin';     // 管理员、创始人
    const ROLE_WRITER = 'writer';   // 注册用户
    const ROLE_VISITOR = 'visitor'; // 游客
    const ROLE_EDITOR = 'editor';   // 内容编辑

    static function isAdmin($role = ROLE) {
        return $role == self::ROLE_ADMIN;
    }

    static function isVistor($role = ROLE) {
        return $role == self::ROLE_VISITOR;
    }

    static function isEditor($role = ROLE) {
        return $role == self::ROLE_EDITOR;
    }

    static function isWiter($role = ROLE) {
        return $role == self::ROLE_WRITER;
    }

    static function haveEditPermission($role = ROLE) {
        if (self::isAdmin($role)) {
            return true;
        }
        if (self::isEditor($role)) {
            return true;
        }
    }

    static function getRoleName($role, $uid = 0) {
        $role_name = '';
        switch ($role) {
            case self::ROLE_ADMIN:
                $role_name = $uid == 1 ? '创始人' : '管理员';
                break;
            case self::ROLE_EDITOR:
                $role_name = '内容编辑';
                break;
            case self::ROLE_WRITER:
                $role_name = '注册用户';
                break;
            case self::ROLE_VISITOR:
                $role_name = '游客';
                break;
        }
        return $role_name;
    }

    static function checkLoginCode($login_code) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $session_code = isset($_SESSION['code']) ? $_SESSION['code'] : '';
        if ((!$login_code || $login_code !== $session_code) && Option::get('login_code') === 'y') {
            unset($_SESSION['code']);
            return false;
        }
        return true;
    }

    static function checkMailCode($mail_code) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $session_code = isset($_SESSION['mail_code']) ? $_SESSION['mail_code'] : '';
        if (!$mail_code || $mail_code !== $session_code) {
            unset($_SESSION['code']);
            return false;
        }
        return true;
    }

    static function checkRolePermission() {
        $request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
        if (ROLE === self::ROLE_WRITER && !in_array($request_uri, ['article', 'twitter', 'media', 'blogger', 'comment', 'index', 'article_save', 'plugin_user'])) {
            emMsg('你所在的用户组无法使用该功能，请联系管理员', './');
        }
        if (ROLE === self::ROLE_EDITOR && !in_array($request_uri, ['article', 'twitter', 'media', 'blogger', 'comment', 'index', 'article_save', 'plugin_user'])) {
            emMsg('你所在的用户组无法使用该功能，请联系管理员', './');
        }
    }

}

