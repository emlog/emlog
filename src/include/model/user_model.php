<?php
/**
 * 用户管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class User_Model {
	/**
	 * 内部数据对象
	 * @var MySql
	 */
	private $db;

	function __construct()
	{
		$this->db = MySql::getInstance();
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
	function isUserExist($login, $uid = '')
	{
		$subSql = $uid ? 'and uid!='.$uid : '';
		$query = $this->db->query("SELECT uid FROM ".DB_PREFIX."user WHERE username='$login' $subSql");
		$res = $this->db->num_rows($query);
		if ($res > 0)
		{
			return true;
		}else {
			return false;
		}
	}

}
