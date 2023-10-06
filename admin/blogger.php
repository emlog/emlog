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
    $newpass = Input::postStrVar('newpass');
    $repeatpass = Input::postStrVar('repeatpass');
    $resp = Input::postStrVar('resp'); // eg: json (only support json now)

    if (empty($nickname)) {
        if ($resp === 'json') {
            Output::error('昵称不能为空');
        }
        emDirect("./blogger.php?error_a=1");
    } elseif (!checkMail($email)) {
        if ($resp === 'json') {
            Output::error('请正确填写邮箱');
        }
        emDirect("./blogger.php?error_email=1");
    } elseif (strlen($newpass) > 0 && strlen($newpass) < 6) {
        if ($resp === 'json') {
            Output::error('密码长度不得小于6位');
        }
        emDirect("./blogger.php?error_c=1");
    } elseif (!empty($newpass) && $newpass != $repeatpass) {
        if ($resp === 'json') {
            Output::error('两次输入的密码不一致');
        }
        emDirect("./blogger.php?error_d=1");
    } elseif ($User_Model->isUserExist($login, UID)) {
        if ($resp === 'json') {
            Output::error('该登录名已被占用');
        }
        emDirect("./blogger.php?error_e=1");
    } elseif ($User_Model->isNicknameExist($nickname, UID)) {
        if ($resp === 'json') {
            Output::error('该昵称已被占用');
        }
        emDirect("./blogger.php?error_f=1");
    } elseif ($User_Model->isMailExist($email, UID)) {
        if ($resp === 'json') {
            Output::error('该邮箱已被占用');
        }
        emDirect("./blogger.php?error_g=1");
    }

    $d = [
        'nickname'    => $nickname,
        'description' => $description,
        'email'       => $email,
        'username'    => $login,
    ];

    if (!empty($newpass)) {
        $PHPASS = new PasswordHash(8, true);
        $newpass = $PHPASS->HashPassword($newpass);
        $d['password'] = $newpass;
    }

    $User_Model->updateUser($d, UID);
    $CACHE->updateCache('user');
    if ($resp === 'json') {
        Output::ok();
    }
    emDirect("./blogger.php?active_edit=1");
}

if ($action == 'update_avatar') {
    $ret = uploadCropImg();
    $file_path = $ret['file_info']['file_path'];

    $User_Model = new User_Model();
    $User_Model->updateUser(array('photo' => $file_path), UID);
    $CACHE->updateCache('user');
    Output::ok($file_path);
}
