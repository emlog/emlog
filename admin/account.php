<?php

/**
 * account administration
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once '../init.php';

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = Input::getStrVar('action');
$admin_path_code = Input::getStrVar('s', '');
$User_Model = new User_Model();

// 登录页面
if ($action == 'signin') {
    loginAuth::checkLogged();
    if (defined('ADMIN_PATH_CODE') && $admin_path_code !== ADMIN_PATH_CODE) {
        show_404_page(true);
    }
    $login_code = Option::get('login_code') === 'y';
    $login_email_code = Option::get('login_email_code') === 'y';
    $is_signup = Option::get('is_signup') === 'y';

    $page_title = _lang('login');
    require_once View::getAdmView('user_head');
    require_once View::getAdmView('signin');
    View::output();
}

// 登录验证
if ($action == 'dosignin') {
    loginAuth::checkLogged();
    if (defined('ADMIN_PATH_CODE') && $admin_path_code !== ADMIN_PATH_CODE) {
        show_404_page(true);
    }
    $login_type = Input::postStrVar('login_type', 'pwd');
    $persist = Input::postIntVar('persist');
    $resp = Input::postStrVar('resp'); // eg: json (only support json now)
    $login_code = Option::get('login_code') === 'y' ? strtoupper(Input::postStrVar('login_code')) : '';

    // 邮件验证码登录
    if ($login_type === 'code') {
        if (Option::get('login_email_code') !== 'y') {
            if ($resp === 'json') {
                Output::error(_lang('email_code_login_disabled'));
            }
            FlashMsg::redirectAccount('signin', 'err_mail_login_closed', array('s' => $admin_path_code, 'type' => 'code'));
        }

        if (Option::get('login_code') === 'y') {
            if (!isset($_SESSION)) {
                session_start();
            }
            $passed = isset($_SESSION['login_code_passed']) && (time() - (int)$_SESSION['login_code_passed'] < 900);
            if (!$passed && !User::checkLoginCode($login_code)) {
                if ($resp === 'json') {
                    Output::error(_lang('captcha_error'));
                }
                FlashMsg::redirectAccount('signin', 'err_ckcode', array('s' => $admin_path_code, 'type' => 'code'));
            }
            unset($_SESSION['login_code_passed']);
        }

        $mail = Input::postStrVar('mail');
        $mail_code = Input::postStrVar('mail_code');

        if (!checkMail($mail)) {
            if ($resp === 'json') {
                Output::error(_lang('email_format_error'));
            }
            FlashMsg::redirectAccount('signin', 'err_mail_format', array('s' => $admin_path_code, 'type' => 'code'));
        }

        if (!User::checkLoginMailCode($mail, $mail_code)) {
            if ($resp === 'json') {
                Output::error(_lang('email_code_error'));
            }
            FlashMsg::redirectAccount('signin', 'err_mail_code', array('s' => $admin_path_code, 'type' => 'code'));
        }

        $userData = $User_Model->getUserDataByLogin($mail);
        if (false === $userData) {
            if (Option::get('is_signup') !== 'y') {
                if ($resp === 'json') {
                    Output::error(_lang('email_not_registered'));
                }
                FlashMsg::redirectAccount('signin', 'err_mail_unreg', array('s' => $admin_path_code, 'type' => 'code'));
            }
            $PHPASS = new PasswordHash(8, true);
            $randomPass = $PHPASS->HashPassword(getRandStr(16));
            $uid = $User_Model->addUser('', $mail, $randomPass, User::ROLE_WRITER);
            $CACHE->updateCache(['sta', 'user']);
            doAction('register_succeed', $uid);
            $userData = $User_Model->getUserDataByLogin($mail);
        }

        $state = isset($userData['state']) ? $userData['state'] : 0;
        if ($state === User::USER_STATE_FORBID) {
            doAction('login_fail');
            if ($resp === 'json') {
                Output::error(_lang('account_forbidden'));
            }
            FlashMsg::redirectAccount('signin', 'err_forbid', array('s' => $admin_path_code, 'type' => 'code'));
        }

        $uid = $userData['uid'];
        $user_login = !empty($userData['username']) ? $userData['username'] : $mail;

        Register::isRegServer();
        $User_Model->updateUser(['ip' => getIp()], $uid);
        LoginAuth::setAuthCookie($user_login, $persist);
        doAction('login_succeed', $uid, $resp);
        if ($resp === 'json') {
            Output::ok();
        }
        emDirect("./");
    }

    // 密码登录
    $username = Input::postStrVar('user');
    $password = Input::postStrVar('pw');

    if (!User::checkLoginCode($login_code)) {
        if ($resp === 'json') {
            Output::error(_lang('captcha_error'));
        }
        FlashMsg::redirectAccount('signin', 'err_ckcode', array('s' => $admin_path_code));
    }

    $uid = LoginAuth::checkUser($username, $password);
    switch ($uid) {
        case $uid > 0:
            Register::isRegServer();
            $User_Model->updateUser(['ip' => getIp()], $uid);
            LoginAuth::setAuthCookie($username, $persist);
            doAction('login_succeed', $uid, $resp);
            if ($resp === 'json') {
                Output::ok();
            }
            emDirect("./");
            break;
        case LoginAuth::LOGIN_ERROR_USER:
        case LoginAuth::LOGIN_ERROR_PASSWD:
            doAction('login_fail');
            if ($resp === 'json') {
                Output::error(_lang('user_pass_error'));
            }
            FlashMsg::redirectAccount('signin', 'err_login', array('s' => $admin_path_code));
            break;
        case LoginAuth::LOGIN_ERROR_FORBID:
            doAction('login_fail');
            if ($resp === 'json') {
                Output::error(_lang('account_forbidden'));
            }
            FlashMsg::redirectAccount('signin', 'err_forbid', array('s' => $admin_path_code));
            break;
    }
}

// 注册页面
if ($action == 'signup') {
    loginAuth::checkLogged();
    $login_code = Option::get('login_code') === 'y';
    $email_code = Option::get('email_code') === 'y';
    $error_msg = '';

    if (Option::get('is_signup') !== 'y') {
        emMsg(_lang('system_closed_register'));
    }

    $page_title = _lang('register_account');
    include View::getAdmView('user_head');
    require_once View::getAdmView('signup');
    View::output();
}

// 注册验证
if ($action == 'dosignup') {
    loginAuth::checkLogged();

    if (Option::get('is_signup') !== 'y') {
        return;
    }

    $mail = Input::postStrVar('mail');
    $passwd = Input::postStrVar('passwd');
    $repasswd = Input::postStrVar('repasswd');
    $login_code = strtoupper(Input::postStrVar('login_code'));
    $mail_code = Input::postStrVar('mail_code');
    $resp = Input::postStrVar('resp'); // eg: json (only support json now)

    if (!checkMail($mail)) {
        if ($resp === 'json') {
            Output::error(_lang('email_format_error'));
        }
        FlashMsg::redirectAccount('signup', 'error_login');
    }
    if (!User::checkLoginCode($login_code)) {
        if ($resp === 'json') {
            Output::error(_lang('captcha_error'));
        }
        FlashMsg::redirectAccount('signup', 'err_ckcode');
    }
    if (Option::get('email_code') === 'y' && !User::checkMailCode($mail_code)) {
        if ($resp === 'json') {
            Output::error(_lang('email_code_error'));
        }
        FlashMsg::redirectAccount('signup', 'err_mail_code');
    }
    if ($User_Model->isMailExist($mail)) {
        if ($resp === 'json') {
            Output::error(_lang('email_exist_error'));
        }
        FlashMsg::redirectAccount('signup', 'error_exist');
    }
    if (strlen($passwd) < 6) {
        if ($resp === 'json') {
            Output::error(_lang('password_min_length'));
        }
        FlashMsg::redirectAccount('signup', 'error_pwd_len');
    }
    if ($passwd !== $repasswd) {
        if ($resp === 'json') {
            Output::error(_lang('password_inconsistent'));
        }
        FlashMsg::redirectAccount('signup', 'error_pwd2');
    }

    $PHPASS = new PasswordHash(8, true);
    $passwd = $PHPASS->HashPassword($passwd);

    $uid = $User_Model->addUser('', $mail, $passwd, User::ROLE_WRITER);
    $CACHE->updateCache(['sta', 'user']);

    doAction('register_succeed', $uid);

    if ($resp === 'json') {
        Output::ok();
    }
    FlashMsg::redirectAccount('signin', 'succ_reg', array('s' => $admin_path_code));
}

if ($action == 'send_email_code') {
    $mail = Input::postStrVar('mail');

    if (!checkMail($mail)) {
        Output::error(_lang('email_format_error'));
    }

    doAction('send_email_code', $mail);

    $ret = Notice::sendVerifyMailCode($mail);
    if ($ret) {
        Output::ok();
    } else {
        Output::error(_lang('email_code_send_failed'));
    }
}

// 发送登录邮件验证码
if ($action == 'send_login_email_code') {
    if (Option::get('login_email_code') !== 'y') {
        Output::error(_lang('email_code_login_disabled'));
    }

    if (Option::get('login_code') === 'y') {
        $login_code = strtoupper(Input::postStrVar('login_code'));
        if (!User::checkLoginCode($login_code)) {
            Output::error(_lang('captcha_error'));
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['login_code_passed'] = time();
    }

    $mail = Input::postStrVar('mail');
    if (!checkMail($mail)) {
        Output::error(_lang('email_format_error'));
    }

    if (!$User_Model->isMailExist($mail)) {
        if (Option::get('is_signup') !== 'y') {
            Output::error(_lang('email_not_registered'));
        }
    } else {
        $userData = $User_Model->getUserDataByLogin($mail);
        if ($userData && isset($userData['state']) && (int)$userData['state'] === User::USER_STATE_FORBID) {
            Output::error(_lang('account_forbidden'));
        }
    }

    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['login_mail_time']) && time() - (int)$_SESSION['login_mail_time'] < 60) {
        Output::error(_lang('send_code_too_frequent'));
    }

    doAction('send_login_email_code', $mail);

    $ret = Notice::sendLoginMailCode($mail);
    if ($ret) {
        Output::ok();
    } else {
        Output::error(_lang('email_code_send_failed'));
    }
}

if ($action == 'reset') {
    if (ISLOGIN === true) {
        emDirect("../admin/");
    }

    $login_code = Option::get('login_code') === 'y';
    $error_msg = '';

    $page_title = _lang('reset_password');
    include View::getAdmView('user_head');
    require_once View::getAdmView('reset');
    View::output();
}

if ($action == 'doreset') {
    loginAuth::checkLogged();

    $mail = Input::postStrVar('mail');
    $login_code = strtoupper(Input::postStrVar('login_code'));
    $resp = Input::postStrVar('resp'); // eg: json (only support json now)

    if (!User::checkLoginCode($login_code)) {
        if ($resp === 'json') {
            Output::error(_lang('captcha_error'));
        }
        FlashMsg::redirectAccount('reset', 'err_ckcode');
    }
    if (!$mail || !$User_Model->isMailExist($mail)) {
        if ($resp === 'json') {
            Output::error(_lang('reg_email_error'));
        }
        FlashMsg::redirectAccount('reset', 'error_mail');
    }

    $ret = Notice::sendResetMailCode($mail);
    if ($ret) {
        if ($resp === 'json') {
            Output::ok();
        }
        FlashMsg::redirectAccount('reset2', 'succ_mail');
    } else {
        if ($resp === 'json') {
            Output::error(_lang('email_code_send_failed'));
        }
        FlashMsg::redirectAccount('reset', 'error_sendmail');
    }
}

if ($action == 'reset2') {
    if (ISLOGIN === true) {
        emDirect("../admin/");
    }

    $login_code = Option::get('login_code') === 'y';
    $error_msg = '';

    $page_title = _lang('reset_password');
    include View::getAdmView('user_head');
    require_once View::getAdmView('reset2');
    View::output();
}

if ($action == 'doreset2') {
    $mail_code = Input::postStrVar('mail_code');
    $passwd = Input::postStrVar('passwd');
    $repasswd = Input::postStrVar('repasswd');
    $resp = Input::postStrVar('resp'); // only json

    if (strlen($passwd) < 6) {
        if ($resp === 'json') {
            Output::error(_lang('password_min_length'));
        }
        FlashMsg::redirectAccount('reset2', 'error_pwd_len');
    }
    if ($passwd !== $repasswd) {
        if ($resp === 'json') {
            Output::error(_lang('password_inconsistent'));
        }
        FlashMsg::redirectAccount('reset2', 'error_pwd2');
    }
    if (!$mail_code || !User::checkMailCode($mail_code)) {
        if ($resp === 'json') {
            Output::error(_lang('email_code_error'));
        }
        FlashMsg::redirectAccount('reset2', 'err_mail_code');
    }

    $PHPASS = new PasswordHash(8, true);
    $passwd = $PHPASS->HashPassword($passwd);
    if (!isset($_SESSION)) {
        session_start();
    }
    $mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
    $User_Model->updateUserByMail(['password' => $passwd], $mail);
    if ($resp === 'json') {
        Output::ok();
    }
    FlashMsg::redirectAccount('signin', 'succ_reset', array('s' => $admin_path_code));
}

if ($action == 'logout') {
    setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
    emDirect("../");
}
