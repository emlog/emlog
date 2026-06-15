<?php

/**
 * like model
 * @package EMLOG
 * 
 */

class Like_Model
{
    const VOTE_TYPE_LIKE = 'like';
    const VOTE_TYPE_DISLIKE = 'dislike';
    const VOTE_TYPE_COLLECT = 'collect';

    private $db;
    private $table;
    private $table_blog;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'like';
        $this->table_blog = DB_PREFIX . 'blog';
    }

    /**
     * 获取文章投票列表。
     *
     * @param int $blogId 文章ID
     * @param string $type 投票类型
     * @return array
     */
    function getList($blogId, $type = self::VOTE_TYPE_LIKE)
    {
        $blogId = (int)$blogId;
        $type = $this->normalizeVoteType($type);
        $sql = sprintf(
            "SELECT * FROM `%s` where gid=%d AND vote_type='%s' ORDER BY date DESC",
            $this->table,
            $blogId,
            $type
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
            $likes[] = $row;
        }

        return $likes;
    }

    /**
     * 点赞
     *
     * @param int $uid 用户ID
     * @param string $name 昵称
     * @param string $avatar 头像
     * @param int $blogId 文章ID
     * @param string $ip IP地址
     * @param string $ua User-Agent
     * @return array|false
     */
    function addLike($uid, $name, $avatar, $blogId, $ip, $ua)
    {
        return $this->addVote($uid, $name, $avatar, $blogId, $ip, $ua, self::VOTE_TYPE_LIKE);
    }

    /**
     * 点踩
     *
     * @param int $uid 用户ID
     * @param string $name 昵称
     * @param string $avatar 头像
     * @param int $blogId 文章ID
     * @param string $ip IP地址
     * @param string $ua User-Agent
     * @return array|false
     */
    function addDislike($uid, $name, $avatar, $blogId, $ip, $ua)
    {
        return $this->addVote($uid, $name, $avatar, $blogId, $ip, $ua, self::VOTE_TYPE_DISLIKE);
    }

    /**
     * 收藏
     *
     * @param int $uid 用户ID
     * @param string $name 昵称
     * @param string $avatar 头像
     * @param int $blogId 文章ID
     * @param string $ip IP地址
     * @param string $ua User-Agent
     * @return array|false
     */
    function addCollect($uid, $name, $avatar, $blogId, $ip, $ua)
    {
        $uid = (int)$uid;
        $blogId = (int)$blogId;
        $timestamp = time();
        $type = self::VOTE_TYPE_COLLECT;
        $counterField = $this->getCounterField($type);
        $name = $this->db->escape_string($name);
        $avatar = $this->db->escape_string($avatar);
        $ip = $this->db->escape_string($ip);
        $ua = $this->db->escape_string($ua);

        if ($this->isVoted($blogId, $uid, $ip, $type) === true) {
            return false;
        }

        $sql = "INSERT INTO $this->table (uid,date,poster,gid,vote_type,avatar,ip,agent)
            VALUES ($uid,'$timestamp','$name','$blogId','$type','$avatar','$ip','$ua')";
        $this->db->query($sql);
        $id = $this->db->insert_id();
        $this->db->query("UPDATE {$this->table_blog} SET {$counterField} = {$counterField} + 1 WHERE gid='$blogId'");

        $CACHE = Cache::getInstance();
        $CACHE->updateCache(array('sta'));
        doAction('collect_saved', $blogId, $id);
        return ['id' => $id];
    }

    /**
     * 保存文章投票，并在点赞和点踩之间自动切换。
     *
     * @param int $uid 用户ID
     * @param string $name 昵称
     * @param string $avatar 头像
     * @param int $blogId 文章ID
     * @param string $ip IP地址
     * @param string $ua User-Agent
     * @param string $type 投票类型
     * @return array|false
     */
    function addVote($uid, $name, $avatar, $blogId, $ip, $ua, $type = self::VOTE_TYPE_LIKE)
    {
        $uid = (int)$uid;
        $blogId = (int)$blogId;
        $timestamp = time();
        $type = $this->normalizeVoteType($type);
        $oppositeType = $this->getOppositeVoteType($type);
        $counterField = $this->getCounterField($type);
        $oppositeCounterField = $this->getCounterField($oppositeType);
        $name = $this->db->escape_string($name);
        $avatar = $this->db->escape_string($avatar);
        $ip = $this->db->escape_string($ip);
        $ua = $this->db->escape_string($ua);

        if ($this->isVoted($blogId, $uid, $ip, $type) === true) {
            return false;
        }

        $vote = $this->getVoteRecord($blogId, $uid, $ip);
        if (!empty($vote) && $vote['vote_type'] === $oppositeType) {
            $voteId = (int)$vote['id'];
            $sql = "UPDATE $this->table SET vote_type='$type', poster='$name', avatar='$avatar', agent='$ua', date='$timestamp' WHERE id=$voteId";
            $this->db->query($sql);
            $this->db->query("UPDATE {$this->table_blog} SET {$counterField} = {$counterField} + 1, {$oppositeCounterField} = IF({$oppositeCounterField} > 0, {$oppositeCounterField} - 1, 0) WHERE gid='$blogId'");
            $id = $voteId;
        } else {
            $sql = "INSERT INTO $this->table (uid,date,poster,gid,vote_type,avatar,ip,agent)
                VALUES ($uid,'$timestamp','$name','$blogId','$type','$avatar','$ip','$ua')";
            $this->db->query($sql);
            $id = $this->db->insert_id();
            $this->db->query("UPDATE {$this->table_blog} SET {$counterField} = {$counterField} + 1 WHERE gid='$blogId'");
        }

        $CACHE = Cache::getInstance();
        $CACHE->updateCache(array('sta'));
        doAction($type === self::VOTE_TYPE_DISLIKE ? 'dislike_saved' : 'like_saved', $blogId, $id);
        return ['id' => $id];
    }

    /**
     * 兼容旧版的取消点赞接口。
     *
     * @param int $uid 用户ID
     * @param int $blogId 文章ID
     * @param string $ip IP地址
     * @return bool
     */
    function unLike($uid, $blogId, $ip = '')
    {
        return $this->unVote($uid, $blogId, self::VOTE_TYPE_LIKE, $ip);
    }

    /**
     * 取消点踩投票。
     *
     * @param int $uid 用户ID
     * @param int $blogId 文章ID
     * @param string $ip IP地址
     * @return bool
     */
    function unDislike($uid, $blogId, $ip = '')
    {
        return $this->unVote($uid, $blogId, self::VOTE_TYPE_DISLIKE, $ip);
    }

    /**
     * 取消收藏
     *
     * @param int $uid 用户ID
     * @param int $blogId 文章ID
     * @param string $ip IP地址
     * @return bool
     */
    function unCollect($uid, $blogId, $ip = '')
    {
        return $this->unVote($uid, $blogId, self::VOTE_TYPE_COLLECT, $ip);
    }

    /**
     * 取消指定类型的投票。
     *
     * @param int $uid 用户ID
     * @param int $blogId 文章ID
     * @param string $type 投票类型
     * @param string $ip IP地址
     * @return bool
     */
    function unVote($uid, $blogId, $type = self::VOTE_TYPE_LIKE, $ip = '')
    {
        $uid = (int)$uid;
        $blogId = (int)$blogId;
        $type = $this->normalizeVoteType($type);
        $counterField = $this->getCounterField($type);
        $where = $this->buildVoteWhere($uid, $ip);

        if ($where === '' || $this->isVoted($blogId, $uid, $ip, $type) === false) {
            return false;
        }

        $this->db->query("DELETE FROM $this->table WHERE gid=$blogId AND vote_type='$type' AND $where");
        $sql = "UPDATE {$this->table_blog} SET {$counterField} = IF({$counterField} > 0, {$counterField} - 1, 0) WHERE gid=$blogId";
        $this->db->query($sql);
        $CACHE = Cache::getInstance();
        $CACHE->updateCache(array('sta'));
        doAction($type === self::VOTE_TYPE_DISLIKE ? 'undislike_saved' : ($type === self::VOTE_TYPE_COLLECT ? 'uncollect_saved' : 'unlike_saved'), $blogId, $uid);
        return true;
    }

    /**
     * 判断投票提交是否过快。
     *
     * @return bool
     */
    function isTooFast()
    {
        $ipaddr = getIp();
        $utctimestamp = time() - Option::get('comment_interval');

        $sql = 'select count(*) as num from ' . $this->table . " where date > $utctimestamp AND ip='$ipaddr'";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);

        return (int)$row['num'] > 0;
    }

    /**
     * 兼容旧版的点赞判断接口。
     *
     * @param int $blogId 文章ID
     * @param int $uid 用户ID
     * @param string $ip IP地址
     * @return bool
     */
    function isLiked($blogId, $uid = 0, $ip = '')
    {
        return $this->isVoted($blogId, $uid, $ip, self::VOTE_TYPE_LIKE);
    }

    /**
     * 判断是否已点踩。
     *
     * @param int $blogId 文章ID
     * @param int $uid 用户ID
     * @param string $ip IP地址
     * @return bool
     */
    function isDisliked($blogId, $uid = 0, $ip = '')
    {
        return $this->isVoted($blogId, $uid, $ip, self::VOTE_TYPE_DISLIKE);
    }

    /**
     * 判断是否已收藏。
     *
     * @param int $blogId 文章ID
     * @param int $uid 用户ID
     * @param string $ip IP地址
     * @return bool
     */
    function isCollected($blogId, $uid = 0, $ip = '')
    {
        return $this->isVoted($blogId, $uid, $ip, self::VOTE_TYPE_COLLECT);
    }

    /**
     * 判断是否已投指定类型的票。
     *
     * @param int $blogId 文章ID
     * @param int $uid 用户ID
     * @param string $ip IP地址
     * @param string $type 投票类型
     * @return bool
     */
    function isVoted($blogId, $uid = 0, $ip = '', $type = self::VOTE_TYPE_LIKE)
    {
        $blogId = (int)$blogId;
        $type = $this->normalizeVoteType($type);
        $where = $this->buildVoteWhere($uid, $ip);
        if ($where === '') {
            return false;
        }
        $sql = "SELECT COUNT(*) AS total FROM $this->table WHERE gid=$blogId AND vote_type='$type' AND $where";
        $data = $this->db->once_fetch_array($sql);
        return $data['total'] > 0;
    }

    /**
     * 获取用户头像。
     *
     * @param int $uid 用户ID
     * @param string $avatar 头像地址
     * @return string
     */
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
        return $this->getMyVoted($uid, $page, $perpage, self::VOTE_TYPE_LIKE);
    }

    /**
     * 获取我点踩的文章列表。
     *
     * @param int $uid 用户ID
     * @param int $page 页码
     * @param int $perpage 每页数量
     * @return array
     */
    function getMyDisliked($uid, $page = 1, $perpage = 20)
    {
        return $this->getMyVoted($uid, $page, $perpage, self::VOTE_TYPE_DISLIKE);
    }

    /**
     * 获取我收藏的文章列表。
     *
     * @param int $uid 用户ID
     * @param int $page 页码
     * @param int $perpage 每页数量
     * @return array
     */
    function getMyCollected($uid, $page = 1, $perpage = 20)
    {
        return $this->getMyVoted($uid, $page, $perpage, self::VOTE_TYPE_COLLECT);
    }

    /**
     * 获取我投票的文章列表。
     *
     * @param int $uid 用户ID
     * @param int $page 页码
     * @param int $perpage 每页数量
     * @param string $type 投票类型
     * @return array
     */
    function getMyVoted($uid, $page = 1, $perpage = 20, $type = self::VOTE_TYPE_LIKE)
    {
        $uid = (int)$uid;
        $page = (int)$page;
        $perpage = (int)$perpage;
        $type = $this->normalizeVoteType($type);
        $start = ($page - 1) * $perpage;
        $sql = "SELECT l.date as like_date, l.vote_type, b.* FROM $this->table AS l JOIN $this->table_blog AS b ON l.gid = b.gid WHERE l.uid = $uid AND l.vote_type = '$type' ORDER BY l.date DESC LIMIT $start, $perpage";
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
                'vote_type' => $row['vote_type'],
            );
        }
        return $blogs;
    }

    /**
     * 获取指定文章的投票记录。
     *
     * @param int $blogId 文章ID
     * @param int $uid 用户ID
     * @param string $ip IP地址
     * @return array
     */
    private function getVoteRecord($blogId, $uid, $ip = '')
    {
        $blogId = (int)$blogId;
        $where = $this->buildVoteWhere($uid, $ip);
        if ($where === '') {
            return [];
        }
        $sql = "SELECT * FROM $this->table WHERE gid=$blogId AND $where ORDER BY id DESC LIMIT 1";
        $row = $this->db->once_fetch_array($sql);
        return $row ?: [];
    }

    /**
     * 构建投票用户匹配条件。
     *
     * @param int $uid 用户ID
     * @param string $ip IP地址
     * @return string
     */
    private function buildVoteWhere($uid, $ip = '')
    {
        $uid = (int)$uid;
        if ($uid > 0) {
            return "uid=$uid";
        }
        $ip = $this->db->escape_string($ip);
        if ($ip !== '') {
            return "ip='$ip' AND uid=0";
        }
        return '';
    }

    /**
     * 规范化投票类型。
     *
     * @param string $type 投票类型
     * @return string
     */
    private function normalizeVoteType($type)
    {
        if ($type === self::VOTE_TYPE_DISLIKE) {
            return self::VOTE_TYPE_DISLIKE;
        }
        if ($type === self::VOTE_TYPE_COLLECT) {
            return self::VOTE_TYPE_COLLECT;
        }
        return self::VOTE_TYPE_LIKE;
    }

    /**
     * 获取相反的投票类型。
     *
     * @param string $type 投票类型
     * @return string
     */
    private function getOppositeVoteType($type)
    {
        return $type === self::VOTE_TYPE_DISLIKE ? self::VOTE_TYPE_LIKE : self::VOTE_TYPE_DISLIKE;
    }

    /**
     * 获取投票类型对应的聚合计数字段。
     *
     * @param string $type 投票类型
     * @return string
     */
    private function getCounterField($type)
    {
        if ($type === self::VOTE_TYPE_DISLIKE) {
            return 'dislike_count';
        }
        if ($type === self::VOTE_TYPE_COLLECT) {
            return 'collect_count';
        }
        return 'like_count';
    }
}
