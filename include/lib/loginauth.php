<?php
/**
 * Login authentication
 * @package EMLOG (www.emlog.net)
 */

class LoginAuth
{

    const LOGIN_ERROR_USER = -1;
    const LOGIN_ERROR_PASSWD = -2;
    const LOGIN_ERROR_AUTHCODE = -3;

    /**
     * Verify that the user is logged on
     */
    public static function isLogin()
    {
        global $userData;
        $auth_cookie = '';
        if (isset($_COOKIE[AUTH_COOKIE_NAME])) {
            $auth_cookie = $_COOKIE[AUTH_COOKIE_NAME];
        } elseif (isset($_POST[AUTH_COOKIE_NAME])) {
            $auth_cookie = $_POST[AUTH_COOKIE_NAME];
        } else {
            return false;
        }

        if (($userData = self::validateAuthCookie($auth_cookie)) === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Verify User/Password
     */
    public static function checkUser($username, $password, $imgcode)
    {
        session_start();
        if (empty($username) || empty($password)) {
            return false;
        }
        $sessionCode = $_SESSION['code'] ?? '';
        if (Option::get('login_code') === 'y' && (empty($imgcode) || $imgcode != $sessionCode)) {
            unset($_SESSION['code']);
            return self::LOGIN_ERROR_AUTHCODE;
        }
        $userData = self::getUserDataByLogin($username);
        if (false === $userData) {
            return self::LOGIN_ERROR_USER;
        }
        $hash = $userData['password'];
        if (true === self::checkPassword($password, $hash)) {
            return true;
        } else {
            return self::LOGIN_ERROR_PASSWD;
        }
    }

    /**
     * Login Page
     */
    public static function loginPage($errorCode = NULL)
    {
        $ckcode = Option::get('login_code') == 'y' ? true : false;
        $error_msg = '';
        switch ($errorCode) {
            case self::LOGIN_ERROR_AUTHCODE:
/*vot*/         $error_msg = lang('captcha_error_reenter');
                break;
            case self::LOGIN_ERROR_USER:
            case self::LOGIN_ERROR_PASSWD:
/*vot*/         $error_msg = lang('password_wrong_reenter');
                break;
        }

        require_once View::getView('login');
        View::output();
    }

    /**
     * Check the User data by login name
     *
     * @param string $userLogin User's username
     * @return bool|object False on failure, User DB row object
     */
    public static function getUserDataByLogin($userLogin)
    {
        $DB = Database::getInstance();
        if (empty($userLogin)) {
            return false;
        }
        $userData = false;
        if (!$userData = $DB->once_fetch_array("SELECT * FROM " . DB_PREFIX . "user WHERE username = '$userLogin'")) {
            return false;
        }
        $userData['nickname'] = htmlspecialchars($userData['nickname']);
        $userData['username'] = htmlspecialchars($userData['username']);
        return $userData;
    }

    /**
     * Compare the plaintext password and the database encrypted password
     *
     * @param string $password Plaintext user's password
     * @param string $hash Hash of the user's password to check against.
     * @return bool False, if the $password does not match the hashed password
     */
    public static function checkPassword($password, $hash)
    {
        global $em_hasher;
        if (empty($em_hasher)) {
            $em_hasher = new PasswordHash(8, true);
        }
        $check = $em_hasher->CheckPassword($password, $hash);
        return $check;
    }

    /**
     * Write the login authentication cookie
     *
     * @param int $user_id User ID
     * @param bool $remember Whether to remember the user or not
     */
    public static function setAuthCookie($user_login, $ispersis = false)
    {
        if ($ispersis) {
            $expiration = time() + 3600 * 24 * 30 * 12;
        } else {
            $expiration = null;
        }
        $auth_cookie_name = AUTH_COOKIE_NAME;
        $auth_cookie = self::generateAuthCookie($user_login, $expiration);
        setcookie($auth_cookie_name, $auth_cookie, $expiration, '/');
    }

    /**
     * Generate the login authentication cookie
     *
     * @param int $user_id user login
     * @param int $expiration Cookie expiration in seconds
     * @return string Authentication cookie contents
     */
    private static function generateAuthCookie($user_login, $expiration)
    {
        $key = self::emHash($user_login . '|' . $expiration);
        $hash = hash_hmac('md5', $user_login . '|' . $expiration, $key);

        $cookie = $user_login . '|' . $expiration . '|' . $hash;

        return $cookie;
    }

    /**
     * Get hash of given string.
     *
     * @param string $data Plain text to hash
     * @return string Hash of $data
     */
    private static function emHash($data)
    {
        $key = AUTH_KEY;
        return hash_hmac('md5', $data, $key);
    }

    /**
     * Verify cookie
     * Validates authentication cookie.
     *
     * @param string $cookie Optional. If used, will validate contents instead of cookie's
     * @return bool|int False if invalid cookie, User ID if valid.
     */
    private static function validateAuthCookie($cookie = '')
    {
        if (empty($cookie)) {
            return false;
        }

        $cookie_elements = explode('|', $cookie);
        if (count($cookie_elements) != 3) {
            return false;
        }

        list($username, $expiration, $hmac) = $cookie_elements;

        if (!empty($expiration) && $expiration < time()) {
            return false;
        }

        $key = self::emHash($username . '|' . $expiration);
        $hash = hash_hmac('md5', $username . '|' . $expiration, $key);

        if ($hmac != $hash) {
            return false;
        }

        $user = self::getUserDataByLogin($username);
        if (!$user) {
            return false;
        }
        return $user;
    }

    /**
     * Generate token, defense CSRF attack
     */
    public static function genToken()
    {
        $token_cookie_name = 'EM_TOKENCOOKIE_' . md5(substr(AUTH_KEY, 16, 32) . UID);
        if (isset($_COOKIE[$token_cookie_name])) {
            return $_COOKIE[$token_cookie_name];
        } else {
            $token = md5(getRandStr(16));
            setcookie($token_cookie_name, $token, 0, '/');
            return $token;
        }
    }

    /**
     * Check the token, defense CSRF attack
     */
    public static function checkToken()
    {
        $token = isset($_REQUEST['token']) ? addslashes($_REQUEST['token']) : '';
        if ($token != self::genToken()) {
/*vot*/     emMsg(lang('no_permission') . ', ');
        }
    }
}
