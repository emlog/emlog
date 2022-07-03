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
			$condition = " and email like '$email%'";
		}
		if ($page) {
			$perpage_num = Option::get('admin_perpage_num');
			$startId = ($page - 1) * $perpage_num;
			$limit = "LIMIT $startId, " . $perpage_num;
		}
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "user where 1=1 $condition order by uid desc $limit");
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
		$row = $this->db->once_fetch_array("select * from " . DB_PREFIX . "user where uid=$uid");
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
		$this->db->query("update " . DB_PREFIX . "user set $upStr where uid=$uid");
	}

	function updateUserByMail($userData, $mail) {
		$timestamp = time();
		$Item = ["update_time=$timestamp"];
		foreach ($userData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update " . DB_PREFIX . "user set $upStr where email='$mail'");
	}

	function addUser($username, $mail, $password, $role) {
		$timestamp = time();
		$nickname = getRandStr(8, false);
		$sql = "insert into " . DB_PREFIX . "user (username,email,password,nickname,role,create_time,update_time) values('$username','$mail','$password','$nickname','$role',$timestamp,$timestamp)";
		$this->db->query($sql);
	}

	function deleteUser($uid) {
		$this->db->query("update " . DB_PREFIX . "blog set author=1, checked='y' where author=$uid");
		$this->db->query("delete from " . DB_PREFIX . "user where uid=$uid");
	}

	function forbidUser($uid) {
		$this->db->query("update " . DB_PREFIX . "user set state=1 where uid=$uid");
	}

	function unforbidUser($uid) {
		$this->db->query("update " . DB_PREFIX . "user set state=0 where uid=$uid");
	}

	/**
	 * 用户名是否存在
	 *
	 * @param string $user_name
	 * @param int $uid 兼容更新作者资料时用户名未变更情况
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
