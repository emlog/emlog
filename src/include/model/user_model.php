<?php
/**
 * 用户管理
 * @copyright (c) Emlog All Rights Reserved
 */

class User_Model {

	private $db;

	function __construct() {
		$this->db = MySql::getInstance();
	}

	function getUsers($page = null) {
        $condition = '';
		if ($page) {
			$perpage_num = Option::get('admin_perpage_num');
			$startId = ($page - 1) * $perpage_num;
			$condition = "LIMIT $startId, ".$perpage_num;
		}
		$res = $this->db->query("SELECT * FROM ".DB_PREFIX."user $condition");
		$users = array();
		while($row = $this->db->fetch_array($res)) {
			$row['name'] = htmlspecialchars($row['nickname']);
			$row['login'] = htmlspecialchars($row['username']);
			$row['email'] = htmlspecialchars($row['email']);
			$row['description'] = htmlspecialchars($row['description']);
			$users[] = $row;
		}
		return $users;
	}

	function getOneUser($uid) {
		$row = $this->db->once_fetch_array("select * from ".DB_PREFIX."user where uid=$uid");
		$userData = array();
		if($row) {
			$userData = array(
				'username' => htmlspecialchars($row['username']),
				'nickname' => htmlspecialchars($row['nickname']),
				'email' => htmlspecialchars($row['email']),
				'photo' => htmlspecialchars($row['photo']),
				'description' => htmlspecialchars($row['description']),
				'role' => $row['role'],
                'ischeck' => $row['ischeck'],
			);
		}
		return $userData;
	}

	function updateUser($userData, $uid) {
		$Item = array();
		foreach ($userData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update ".DB_PREFIX."user set $upStr where uid=$uid");
	}

	function addUser($login, $password,  $role, $ischeck) {
		$sql="insert into ".DB_PREFIX."user (username,password,role,ischeck) values('$login','$password','$role','$ischeck')";
		$this->db->query($sql);
	}

	function deleteUser($uid) {
		$this->db->query("update ".DB_PREFIX."blog set author=1 and checked='y' where author=$uid");
		$this->db->query("delete ".DB_PREFIX."twitter,".DB_PREFIX."reply from ".DB_PREFIX."twitter left join ".DB_PREFIX."reply on ".DB_PREFIX."twitter.id=".DB_PREFIX."reply.tid where ".DB_PREFIX."twitter.author=$uid");
		$this->db->query("delete from ".DB_PREFIX."user where uid=$uid");
	}

	/**
	 * 判断用户名是否存在
	 *
	 * @param string $login
	 * @param int $uid 兼容更新作者资料时用户名未变更情况
	 * @return boolean
	 */
	function isUserExist($login, $uid = '') {
		$subSql = $uid ? 'and uid!='.$uid : '';
		$query = $this->db->query("SELECT uid FROM ".DB_PREFIX."user WHERE username='$login' $subSql");
		$res = $this->db->num_rows($query);
		if ($res > 0) {
			return true;
		}else {
			return false;
		}
	}

    /**
	 * 判断用户昵称是否存在
	 *
	 * @param string $nickname
	 * @param int $uid 兼容更新作者资料时用户名未变更情况
	 * @return boolean
	 */
	function isNicknameExist($nickname, $uid = '') {
		$subSql = $uid ? 'and uid!='.$uid : '';
		$query = $this->db->query("SELECT uid FROM ".DB_PREFIX."user WHERE nickname='$nickname' $subSql");
		$res = $this->db->num_rows($query);
		if ($res > 0) {
			return true;
		}else {
			return false;
		}
	}

	function getUserNum() {
		$sql = "SELECT uid FROM ".DB_PREFIX."user";
		$res = $this->db->query($sql);
		return $this->db->num_rows($res);
	}

}
