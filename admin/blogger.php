<?php
/**
 * user profile
 *
 * @package EMLOG (www.emlog.net)
 *
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

	include View::getView('header');
	require_once(View::getView('blogger'));
	include View::getView('footer');
	View::output();
}

if ($action == 'update') {
	LoginAuth::checkToken();
	$User_Model = new User_Model();
	$nickname = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';

	$login = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$newpass = isset($_POST['newpass']) ? addslashes(trim($_POST['newpass'])) : '';
	$repeatpass = isset($_POST['repeatpass']) ? addslashes(trim($_POST['repeatpass'])) : '';

	if (strlen($nickname) > 20) {
		emDirect("./blogger.php?error_a=1");
	} else if ($email != '' && !checkMail($email)) {
		emDirect("./blogger.php?error_b=1");
	} elseif (strlen($newpass) > 0 && strlen($newpass) < 6) {
		emDirect("./blogger.php?error_c=1");
	} elseif (!empty($newpass) && $newpass != $repeatpass) {
		emDirect("./blogger.php?error_d=1");
	} elseif ($User_Model->isUserExist($login, UID)) {
		emDirect("./blogger.php?error_e=1");
	} elseif ($User_Model->isNicknameExist($nickname, UID)) {
		emDirect("./blogger.php?error_f=1");
	}

	if (!empty($newpass)) {
		$PHPASS = new PasswordHash(8, true);
		$newpass = $PHPASS->HashPassword($newpass);
		$User_Model->updateUser(array('password' => $newpass), UID);
	}

	if (!empty($login)) {
		$User_Model->updateUser(array('username' => $login), UID);
	}

	$User_Model->updateUser(array('nickname' => $nickname, 'email' => $email, 'description' => $description), UID);
	$CACHE->updateCache('user');
	emDirect("./blogger.php?active_edit=1");
}

if ($action == 'update_avatar') {
	$data = isset($_POST['image']) ? addslashes($_POST['image']) : '';
	//data:image/png;base64,xxxx
	$image_array = explode(",", $data);
	if (empty($image_array[1])) {
		exit("error");
	}

	$data = base64_decode($image_array[1]);

	$fname = emFilePutContent($data);
	if (!$fname) {
		exit("error");
	}

	$User_Model = new User_Model();
	$User_Model->updateUser(array('photo' => $fname), UID);
	$CACHE->updateCache('user');
	echo $fname;
}
