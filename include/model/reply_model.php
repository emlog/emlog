<?php

/**
 * reply model
 * 微语评论点赞模型
 *
 * @package EMLOG
 * 
 */

class Reply_Model
{

    private $db;
    private $table;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'reply';
    }

    /**
     * 评论微语
     *
     * @param array $data
     * @return int
     */
    function addReply($data)
    {
        $tid = isset($data['tid']) ? intval($data['tid']) : 0; // 微语ID
        $content = isset($data['content']) ? trim($data['content']) : '';
        $name = isset($data['name']) ? trim($data['name']) : '';
        $uid = isset($data['uid']) ? intval($data['uid']) : 0;
        $ip = isset($data['ip']) ? $data['ip'] : '';
        $hide = isset($data['hide']) ? $data['hide'] : 'n';
        $date = time();

        $content = $this->db->escape_string($content);
        $name = $this->db->escape_string($name);
        $ip = $this->db->escape_string($ip);

        $sql = "INSERT INTO {$this->table} (tid, content, name, uid, date, ip, hide, islike) VALUES ($tid, '$content', '$name', $uid, $date, '$ip', '$hide', 'n')";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    /**
     * 发布微语点赞
     *
     * @param int $tid
     * @param int $uid
     * @param string $ip
     * @return bool
     */
    function addLike($tid, $uid, $ip)
    {
        $tid = intval($tid);
        $uid = intval($uid);
        $ip = $this->db->escape_string($ip);

        // Check if already liked
        $where = '';
        if ($uid > 0) {
            $where = "uid = $uid";
        } else {
            $where = "ip = '$ip' AND uid = 0";
        }

        $sql = "SELECT id FROM {$this->table} WHERE tid = $tid AND islike = 'y' AND $where LIMIT 1";
        $row = $this->db->once_fetch_array($sql);
        if (!empty($row)) {
            return false; // Already liked
        }

        $date = time();
        $sql = "INSERT INTO {$this->table} (tid, content, name, uid, date, ip, hide, islike) VALUES ($tid, '', '', $uid, $date, '$ip', 'n', 'y')";
        $this->db->query($sql);
        return true;
    }

    /**
     * 获取微语评论列表
     *
     * @param int $tid
     * @param int $page
     * @param string $hide 'n' (visible), 'y' (hidden), or 'all'
     * @return array
     */
    function getReplies($tid, $page = 1, $perpage = 10, $hide = 'n')
    {
        $tid = intval($tid);
        $perpage = intval($perpage);

        $start = ($page - 1) * $perpage;

        $andHide = "";
        if ($hide === 'n') {
            $andHide = "AND hide = 'n'";
        } elseif ($hide === 'y') {
            $andHide = "AND hide = 'y'";
        }

        $sql = "SELECT * FROM {$this->table} WHERE tid = $tid AND islike = 'n' $andHide ORDER BY date DESC LIMIT $start, $perpage";
        $ret = $this->db->query($sql);
        $comments = array();
        while ($row = $this->db->fetch_array($ret)) {
            $row['content'] = htmlClean($row['content']);
            $row['name'] = htmlspecialchars($row['name']);
            $comments[] = $row;
        }
        return $comments;
    }

    /**
     * 获取微语点赞列表
     *
     * @param int $tid
     * @return array
     */
    function getLikes($tid)
    {
        $tid = intval($tid);
        $sql = "SELECT * FROM {$this->table} WHERE tid = $tid AND islike = 'y' ORDER BY date DESC";
        $ret = $this->db->query($sql);
        $likes = array();
        while ($row = $this->db->fetch_array($ret)) {
            $likes[] = $row;
        }
        return $likes;
    }

    /**
     * 删除微语评论/点赞
     *
     * @param int $id
     */
    function deleteReply($id)
    {
        $id = intval($id);
        $sql = "DELETE FROM {$this->table} WHERE id = $id";
        $this->db->query($sql);
    }

    /**
     * 审核微语评论 (通过)
     *
     * @param int $id
     */
    function approveReply($id)
    {
        $id = intval($id);
        $sql = "UPDATE {$this->table} SET hide = 'n' WHERE id = $id";
        $this->db->query($sql);
    }

    /**
     * 隐藏微语评论 (不通过)
     *
     * @param int $id
     */
    function hideReply($id)
    {
        $id = intval($id);
        $sql = "UPDATE {$this->table} SET hide = 'y' WHERE id = $id";
        $this->db->query($sql);
    }
}
