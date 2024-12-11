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
        $uid = (int)$uid;
        $blogId = (int)$blogId;
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

    function unLike($uid, $blogId)
    {
        $uid = (int)$uid;
        $blogId = (int)$blogId;

        if ($this->isLiked($blogId, $uid) === false) {
            return false;
        }

        $this->db->query("DELETE FROM $this->table WHERE uid=$uid AND gid=$blogId");
        $sql = "UPDATE " . $this->table_blog . " SET like_count = IF(like_count > 0, like_count - 1, 0) WHERE gid=$blogId";
        $this->db->query($sql);
        $CACHE = Cache::getInstance();
        $CACHE->updateCache(array('sta'));
        doAction('unlike_saved', $blogId, $uid);
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
        $sql = "SELECT COUNT(*) AS total FROM $this->table WHERE gid=$blogId";
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

    /**
     * 获取我点赞的文章列表
     *
     * @param int $page
     * @param int $perpage
     * @return array
     */
    function getMyLiked($uid, $page = 1, $perpage = 20)
    {
        $uid = (int)$uid;
        $page = (int)$page;
        $perpage = (int)$perpage;
        $start = ($page - 1) * $perpage;
        $sql = "SELECT l.date as like_date,b.* FROM $this->table AS l JOIN $this->table_blog AS b ON l.gid = b.gid WHERE l.uid = $uid ORDER BY l.date DESC LIMIT $start, $perpage";
        $ret = $this->db->query($sql);
        $blogs = [];
        while ($row = $this->db->fetch_array($ret)) {
            $blogs[] = array(
                'gid' => $row['gid'],
                'title' => $row['title'],
                'cover' => $row['cover'],
                'author' => $row['author'],
                'sortid' => $row['sortid'],
                'date' => $row['date'],
                'like_date' => $row['like_date'],
            );
        }
        return $blogs;
    }
}
