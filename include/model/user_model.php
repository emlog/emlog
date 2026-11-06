<?php

/**
 * user model
 * @package EMLOG
 * 
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

    /**
     * 获取用户列表
     *
     * @param string $email 邮箱
     * @param string $nickname 昵称
     * @param string $order 排序规则
     * @param int $page 页码
     * @param int $perpage_num 每页数量
     * @return array 用户列表数组
     */
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
            case 'forbid':
                $condition .= " ORDER BY state DESC";
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
            $row['create_time'] = date("Y-m-d H:i", $row['create_time']);
            $row['update_time'] = smartDate($row['update_time']);
            $row['role_raw'] = $row['role'];
            $row['em_phone'] = isset($row['em_phone']) ? htmlspecialchars($row['em_phone']) : '';
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
        $row['name_orig'] = $row['nickname'];
        $row['nickname'] = htmlspecialchars(empty($row['nickname']) ? $row['username'] : $row['nickname']);
        $row['email'] = htmlspecialchars($row['email']);
        $row['em_phone'] = isset($row['em_phone']) ? htmlspecialchars($row['em_phone']) : '';
        $row['photo'] = htmlspecialchars($row['photo']);
        $row['description_orig'] = $row['description'];
        $row['description'] = htmlspecialchars($row['description']);
        $row['state'] = (int)$row['state'];
        $row['credits'] = (int)$row['credits'];

        return $row;
    }

    /**
     * 根据用户名、邮箱或手机号获取用户信息
     */
    public function getUserDataByLogin($account)
    {
        if (empty($account)) {
            return false;
        }
        $account = $this->db->escape_string($account);
        $ret = $this->db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "user WHERE username = '$account'");
        if (!$ret) {
            $ret = $this->db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "user WHERE email = '$account'");
            if (!$ret) {
                $ret = $this->db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "user WHERE em_phone = '$account'");
                if (!$ret) {
                    return false;
                }
            }
        }
        $userData['nickname'] = htmlspecialchars($ret['nickname']);
        $userData['username'] = htmlspecialchars($ret['username']);
        $userData['password'] = $ret['password'];
        $userData['uid'] = $ret['uid'];
        $userData['role'] = $ret['role'];
        $userData['photo'] = $ret['photo'];
        $userData['email'] = $ret['email'];
        $userData['em_phone'] = isset($ret['em_phone']) ? htmlspecialchars($ret['em_phone']) : '';
        $userData['description'] = $ret['description'];
        $userData['ip'] = $ret['ip'];
        $userData['credits'] = (int)$ret['credits'];
        $userData['create_time'] = $ret['create_time'];
        $userData['update_time'] = $ret['update_time'];
        $userData['state'] = (int)$ret['state'];
        return $userData;
    }

    /**
     * 根据手机号获取用户信息
     *
     * @param string $phone 手机号码
     * @return array|false 用户信息或 false
     */
    public function getUserDataByPhone($phone)
    {
        if (empty($phone)) {
            return false;
        }
        $phone = $this->db->escape_string(trim($phone));
        $ret = $this->db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "user WHERE em_phone = '$phone'");
        if (!$ret) {
            return false;
        }
        $userData = [];
        $userData['nickname'] = htmlspecialchars($ret['nickname']);
        $userData['username'] = htmlspecialchars($ret['username']);
        $userData['password'] = $ret['password'];
        $userData['uid'] = $ret['uid'];
        $userData['role'] = $ret['role'];
        $userData['photo'] = $ret['photo'];
        $userData['email'] = $ret['email'];
        $userData['em_phone'] = isset($ret['em_phone']) ? htmlspecialchars($ret['em_phone']) : '';
        $userData['description'] = $ret['description'];
        $userData['ip'] = $ret['ip'];
        $userData['credits'] = (int)$ret['credits'];
        $userData['create_time'] = $ret['create_time'];
        $userData['update_time'] = $ret['update_time'];
        $userData['state'] = (int)$ret['state'];
        return $userData;
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

    /**
     * 根据手机号更新用户信息
     *
     * @param array $userData 用户数据
     * @param string $phone 手机号码
     * @return void
     */
    public function updateUserByPhone($userData, $phone)
    {
        $phone = $this->db->escape_string(trim($phone));
        $timestamp = time();
        $Item = ["update_time=$timestamp"];
        foreach ($userData as $key => $data) {
            $Item[] = "$key='$data'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("update $this->table set $upStr where em_phone='$phone'");
    }

    /**
     * 添加用户
     *
     * @param string $username 用户名
     * @param string $mail 邮箱
     * @param string $password 密码
     * @param string $role 角色
     * @param string $phone 手机号码
     * @return int 新增用户的UID
     */
    public function addUser($username, $mail, $password, $role, $phone = '')
    {
        $timestamp = time();
        $nickname = getRandStr(8, false);
        $phone = $this->db->escape_string(trim($phone));
        $sql = "insert into $this->table (username,email,password,nickname,role,em_phone,create_time,update_time) values('$username','$mail','$password','$nickname','$role','$phone',$timestamp,$timestamp)";
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

    /**
     * 检查手机号是否已被占用
     *
     * @param string $phone 手机号码
     * @param int $uid 排除的UID
     * @return bool
     */
    public function isPhoneExist($phone, $uid = '')
    {
        $phone = trim($phone);
        if (empty($phone)) {
            return false;
        }
        $phone = $this->db->escape_string($phone);
        $uid = (int)$uid;
        $subSql = $uid ? 'and uid!=' . $uid : '';
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE em_phone='$phone' $subSql");
        return isset($data['total']) && $data['total'] > 0;
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

    public function updateUserActivityTime($uid)
    {
        $uid = (int)$uid;
        $timestamp = time();
        $this->db->query("UPDATE $this->table SET update_time=$timestamp WHERE uid=$uid");
    }
}
