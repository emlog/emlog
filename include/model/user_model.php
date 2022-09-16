<?php
/**
 * user model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class User_Model {

	private $db;

	public function __construct() {
		$this->db = Database::getInstance();
	}

	function getUsers($email = '', $page = 1) {
		$condition = $limit = '';
		if ($email) {
			$condition = " AND email LIKE '$email%'";
		}
		if ($page) {
			$perpage_num = Option::get('admin_perpage_num');
			$startId = ($page - 1) * $perpage_num;
			$limit = "LIMIT $startId, " . $perpage_num;
		}
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE 1=1 $condition ORDER BY uid DESC $limit");
		$users = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['name'] = htmlspecialchars($row['nickname']);
			$row['login'] = htmlspecialchars($row['username']);
			$row['email'] = htmlspecialchars($row['email']);
			$row['description'] = htmlspecialchars($row['description']);
			$row['create_time'] = smartDate($row['create_time']);
			$row['update_time'] = smartDate($row['update_time']);
			$row['role'] = User::getRoleName($row['role'], (int)$row['uid']);
			$users[] = $row;
		}
		return $users;
	}

	function getOneUser($uid) {
		$row = $this->db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "user WHERE uid=$uid");
		$userData = [];
		if ($row) {
			$userData = array(
				'username'    => htmlspecialchars($row['username']),
				'nickname'    => htmlspecialchars($row['nickname']),
				'email'       => htmlspecialchars($row['email']),
				'photo'       => htmlspecialchars($row['photo']),
				'description' => htmlspecialchars($row['description']),
				'role'        => $row['role'],
				'ischeck'     => $row['ischeck'],
			);
		}
		return $userData;
	}

	function updateUser($userData, $uid) {
		$utctimestamp = time();
		$Item = ["update_time=$utctimestamp"];
		foreach ($userData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("UPDATE " . DB_PREFIX . "user SET $upStr WHERE uid=$uid");
	}

	function updateUserByMail($userData, $mail) {
		$timestamp = time();
		$Item = ["update_time=$timestamp"];
		foreach ($userData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("UPDATE " . DB_PREFIX . "user SET $upStr WHERE email='$mail'");
	}

	function addUser($username, $mail, $password, $role) {
		$timestamp = time();
		$nickname = getRandStr(8, false);
		$sql = "INSERT INTO " . DB_PREFIX . "user (username,email,password,nickname,role,create_time,update_time) VALUES('$username','$mail','$password','$nickname','$role',$timestamp,$timestamp)";
		$this->db->query($sql);
	}

	function deleteUser($uid) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET author=1, checked='y' WHERE author=$uid");
		$this->db->query("DELETE FROM " . DB_PREFIX . "user WHERE uid=$uid");
	}

	function forbidUser($uid) {
		$this->db->query("UPDATE " . DB_PREFIX . "user SET state=1 WHERE uid=$uid");
	}

	function unforbidUser($uid) {
		$this->db->query("UPDATE " . DB_PREFIX . "user SET state=0 WHERE uid=$uid");
	}

	/**
	 * Check the User name exists
	 *
	 * @param string $user_name
	 * @param int $uid Compatible with the fact that the user name has not changed when updating the author's information
	 * @return boolean
	 */
	function isUserExist($user_name, $uid = '') {
		if (empty($user_name)) {
			return false;
		}
		$subSql = $uid ? 'and uid!=' . $uid : '';
		$data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user WHERE username='$user_name' $subSql");
		if ($data['total'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	function isNicknameExist($nickname, $uid = '') {
		if (empty($nickname)) {
			return FALSE;
		}
		$subSql = $uid ? 'and uid!=' . $uid : '';
		$data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user WHERE nickname='$nickname' $subSql");
		if ($data['total'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	function isMailExist($mail, $uid = '') {
		if (empty($mail)) {
			return FALSE;
		}
		$subSql = $uid ? 'and uid!=' . $uid : '';
		$data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user WHERE email='$mail' $subSql");
		if ($data['total'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	function getUserNum() {
		$data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user");
		return $data['total'];
	}
}
