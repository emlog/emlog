<?php

/**
 * Login authentication
 * @package EMLOG
 * @link https://www.emlog.net
 */

class LoginAuth
{

    const LOGIN_ERROR_USER = -1;
    const LOGIN_ERROR_PASSWD = -2;
    const LOGIN_ERROR_FORBID = -3;

    public static function isLogin()
    {
        global $userData;

        if (isset($_COOKIE[AUTH_COOKIE_NAME])) {
            $auth_cookie = $_COOKIE[AUTH_COOKIE_NAME];
        } elseif (isset($_POST[AUTH_COOKIE_NAME])) {
            $auth_cookie = $_POST[AUTH_COOKIE_NAME];
        } else {
            return false;
        }

        if (($userData = self::validateAuthCookie($auth_cookie)) === false) {
            return false;
        }

        return true;
    }

    public static function checkLogin($error_code = NULL)
    {
        if (self::isLogin() === true) {
            return;
        }
        if ($error_code) {
            emDirect(BLOG_URL . "admin/account.php?action=signin&code=$error_code");
        } else {
            emDirect(BLOG_URL . "admin/account.php?action=signin");
        }
    }

    public static function checkLogged()
    {
        if (self::isLogin() === false) {
            return;
        }
        emDirect("./");
    }

    public static function checkUser($username, $password)
    {
        if (empty($username) || empty($password)) {
            return self::LOGIN_ERROR_USER;
        }
        $userData = self::getUserDataByLogin($username);
        if (false === $userData) {
            return self::LOGIN_ERROR_USER;
        }
        $hash = $userData['password'];
        $state = $userData['state'];
        if ($state === User::USER_STATE_FORBID) {
            return self::LOGIN_ERROR_FORBID;
        }
        if (true === self::checkPassword($password, $hash)) {
            return $userData['uid'];
        }
        return self::LOGIN_ERROR_PASSWD;
    }

    public static function getUserDataByLogin($account)
    {
        $User_Model = new User_Model();
        return $User_Model->getUserDataByLogin($account);
    }

    public static function checkPassword($password, $hash)
    {
        global $em_hasher;
        if (empty($em_hasher)) {
            $em_hasher = new PasswordHash(8, true);
        }
        return $em_hasher->CheckPassword($password, $hash);
    }

    public static function setAuthCookie($user_login, $persist = false)
    {
        if ($persist) {
            $expiration = time() + 3600 * 24 * 30 * 12;
        } else {
            $expiration = 0;
        }
        $auth_cookie_name = AUTH_COOKIE_NAME;
        $auth_cookie = self::generateAuthCookie($user_login, $expiration);
        setcookie($auth_cookie_name, $auth_cookie, $expiration, '/', '', false, true);
    }

    private static function generateAuthCookie($user_login, $expiration)
    {
        $key = self::emHash($user_login . '|' . $expiration);
        $hash = hash_hmac('md5', $user_login . '|' . $expiration, $key);

        return $user_login . '|' . $expiration . '|' . $hash;
    }

    private static function emHash($data)
    {
        return hash_hmac('md5', $data, AUTH_KEY);
    }

    public static function validateAuthCookie($cookie = '')
    {
        if (empty($cookie)) {
            return false;
        }

        $cookie_elements = explode('|', $cookie);
        if (count($cookie_elements) !== 3) {
            return false;
        }

        list($username, $expiration, $hmac) = $cookie_elements;

        if (!empty($expiration) && $expiration < time()) {
            return false;
        }

        $key = self::emHash($username . '|' . $expiration);
        $hash = hash_hmac('md5', $username . '|' . $expiration, $key);

        if ($hmac !== $hash) {
            return false;
        }

        $userData = self::getUserDataByLogin($username);
        if (!$userData) {
            return false;
        }
        $state = isset($userData['state']) ? $userData['state'] : 0;
        if ($state !== User::USER_STATE_NORMAL) {
            return false;
        }
        return $userData;
    }

    public static function genToken()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!empty($_SESSION['em_csrf_token'])) {
            return $_SESSION['em_csrf_token'];
        }
        $token = sha1(getRandStr(32));
        $_SESSION['em_csrf_token'] = $token;
        return $token;
    }

    public static function getToken()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $token = '';
        if (!empty($_SESSION['em_csrf_token'])) {
            $token = $_SESSION['em_csrf_token'];
        }
        return $token;
    }

    public static function checkToken()
    {
        $token = isset($_REQUEST['token']) ? addslashes($_REQUEST['token']) : '';
        $sessionToken = self::getToken();
        // The session is abnormal, the /tmp directory may not be writable, skip the check
        if (empty($sessionToken)) {
            return;
        }
        if ($token !== $sessionToken) {
            emMsg('Token校验失败，请尝试清理浏览器cookie后刷新页面或者更换浏览器重试');
        }
    }
}
