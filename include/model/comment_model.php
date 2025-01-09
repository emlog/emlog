<?php

/**
 * commment model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Comment_Model
{

    private $db;
    private $table;
    private $table_blog;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'comment';
        $this->table_blog = DB_PREFIX . 'blog';
    }

    /**
     * get comment list
     */
    function getComments($blogId = null, $hide = null, $page = null)
    {
        $andQuery = '1=1';
        $andQuery .= $blogId ? " and a.gid=$blogId" : '';
        $andQuery .= $hide ? " and a.hide='$hide'" : '';
        $condition = '';

        $sql = "SELECT * FROM $this->table as a where $andQuery ORDER BY a.top ASC, a.date ASC $condition";

        $ret = $this->db->query($sql);
        $comments = [];
        while ($row = $this->db->fetch_array($ret)) {
            $row['poster'] = htmlspecialchars($row['poster']);
            $row['mail'] = htmlspecialchars($row['mail']);
            $row['url'] = htmlspecialchars($row['url']);
            $row['content'] = htmlClean($row['comment']);
            $row['date'] = smartDate($row['date']);
            $row['children'] = [];
            $row['level'] = isset($comments[$row['pid']]) ? $comments[$row['pid']]['level'] + 1 : 0;
            $comments[$row['cid']] = $row;
        }

        $commentStacks = [];
        $commentPageUrl = '';
        foreach ($comments as $cid => $comment) {
            $pid = $comment['pid'];
            if ($pid == 0) {
                $commentStacks[] = $cid;
            }
            if ($pid != 0 && isset($comments[$pid])) {
                if ($comments[$cid]['level'] > 4) {
                    $comments[$cid]['pid'] = $pid = $comments[$pid]['pid'];
                }
                $comments[$pid]['children'][] = $cid;
            }
        }
        if (Option::get('comment_order') == 'newer') {
            $comments = array_reverse($comments, true);
            $commentStacks = array_reverse($commentStacks);
        }
        if (Option::get('comment_paging') == 'y') {
            $pageurl = Url::log($blogId);
            if (Option::get('isurlrewrite') == 0 && strpos($pageurl, '=') !== false) {
                $pageurl .= '&comment-page=';
            } else {
                $pageurl .= '/comment-page-';
            }
            $commentPageUrl = pagination(count($commentStacks), Option::get('comment_pnum'), $page, $pageurl, '#comments');
            $commentStacks = array_slice($commentStacks, ($page - 1) * Option::get('comment_pnum'), Option::get('comment_pnum'));
        }
        $comments = compact('comments', 'commentStacks', 'commentPageUrl');

        return $comments;
    }

    function getCommentListForApi($blogId = null, $hide = null)
    {
        $andQuery = '1=1';
        $andQuery .= $blogId ? " and a.gid=$blogId" : '';
        $andQuery .= $hide ? " and a.hide='$hide'" : '';
        $condition = '';

        $sql = "SELECT * FROM $this->table as a where $andQuery ORDER BY a.top ASC, a.date ASC $condition";

        $ret = $this->db->query($sql);
        $comments = [];
        while ($row = $this->db->fetch_array($ret)) {
            $comments[$row['cid']] = [
                'cid' => (int)$row['cid'],
                'gid' => (int)$row['gid'],
                'pid' => (int)$row['pid'],
                'uid' => (int)$row['uid'],
                'top' => $row['top'],
                'poster' => htmlspecialchars($row['poster']),
                'avatar' => $this->getAvatar($row['uid'], $row['mail'], $row['avatar']),
                'url' => htmlspecialchars($row['url']),
                'content' => htmlClean($row['comment']),
                'date' => smartDate($row['date']),
            ];
        }
        foreach ($comments as $cid => $comment) {
            $pid = $comment['pid'];
            if ($pid != 0 && isset($comments[$pid])) {
                $comments[$pid]['children'][] = &$comments[$cid];
            }
        }

        $commentList = [];
        foreach ($comments as $comment) {
            if ($comment['pid'] == 0) {
                $commentList[] = $comment;
            }
        }

        return $commentList;
    }

    /**
     * get comment list for admin
     */
    function getCommentsForAdmin($blogId = null, $uid = null, $hide = null, $page = null, $per_page_num = 20)
    {
        $orderBy = $blogId ? "ORDER BY a.top DESC, a.date DESC" : 'ORDER BY a.date DESC';
        $andQuery = '1=1';
        $andQuery .= $blogId ? " and a.gid=$blogId" : '';
        $andQuery .= $uid ? " and a.uid=$uid" : '';
        $andQuery .= $hide ? " and a.hide='$hide'" : '';
        $condition = '';
        if ($page) {
            if ($page > PHP_INT_MAX) {
                $page = PHP_INT_MAX;
            }
            $startId = ($page - 1) * $per_page_num;
            $condition = "LIMIT $startId, " . $per_page_num;
        }

        $andQuery .= !User::haveEditPermission() ? ' and b.author=' . UID : '';
        $sql = "SELECT *,a.hide,a.date,a.top FROM $this->table as a, $this->table_blog as b where $andQuery and a.gid=b.gid $orderBy $condition";

        $ret = $this->db->query($sql);
        $comments = [];
        while ($row = $this->db->fetch_array($ret)) {
            $row['poster'] = htmlspecialchars($row['poster']);
            $row['mail'] = htmlspecialchars($row['mail']);
            $row['url'] = htmlspecialchars($row['url']);
            $row['comment'] = htmlClean($row['comment']);
            $row['date'] = smartDate($row['date']);
            $row['os'] = get_os($row['agent']);
            $row['browse'] = get_browse($row['agent']);
            $row['children'] = [];
            $comments[$row['cid']] = $row;
        }

        return $comments;
    }

    function getOneComment($commentId, $nl2br = false)
    {
        $sql = "select * from $this->table where cid=$commentId";
        $res = $this->db->query($sql);
        if ($this->db->affected_rows() < 1) {
            return false;
        }
        $comment = $this->db->fetch_array($res);
        $comment['comment'] = $nl2br ? htmlClean(trim($comment['comment'])) : htmlClean(trim($comment['comment']), FALSE);
        $comment['poster'] = htmlspecialchars($comment['poster']);
        $comment['date'] = date("Y-m-d H:i", $comment['date']);
        return $comment;
    }

    function getCommentNum($blogId = null, $uid = null, $hide = null)
    {
        $andQuery = '1=1';
        $andQuery .= $blogId ? " and a.gid=$blogId" : '';
        $andQuery .= $uid ? " and a.uid=$uid" : '';
        $andQuery .= $hide ? " and a.hide='$hide'" : '';
        if (User::haveEditPermission()) {
            $sql = "SELECT count(*) FROM $this->table as a where $andQuery";
        } else {
            $sql = "SELECT count(*) FROM $this->table as a, $this->table_blog as b where $andQuery and a.gid=b.gid and b.author=" . UID;
        }
        $res = $this->db->once_fetch_array($sql);
        return $res['count(*)'];
    }

    function delComment($commentId)
    {
        $this->isYoursComment($commentId);
        $row = $this->db->once_fetch_array("SELECT gid FROM $this->table WHERE cid=$commentId");
        $blogId = (int)$row['gid'];
        $commentIds = array($commentId);

        $query = $this->db->query("SELECT cid,pid FROM $this->table WHERE gid=$blogId AND cid>$commentId ");
        while ($row = $this->db->fetch_array($query)) {
            if (in_array($row['pid'], $commentIds)) {
                $commentIds[] = $row['cid'];
            }
        }
        $commentIds = implode(',', $commentIds);
        $this->db->query("DELETE FROM $this->table WHERE cid IN ($commentIds)");
        $this->updateCommentNum($blogId);
    }

    function delCommentByIp($ip)
    {
        $blogids = [];
        $sql = "SELECT DISTINCT gid FROM $this->table WHERE ip='$ip'";
        $query = $this->db->query($sql);
        while ($row = $this->db->fetch_array($query)) {
            $blogids[] = $row['gid'];
        }
        $this->db->query("DELETE FROM $this->table WHERE ip='$ip'");
        $this->updateCommentNum($blogids);
    }

    function hideComment($commentId)
    {
        $this->isYoursComment($commentId);
        $row = $this->db->once_fetch_array("SELECT gid FROM $this->table WHERE cid=$commentId");
        $blogId = (int)$row['gid'];
        $commentIds = array($commentId);
        /* 获取子评论ID */
        $query = $this->db->query("SELECT cid,pid FROM $this->table WHERE gid=$blogId AND cid>$commentId ");
        while ($row = $this->db->fetch_array($query)) {
            if (in_array($row['pid'], $commentIds)) {
                $commentIds[] = $row['cid'];
            }
        }
        $commentIds = implode(',', $commentIds);
        $this->db->query("UPDATE $this->table SET hide='y' WHERE cid IN ($commentIds)");
        $this->updateCommentNum($blogId);
    }

    function showComment($commentId)
    {
        $this->isYoursComment($commentId);
        $row = $this->db->once_fetch_array("SELECT gid,pid FROM $this->table WHERE cid=$commentId");
        $blogId = (int)$row['gid'];
        $commentIds = array($commentId);

        while ($row['pid'] != 0) {
            $commentId = (int)$row['pid'];
            $commentIds[] = $commentId;
            $row = $this->db->once_fetch_array("SELECT pid FROM $this->table WHERE cid=$commentId");
        }
        $commentIds = implode(',', $commentIds);
        $this->db->query("UPDATE $this->table SET hide='n' WHERE cid IN ($commentIds)");
        $this->updateCommentNum($blogId);
    }

    function topComment($commentId, $top = 'y')
    {
        $this->isYoursComment($commentId);
        $commentIds = array($commentId);
        $commentIds = implode(',', $commentIds);
        $this->db->query("UPDATE $this->table SET top='$top' WHERE cid IN ($commentIds)");
    }

    function replyComment($blogId, $pid, $content, $hide)
    {
        $User_Model = new User_Model();
        $user_info = $User_Model->getOneUser(UID);

        if (empty($user_info) || !$blogId) {
            return false;
        }

        $name = addslashes($user_info['name_orig']);

        $uid = UID;
        $ipaddr = getIp();
        $timestamp = time();
        $useragent = addslashes(getUA());
        $this->db->query("INSERT INTO $this->table (date,poster,uid,gid,comment,mail,url,hide,ip,agent,pid)
                    VALUES ('$timestamp','$name',$uid,$blogId,'$content','','','$hide','$ipaddr','$useragent',$pid)");
        $this->updateCommentNum($blogId);
    }

    function batchComment($action, $comments)
    {
        switch ($action) {
            case 'delcom':
                foreach ($comments as $val) {
                    $this->delComment($val);
                }
                break;
            case 'hidecom':
                foreach ($comments as $val) {
                    $this->hideComment($val);
                }
                break;
            case 'showcom':
                foreach ($comments as $val) {
                    $this->showComment($val);
                }
                break;
            case 'top':
                foreach ($comments as $val) {
                    $this->topComment($val);
                }
                break;
            case 'untop':
                foreach ($comments as $val) {
                    $this->topComment($val, 'n');
                }
                break;
        }
    }

    function updateCommentNum($blogId)
    {
        if (is_array($blogId)) {
            foreach ($blogId as $val) {
                $this->updateCommentNum($val);
            }
        } else {
            $sql = "SELECT count(*) FROM $this->table WHERE gid=$blogId AND hide='n'";
            $res = $this->db->once_fetch_array($sql);
            $comNum = $res['count(*)'];
            $this->db->query("UPDATE $this->table_blog SET comnum=$comNum WHERE gid=$blogId");
            return $comNum;
        }
    }

    function addComment($uid, $name, $content, $mail, $url, $avatar, $blogId, $pid)
    {
        $ipaddr = getIp();
        $timestamp = time();
        $useragent = addslashes(getUA());

        if ($pid > 0) {
            $comment = $this->getOneComment($pid);
            $content = '@' . addslashes($comment['poster']) . '：' . $content;
        }

        $hide = Option::get('ischkcomment') == 'y' && !User::haveEditPermission() ? 'y' : 'n';

        $sql = "INSERT INTO $this->table (uid,date,poster,gid,comment,mail,url,avatar,hide,ip,agent,pid)
                VALUES ($uid,'$timestamp','$name','$blogId','$content','$mail','$url','$avatar','$hide','$ipaddr','$useragent','$pid')";
        $this->db->query($sql);
        $cid = $this->db->insert_id();
        $CACHE = Cache::getInstance();

        if ($hide === 'n') {
            $this->db->query("UPDATE $this->table_blog SET comnum = comnum + 1 WHERE gid='$blogId'");
            $CACHE->updateCache(array('sta', 'comment'));
            doAction('comment_saved', $cid);
            return ['cid' => $cid, 'hide' => 'n'];
        }
        $CACHE->updateCache('sta');
        doAction('comment_saved', $cid);
        return ['cid' => $cid, 'hide' => 'y'];
    }

    function isCommentExist($blogId, $name, $content)
    {
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE gid=$blogId AND poster='$name' AND comment='$content'");
        return $data['total'] > 0;
    }

    function isYoursComment($cid)
    {
        if (User::haveEditPermission() || User::isVisitor()) {
            return true;
        }
        $query = $this->db->query("SELECT a.cid FROM $this->table as a,$this->table_blog as b WHERE a.cid=$cid and a.gid=b.gid AND b.author=" . UID);
        $result = $this->db->num_rows($query);
        if ($result <= 0) {
            emMsg('权限不足！', './');
        }
    }

    function isCommentTooFast()
    {
        $ipaddr = getIp();
        $utctimestamp = time() - Option::get('comment_interval');

        $sql = "select count(*) as num from $this->table where date > $utctimestamp AND ip='$ipaddr'";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);

        return (int)$row['num'] > 0;
    }

    function hasCommented($blogId, $uid)
    {
        $ipaddr = getIp();

        $sql = "SELECT COUNT(*) as num FROM $this->table WHERE gid = $blogId AND (uid = $uid OR ip = '$ipaddr')";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);

        return (int)$row['num'] > 0;
    }

    function setCommentCookie($name, $mail, $url)
    {
        $cookietime = time() + 31536000;
        setcookie('commentposter', $name, $cookietime);
        setcookie('postermail', $mail, $cookietime);
        setcookie('posterurl', $url, $cookietime);
    }

    function getAvatar($uid, $mail, $avatar = '')
    {
        if ($avatar) {
            return $avatar;
        }
        if ($uid) {
            $userModel = new User_Model();
            $user = $userModel->getOneUser($uid);
            $avatar = getFileUrl($user['photo']);
        } elseif ($mail) {
            $avatar = getGravatar($mail);
        }
        return $avatar ?: BLOG_URL . "admin/views/images/avatar.svg";
    }
}
