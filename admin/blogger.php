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

    $icon = $photo ?: "./views/images/avatar.svg";

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once(View::getAdmView('blogger'));
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

if ($action == 'update') {
    LoginAuth::checkToken();
    $User_Model = new User_Model();
    $nickname = Input::postStrVar('name');
    $email = Input::postStrVar('email');
    $description = Input::postStrVar('description');
    $login = Input::postStrVar('username');

    if (empty($nickname)) {
        Output::error('昵称不能为空');
    } elseif (!checkMail($email)) {
        Output::error('请正确填写邮箱');
    } elseif ($User_Model->isNicknameExist($nickname, UID)) {
        Output::error('昵称已被占用');
    } elseif ($User_Model->isMailExist($email, UID)) {
        Output::error('邮箱已被占用');
    } elseif ($User_Model->isUserExist($login, UID)) {
        Output::error('登录名已被占用');
    }

    $d = [
        'nickname'    => $nickname,
        'description' => $description,
        'email'       => $email,
        'username'    => $login,
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
        Output::error('密码不得小于6位');
    } elseif ($new_passwd !== $new_passwd2) {
        Output::error('两次密码不一致');
    }

    $PHPASS = new PasswordHash(8, true);
    $new_passwd = $PHPASS->HashPassword($new_passwd);
    $d['password'] = $new_passwd;

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
