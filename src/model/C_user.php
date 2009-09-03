<?php
/**
 * Model: User Management
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

class emUser {

	var $db;

	function emUser($dbhandle)
	{
		$this->db = $dbhandle;
	}

	/**
	 * Get a list of users
	 *
	 * @param $role User role
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
	 * Update User Information
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
	 * Add a User
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
	 * Delete User
	 *
	 * @param int $uid
	 */
	function deleteUser($uid)
	{
		$this->db->query("update ".DB_PREFIX."blog set author=1 where author=$uid");
		$this->db->query("DELETE FROM ".DB_PREFIX."user where uid=$uid");
	}

	/**
	 * Check the User name exists
	 *
	 * @param string $login
	 * @param int $uid Compatible with the fact that the user name has not changed when updating the author's information
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

?>
