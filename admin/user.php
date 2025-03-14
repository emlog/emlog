<?php

/**
 * user
 * @package EMLOG
 * @link https://www.emlog.net
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
    $perpage_num = Input::getStrVar('perpage_num');

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
    $email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
    $password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
    $role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : self::ROLE_WRITER;

    LoginAuth::checkToken();

    if (User::isAdmin()) {
        $ischeck = 'n';
    }

    if ($email == '') {
        emDirect('./user.php?error_email=1');
    }
    if ($User_Model->isMailExist($email)) {
        emDirect("./user.php?error_exist_email=1");
    }
    if (strlen($password) < 6) {
        emDirect('./user.php?error_pwd_len=1');
    }
    if ($password != $password2) {
        emDirect('./user.php?error_pwd2=1');
    }

    $PHPASS = new PasswordHash(8, true);
    $password = $PHPASS->HashPassword($password);

    $User_Model->addUser('', $email, $password, $role);
    $CACHE->updateCache(array('sta', 'user'));
    emDirect('./user.php?active_add=1');
}

if ($action == 'edit') {
    $uid = isset($_GET['uid']) ? (int)$_GET['uid'] : '';

    $data = $User_Model->getOneUser($uid);

    $nickname = $data['nickname'];
    $role = $data['role'];
    $description = $data['description'];
    $username = $data['username'];
    $email = $data['email'];

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
    $username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
    $nickname = isset($_POST['nickname']) ? addslashes(trim($_POST['nickname'])) : '';
    $password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
    $password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
    $email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
    $description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
    $role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : User::ROLE_WRITER;
    $uid = isset($_POST['uid']) ? (int)$_POST['uid'] : '';

    LoginAuth::checkToken();

    //创始人账户不能被他人编辑
    if (!User::isFounder() && $uid === 1) {
        emDirect('./user.php?error_del_b=1');
    }
    if ($uid === 1) {
        $role = User::ROLE_ADMIN;
    }
    if (empty($nickname)) {
        emDirect("./user.php?action=edit&uid={$uid}&error_nickname=1");
    }
    if (empty($email) && empty($username)) {
        emDirect("./user.php?action=edit&uid={$uid}&error_email=1");
    }
    if ($User_Model->isMailExist($email, $uid)) {
        emDirect("./user.php?action=edit&uid={$uid}&error_exist_email=1");
    }
    if ($User_Model->isUserExist($username, $uid)) {
        emDirect("./user.php?action=edit&uid={$uid}&error_exist=1");
    }
    if (strlen($password) > 0 && strlen($password) < 6) {
        emDirect("./user.php?action=edit&uid={$uid}&error_pwd_len=1");
    }
    if ($password != $password2) {
        emDirect("./user.php?action=edit&uid={$uid}&error_pwd2=1");
    }

    $userData = [
        'username'    => $username,
        'nickname'    => $nickname,
        'email'       => $email,
        'description' => $description,
        'role'        => $role,
    ];

    if (!empty($password)) {
        $PHPASS = new PasswordHash(8, true);
        $password = $PHPASS->HashPassword($password);
        $userData['password'] = $password;
    }

    $User_Model->updateUser($userData, $uid);
    $CACHE->updateCache('user');
    emDirect('./user.php?active_update=1');
}

if ($action == 'del') {
    LoginAuth::checkToken();
    $uid = isset($_GET['uid']) ? (int)$_GET['uid'] : '';

    if (UID == $uid) {
        emDirect('./user.php');
    }

    //创始人账户不能被删除
    if ($uid == 1) {
        emDirect('./user.php?error_del_a=1');
    }

    $User_Model->deleteUser($uid);
    $CACHE->updateCache(array('sta', 'user'));
    doAction('delete_user', $uid);
    emDirect('./user.php');
}

if ($action == 'forbid') {
    LoginAuth::checkToken();
    $uid = isset($_GET['uid']) ? (int)$_GET['uid'] : '';

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
    $uid = isset($_GET['uid']) ? (int)$_GET['uid'] : '';

    $User_Model->unforbidUser($uid);
    emDirect('./user.php?active_unfb=1');
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
            if ($id == 1) {
                continue;
            }
            $User_Model->forbidUser($id);
        }
        emDirect('./user.php');
    }
}
