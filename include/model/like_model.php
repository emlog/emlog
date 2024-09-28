<?php

/**
 * like model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Like_Model
{

    private $db;
    private $table;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'like';
        $this->table_blog = DB_PREFIX . 'blog';
    }

    function getList($blogId)
    {
        $blogId = (int)$blogId;
        $sql = sprintf(
            "SELECT * FROM `%s` where gid=%d ORDER BY date DESC",
            $this->table,
            $blogId
        );

        $ret = $this->db->query($sql);
        $likes = [];
        while ($row = $this->db->fetch_array($ret)) {
            $row['id'] = (int)$row['id'];
            $row['gid'] = (int)$row['gid'];
            $row['uid'] = (int)$row['uid'];
            $row['poster'] = htmlspecialchars($row['poster']);
            $row['avatar'] = $this->getAvatar($row['uid'], $row['avatar']);
            $row['date'] = smartDate($row['date']);
            $row['ip'] = $row['ip'];
            $likes[] = $row;
        }

        return $likes;
    }
    function addLike($uid, $name, $avatar, $blogId, $ip, $ua)
    {
        $timestamp = time();
        $ua = addslashes($ua);

        $sql = "INSERT INTO $this->table (uid,date,poster,gid,avatar,ip,agent)
                VALUES ($uid,'$timestamp','$name','$blogId','$avatar','$ip','$ua')";
        $this->db->query($sql);
        $id = $this->db->insert_id();

        $this->db->query('UPDATE ' . $this->table_blog . " SET like_count = like_count + 1 WHERE gid='$blogId'");
        $CACHE = Cache::getInstance();
        $CACHE->updateCache(array('sta'));
        doAction('like_saved', $blogId, $id);
        return ['id' => $id];
    }

    function isTooFast()
    {
        $ipaddr = getIp();
        $utctimestamp = time() - Option::get('comment_interval');

        $sql = 'select count(*) as num from ' . $this->table . " where date > $utctimestamp AND ip='$ipaddr'";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);

        return (int)$row['num'] > 0;
    }

    function isLiked($blogId, $uid = 0, $ip = '')
    {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "like WHERE gid=$blogId";
        if ($uid) {
            $sql .= " AND uid=$uid";
        } else {
            $sql .= " AND ip='$ip'";
        }
        $data = $this->db->once_fetch_array($sql);
        return $data['total'] > 0;
    }

    function getAvatar($uid, $avatar = '')
    {
        if ($avatar) {
            return $avatar;
        }
        if ($uid) {
            $userModel = new User_Model();
            $user = $userModel->getOneUser($uid);
            $avatar = getFileUrl($user['photo']);
        }
        return $avatar ?: BLOG_URL . "admin/views/images/avatar.svg";
    }
}
