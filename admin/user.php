<?php

/**
 * user
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$User_Model = new User_Model();

if (empty($action)) {
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $order = Input::getStrVar('order');
    $perpage_num = Input::getIntVar('perpage_num');

    $email = $nickname = '';
    if (filter_var($keyword, FILTER_VALIDATE_EMAIL)) {
        $email = $keyword;
    } else {
        $nickname = $keyword;
    }

    if ($perpage_num > 0) {
        $perPage = $perpage_num;
        Option::updateOption('admin_user_perpage_num', $perpage_num);
        $CACHE->updateCache('options');
    } else {
        $admin_user_perpage_num = Option::get('admin_user_perpage_num');
        $perPage = $admin_user_perpage_num ? $admin_user_perpage_num : 20;
    }

    $users = $User_Model->getUsers($email, $nickname, $order, $page, $perPage);
    $userCount = $User_Model->getUserCount($email, $nickname);

    $subPage = '';
    foreach ($_GET as $key => $val) {
        if (in_array($key, ['keyword', 'order', 'perpage_num'])) {
            $subPage .= "&$key=$val";
        }
    }
    $pageurl = pagination($userCount, $perPage, $page, "user.php?{$subPage}&page=");

    include View::getAdmView('header');
    require_once View::getAdmView('user');
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'new') {
    $email = Input::postStrVar('email');
    $password = Input::postStrVar('password');
    $password2 = Input::postStrVar('password2');
    $role = Input::postStrVar('role', User::ROLE_WRITER);

    LoginAuth::checkToken();

    if (User::isAdmin()) {
        $ischeck = 'n';
    }

    if ($email == '') {
        FlashMsg::redirectAdmin('user', 'error_email');
    }
    if ($User_Model->isMailExist($email)) {
        FlashMsg::redirectAdmin('user', 'error_exist_email');
    }
    if (strlen($password) < 6) {
        FlashMsg::redirectAdmin('user', 'error_pwd_len');
    }
    if ($password != $password2) {
        FlashMsg::redirectAdmin('user', 'error_pwd2');
    }

    $PHPASS = new PasswordHash(8, true);
    $password = $PHPASS->HashPassword($password);

    $User_Model->addUser('', $email, $password, $role);
    $CACHE->updateCache(array('sta', 'user'));
    FlashMsg::redirectAdmin('user', 'active_add');
}

if ($action == 'edit') {
    $uid = Input::getIntVar('uid');

    $data = $User_Model->getOneUser($uid);

    $avatar = isset($data['photo']) ? $data['photo'] : '';
    $nickname = $data['nickname'];
    $role = $data['role'];
    $description = $data['description'];
    $username = $data['username'];
    $email = $data['email'];
    $credits = (int)$data['credits'];

    $ex1 = $ex2 = $ex3 = '';
    if (user::isVisitor($role)) {
        $ex1 = 'selected="selected"';
    } elseif (User::isEditor($role)) {
        $ex2 = 'selected="selected"';
    } elseif (User::isAdmin($role)) {
        $ex3 = 'selected="selected"';
    }

    include View::getAdmView('header');
    require_once View::getAdmView('user_edit');
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'update') {
    $username = Input::postStrVar('username');
    $nickname = Input::postStrVar('nickname');
    $password = Input::postStrVar('password');
    $password2 = Input::postStrVar('password2');
    $email = Input::postStrVar('email');
    $description = Input::postStrVar('description');
    $role = Input::postStrVar('role', User::ROLE_WRITER);
    $uid = Input::postIntVar('uid');
    $credits = Input::postIntVar('credits', 0, 0);
    $avatar = Input::postStrVar('avatar');

    LoginAuth::checkToken();

    if ($credits < 0 || $credits > 999999999) {
        $credits = 0;
    }

    //创始人账户不能被他人编辑
    if (!User::isFounder() && $uid === 1) {
        FlashMsg::redirectAdmin('user', 'error_del_b');
    }
    if ($uid === 1) {
        $role = User::ROLE_ADMIN;
    }
    if (empty($nickname)) {
        FlashMsg::redirectAdmin('user', 'error_nickname', array('action' => 'edit', 'uid' => $uid), 'user_edit_flash_messages');
    }
    if (empty($email) && empty($username)) {
        FlashMsg::redirectAdmin('user', 'error_email', array('action' => 'edit', 'uid' => $uid), 'user_edit_flash_messages');
    }
    if ($User_Model->isMailExist($email, $uid)) {
        FlashMsg::redirectAdmin('user', 'error_exist_email', array('action' => 'edit', 'uid' => $uid), 'user_edit_flash_messages');
    }
    if ($User_Model->isUserExist($username, $uid)) {
        FlashMsg::redirectAdmin('user', 'error_exist', array('action' => 'edit', 'uid' => $uid), 'user_edit_flash_messages');
    }
    if (strlen($password) > 0 && strlen($password) < 6) {
        FlashMsg::redirectAdmin('user', 'error_pwd_len', array('action' => 'edit', 'uid' => $uid), 'user_edit_flash_messages');
    }
    if ($password != $password2) {
        FlashMsg::redirectAdmin('user', 'error_pwd2', array('action' => 'edit', 'uid' => $uid), 'user_edit_flash_messages');
    }

    $userData = [
        'username'    => $username,
        'nickname'    => $nickname,
        'email'       => $email,
        'description' => $description,
        'role'        => $role,
        'credits'     => $credits,
        'photo'       => $avatar,
    ];

    if (!empty($password)) {
        $PHPASS = new PasswordHash(8, true);
        $password = $PHPASS->HashPassword($password);
        $userData['password'] = $password;
    }

    $User_Model->updateUser($userData, $uid);
    $CACHE->updateCache('user');
    FlashMsg::redirectAdmin('user', 'active_update');
}

if ($action == 'del') {
    LoginAuth::checkToken();
    $uid = Input::getIntVar('uid');

    if (UID == $uid) {
        emDirect('./user.php');
    }

    //创始人账户不能被删除
    if ($uid == 1) {
        FlashMsg::redirectAdmin('user', 'error_del_a');
    }

    $User_Model->deleteUser($uid);
    $CACHE->updateCache(array('sta', 'user'));
    doAction('delete_user', $uid);
    emDirect('./user.php');
}

if ($action == 'forbid') {
    LoginAuth::checkToken();
    $uid = Input::getIntVar('uid');

    if (UID == $uid) {
        emDirect('./user.php');
    }

    //创始人账户不能被禁用
    if ($uid == 1) {
        emDirect('./user.php');
    }

    $User_Model->forbidUser($uid);
    emDirect('./user.php');
}

if ($action == 'unforbid') {
    LoginAuth::checkToken();
    $uid = Input::getIntVar('uid');

    $User_Model->unforbidUser($uid);
    FlashMsg::redirectAdmin('user', 'active_unfb');
}

/**
 * 删除用户头像的 action 动作
 * 如果是本地图片文件，直接删除物理文件；如果是外部头像，直接清空数据库字段。
 */
if ($action == 'del_avatar') {
    LoginAuth::checkToken();
    $uid = Input::postIntVar('uid');

    // 创始人账户不能被他人编辑（比如删除头像）
    if (!User::isFounder() && $uid === 1) {
        Output::error('无权编辑创始人账户');
    }

    $user = $User_Model->getOneUser($uid);
    if ($user) {
        $photo = $user['photo'];
        if (!empty($photo)) {
            // 如果是本地图片文件（非合规的 URL 资源），则删除文件
            if (!filter_var($photo, FILTER_VALIDATE_URL)) {
                $filePath = '';
                if (strpos($photo, '../') === 0) {
                    $filePath = EMLOG_ROOT . '/' . substr($photo, 3);
                } else {
                    $filePath = EMLOG_ROOT . '/' . ltrim($photo, '/');
                }

                if (file_exists($filePath) && is_file($filePath)) {
                    @unlink($filePath);
                }
            }

            // 更新用户头像字段为空
            $User_Model->updateUser(['photo' => ''], $uid);
            $CACHE->updateCache('user');
        }
        Output::ok();
    } else {
        Output::error('用户不存在');
    }
}

if ($action == 'operate_user') {
    $operate = Input::requestStrVar('operate');
    $user_ids = Input::postIntArray('user_ids');

    if (!$operate) {
        emDirect("./user.php");
    }
    if (empty($user_ids)) {
        emDirect("./user.php");
    }

    if ($operate == 'forbid') {
        foreach ($user_ids as $id) {
            // 不能禁用创始人，也不能禁用当前登录用户自己
            if ($id == 1 || $id == UID) {
                continue;
            }
            $User_Model->forbidUser($id);
        }
        emDirect('./user.php');
    }

    if ($operate == 'unforbid') {
        foreach ($user_ids as $id) {
            if ($id == 1) {
                continue;
            }
            $User_Model->unforbidUser($id);
        }
        emDirect('./user.php');
    }
}
