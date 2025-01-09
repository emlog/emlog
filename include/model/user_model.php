<?php

/**
 * user model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class User_Model
{

    private $db;
    private $table;
    private $table_blog;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'user';
        $this->table_blog = DB_PREFIX . 'blog';
    }

    public function getUsers($email = '', $nickname = '', $order = '', $page = 1, $perpage_num = 20)
    {
        $condition = $limit = '';
        if ($email) {
            $condition = " and email like '$email%'";
        }
        if ($nickname) {
            $condition = " and nickname like '%$nickname%'";
        }
        if ($page) {
            $startId = ($page - 1) * $perpage_num;
            $limit = "LIMIT $startId, " . $perpage_num;
        }
        switch ($order) {
            case 'update':
                $condition .= ' ORDER BY update_time DESC';
                break;
            case 'admin':
                $condition .= " ORDER BY role IN('admin','editor') DESC";
                break;
            default:
                $condition .= ' ORDER BY uid DESC';
        }
        $res = $this->db->query("SELECT * FROM $this->table where 1=1 $condition $limit");
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

    public function getOneUser($uid)
    {
        $uid = (int)$uid;
        $row = $this->db->once_fetch_array("select * from $this->table where uid=$uid");

        if (empty($row)) {
            return [];
        }

        $row['username'] = htmlspecialchars($row['username']);
        $row['nickname'] = htmlspecialchars(empty($row['nickname']) ? $row['username'] : $row['nickname']);
        $row['name_orig'] = $row['nickname'];
        $row['email'] = htmlspecialchars($row['email']);
        $row['photo'] = htmlspecialchars($row['photo']);
        $row['description'] = htmlspecialchars($row['description']);
        $row['state'] = (int)$row['state'];
        $row['credits'] = (int)$row['credits'];

        return $row;
    }

    public function updateUser($userData, $uid)
    {
        $uid = (int)$uid;
        $utctimestamp = time();
        $Item = ["update_time=$utctimestamp"];
        foreach ($userData as $key => $data) {
            $Item[] = "$key='$data'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("update $this->table set $upStr where uid=$uid");
    }

    public function updateUserByMail($userData, $mail)
    {
        $timestamp = time();
        $Item = ["update_time=$timestamp"];
        foreach ($userData as $key => $data) {
            $Item[] = "$key='$data'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("update $this->table set $upStr where email='$mail'");
    }

    public function addUser($username, $mail, $password, $role)
    {
        $timestamp = time();
        $nickname = getRandStr(8, false);
        $sql = "insert into $this->table (username,email,password,nickname,role,create_time,update_time) values('$username','$mail','$password','$nickname','$role',$timestamp,$timestamp)";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function deleteUser($uid)
    {
        $uid = (int)$uid;
        $this->db->query("update $this->table_blog set author=1, checked='y' where author=$uid");
        $this->db->query("delete from $this->table where uid=$uid");
    }

    public function forbidUser($uid)
    {
        $uid = (int)$uid;
        $this->db->query("update $this->table set state=1 where uid=$uid");
    }

    public function unforbidUser($uid)
    {
        $uid = (int)$uid;
        $this->db->query("update $this->table set state=0 where uid=$uid");
    }

    /**
     * check the username exists
     *
     * @param string $user_name
     * @param int $uid 兼容更新作者资料时用户名未变更情况
     * @return boolean
     */
    public function isUserExist($user_name, $uid = '')
    {
        $uid = (int)$uid;
        if (empty($user_name)) {
            return false;
        }
        $subSql = $uid ? 'and uid!=' . $uid : '';
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE username='$user_name' $subSql");
        return $data['total'] > 0;
    }

    public function isNicknameExist($nickname, $uid = '')
    {
        if (empty($nickname)) {
            return FALSE;
        }
        $subSql = $uid ? 'and uid!=' . $uid : '';
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE nickname='$nickname' $subSql");
        return $data['total'] > 0;
    }

    public function isMailExist($mail, $uid = '')
    {
        if (empty($mail)) {
            return FALSE;
        }
        $subSql = $uid ? 'and uid!=' . $uid : '';
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE email='$mail' $subSql");
        return $data['total'] > 0;
    }

    public function getUserCount($email = '', $nickname = '')
    {
        $condition = '';
        if ($email) {
            $condition = " and email like '$email%'";
        }
        if ($nickname) {
            $condition = " and nickname like '%$nickname%'";
        }
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table where 1=1 $condition");
        return $data['total'];
    }

    /**
     * 增加用户的积分
     */
    public function addCredits($uid, $count)
    {
        $uid = (int)$uid;
        $count = (int)$count;
        if ($count < 0) {
            $count = 0;
        }
        $this->db->query("UPDATE $this->table SET credits=credits+$count WHERE uid=$uid");
        return true;
    }

    /**
     * 减少用户的积分
     */
    public function reduceCredits($uid, $count)
    {
        $uid = (int)$uid;
        $count = (int)$count;
        if ($count < 0) {
            $count = 0;
        }
        $this->db->query("UPDATE $this->table SET credits = IF(credits >= $count, credits - $count, 0) WHERE uid = $uid");
        return true;
    }
}
