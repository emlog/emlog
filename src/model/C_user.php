<?php
/**
 * 模型：用户管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

class emUser {

	var $db;

	function emUser($dbhandle)
	{
		$this->db = $dbhandle;
	}

	/**
	 * 获取用户列表
	 *
	 * @param 用户组 $role
	 * @return array
	 */
	function getUsers($role = 'writer')
	{
		$res = $this->db->query("SELECT * FROM ".DB_PREFIX."user where role='writer'");
		$users = array();
		while($row = $this->db->fetch_array($res))
		{
			$row['name'] = htmlspecialchars($row['nickname']);
			$row['login'] = htmlspecialchars($row['username']);
			$row['email'] = htmlspecialchars($row['email']);
			$row['description'] = htmlspecialchars($row['description']);
			$users[] = $row;
		}
		return $users;
	}

	function getOneUser($uid)
	{
		$row = $this->db->once_fetch_array("select * from ".DB_PREFIX."user where uid=$uid");
		$userData = array();
		if($row)
		{
			$userData = array(
			'username' => htmlspecialchars($row['username']),
			'nickname' => htmlspecialchars($row['nickname']),
			'email' => htmlspecialchars($row['email']),
			'photo' => htmlspecialchars($row['photo']),
			'description' => htmlspecialchars($row['description'])
			);
		}
		return $userData;
	}

	/**
	 * 更新用户信息
	 *
	 * @param array $userData
	 * @param int $uid
	 */
	function updateUser($userData, $uid)
	{
		$Item = array();
		foreach ($userData as $key => $data)
		{
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update ".DB_PREFIX."user set $upStr where uid=$uid");
	}

	/**
	 * 添加用户
	 *
	 * @param string $login
	 * @param string $password
	 * @param string $role
	 */
	function addUser($login, $password,  $role)
	{
		$sql="insert into ".DB_PREFIX."user (username,password,role) values('$login','$password','$role')";
		$this->db->query($sql);
	}
	
	/**
	 * 删除用户
	 *
	 * @param int $uid
	 */
	function deleteUser($uid)
	{
		$this->db->query("update ".DB_PREFIX."blog set author=1 where author=$uid");
		$this->db->query("DELETE FROM ".DB_PREFIX."user where uid=$uid");
	}
	
	/**
	 * 获取用户登录名
	 *
	 * @param int $uid
	 * @return unknown
	 */
	function getUserLogin($uid)
	{
		$row = $this->db->once_fetch_array("SELECT username FROM ".DB_PREFIX."user WHERE uid=$uid");
		return $row['username'];
	}

}

?>
