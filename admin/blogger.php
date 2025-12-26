<?php

/**
 * user profile
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
    $User_Model = new User_Model();
    $row = $User_Model->getOneUser(UID);
    extract($row);

    $icon = User::getAvatar($photo);

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once(View::getAdmView('blogger'));
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

if ($action == 'update') {
    LoginAuth::checkToken();
    $User_Model = new User_Model();
    $nickname = Input::postStrVar('name');
    $description = Input::postStrVar('description');
    $username = Input::postStrVar('username');

    if (empty($nickname)) {
        Output::error(_lang('nickname_required'));
    } elseif ($User_Model->isNicknameExist($nickname, UID)) {
        Output::error(_lang('nickname_exists'));
    } elseif ($User_Model->isUserExist($username, UID)) {
        Output::error(_lang('username_exists'));
    }

    $d = [
        'nickname'    => $nickname,
        'description' => $description,
        'username'    => $username,
    ];

    $User_Model->updateUser($d, UID);
    $CACHE->updateCache('user');
    Output::ok();
}

if ($action === 'change_password') {
    LoginAuth::checkToken();
    $User_Model = new User_Model();
    $new_passwd = Input::postStrVar('new_passwd');
    $new_passwd2 = Input::postStrVar('new_passwd2');

    if (strlen($new_passwd) < 6) {
        Output::error(_lang('password_too_short'));
    } elseif ($new_passwd !== $new_passwd2) {
        Output::error(_lang('password_mismatch'));
    }

    $PHPASS = new PasswordHash(8, true);
    $new_passwd = $PHPASS->HashPassword($new_passwd);
    $d['password'] = $new_passwd;

    $User_Model->updateUser($d, UID);
    $CACHE->updateCache('user');
    Output::ok();
}

if ($action === 'change_email') {
    LoginAuth::checkToken();
    $User_Model = new User_Model();
    $email = Input::postStrVar('email');
    $mail_code = Input::postStrVar('mail_code');

    if (!checkMail($email)) {
        Output::error(_lang('email_invalid'));
    } elseif ($User_Model->isMailExist($email, UID)) {
        Output::error(_lang('email_exists'));
    }

    if (!User::checkMailCode($mail_code)) {
        Output::error(_lang('captcha_error'));
    }

    $d = [
        'email' => $email,
    ];

    $User_Model->updateUser($d, UID);
    $CACHE->updateCache('user');
    Output::ok();
}

if ($action == 'update_avatar') {
    $ret = uploadCropImg();
    $file_path = $ret['file_info']['file_path'];

    $User_Model = new User_Model();
    $User_Model->updateUser(array('photo' => $file_path), UID);
    $CACHE->updateCache('user');
    Output::ok($file_path);
}
