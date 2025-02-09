<?php

/**
 * article and page model
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Log_Model
{

    private $db;
    private $Parsedown;
    private $table;
    private $table_user;
    private $table_sort;
    private $table_comment;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'blog';
        $this->table_user = DB_PREFIX . 'user';
        $this->table_sort = DB_PREFIX . 'sort';
        $this->table_comment = DB_PREFIX . 'comment';
        $this->Parsedown = new Parsedown();
        $this->Parsedown->setBreaksEnabled(true); //automatic line wrapping
    }

    /**
     * create article
     */
    public function addlog($logData)
    {
        $kItem = $dItem = [];
        foreach ($logData as $key => $data) {
            $kItem[] = $key;
            $dItem[] = $data;
        }
        $field = implode(',', $kItem);
        $values = "'" . implode("','", $dItem) . "'";
        $this->db->query("INSERT INTO $this->table ($field) VALUES ($values)");
        return $this->db->insert_id();
    }

    /**
     * update article
     */
    public function updateLog($logData, $blogId, $uid = UID)
    {
        $blogId = (int)$blogId;
        $uid = (int)$uid;
        $author = User::haveEditPermission() ? '' : 'and author=' . $uid;
        $Item = [];
        foreach ($logData as $key => $data) {
            $Item[] = "$key='$data'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("UPDATE $this->table SET $upStr WHERE gid=$blogId $author");
    }

    public function getCount($uid = UID)
    {
        $uid = (int)$uid;
        $sql = sprintf("SELECT count(*) as num FROM $this->table WHERE author=%d AND type='%s'", $uid, 'blog');
        $res = $this->db->once_fetch_array($sql);
        return $res['num'];
    }

    /**
     * Gets the number of articles for the specified condition
     *
     * @param int $spot 0:homepage 1:admin
     * @param string $hide
     * @param string $condition
     * @param string $type
     * @return int
     */
    public function getLogNum($hide = 'n', $condition = '', $type = 'blog', $spot = 0)
    {
        $hide_state = $hide ? "and hide='$hide'" : '';

        if ($spot == 0) {
            $now = time();
            $date_state = "and date<=$now";
            $check_state = "and checked='y'";
            $author = '';
        } else {
            $date_state = '';
            $check_state = '';
            $author = User::haveEditPermission() ? '' : 'and author=' . UID;
        }

        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE type='$type' $date_state $hide_state $check_state $author $condition");
        return $data['total'];
    }

    public function getPostCountByUid($uid, $time = 0)
    {
        $uid = (int)$uid;
        $date = '';
        if ($time) {
            $date = "and date > $time";
        }

        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE type='blog' and author=$uid $date");
        return $data['total'];
    }

    public function getOneLogForAdmin($blogId)
    {
        $blogId = (int)$blogId;
        $author = User::haveEditPermission() ? '' : 'AND author=' . UID;
        $sql = "SELECT * FROM $this->table WHERE gid=$blogId $author";
        $res = $this->db->query($sql);
        if ($this->db->affected_rows() < 1) {
            emMsg('权限不足！', './');
        }
        $row = $this->db->fetch_array($res);
        if ($row) {
            $row['title'] = htmlspecialchars($row['title']);
            $row['content'] = htmlspecialchars($row['content']);
            $row['excerpt'] = htmlspecialchars($row['excerpt']);
            $row['password'] = htmlspecialchars($row['password']);
            $row['template'] = !empty($row['template']) ? htmlspecialchars(trim($row['template'])) : 'page';
            return $row;
        }
        return false;
    }

    /**
     * 获取文章详情.
     *
     * @param int $blogId ID of the article to be retrieved.
     * @return array|false An array of article record, or false if not found.
     */
    public function getDetail($blogId)
    {
        $blogId = (int)$blogId;
        if (empty($blogId)) {
            return false;
        }
        $sql = "SELECT t1.*, t2.sid, t2.sortname, t2.alias as sort_alias FROM $this->table t1 LEFT JOIN $this->table_sort t2 ON t1.sortid=t2.sid WHERE t1.gid=$blogId";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);
        if ($row) {
            $row['fields'] = Field::getFields($blogId);
            return $row;
        }
        return false;
    }

    /**
     * 批量获取文章详情.
     *
     * @param array $blogIds IDs of articles to be retrieved.
     * @return array|false An array of article records, or false if no records are found.
     */
    public function getDetails($blogIds)
    {
        if (empty($blogIds) || !is_array($blogIds)) {
            return false;
        }
        $blogIdsString = implode(',', $blogIds);
        $sql = "SELECT t1.*, t2.sid, t2.sortname, t2.alias as sort_alias FROM $this->table t1 LEFT JOIN $this->table_sort t2 ON t1.sortid=t2.sid WHERE t1.gid IN ($blogIdsString)";
        $res = $this->db->query($sql);
        $rows = array();
        while ($row = $this->db->fetch_array($res)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * 查询所有的子文章.
     *
     * @param int $parentID The ID of the parent to filter logs.
     * @return array|false An array of logs matching the parent ID, or false if the parent ID is invalid.
     */
    public function getLogsByParentID($parentID)
    {
        $parentID = (int)$parentID;
        if (empty($parentID)) {
            return false;
        }
        $sql = "SELECT t1.*, t2.sid, t2.sortname, t2.alias as sort_alias FROM $this->table t1 LEFT JOIN $this->table_sort t2 ON t1.sortid=t2.sid WHERE t1.parent_id=$parentID";
        $res = $this->db->query($sql);
        $rows = array();
        while ($row = $this->db->fetch_array($res)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * get single article
     * @param $blogId
     * @param bool $ignoreHide 忽略隐藏状态
     * @param bool $ignoreChecked 忽略审核状态
     * @return array|false
     */
    public function getOneLogForHome($blogId, $ignoreHide = false, $ignoreChecked = false)
    {
        $blogId = (int)$blogId;
        $hide = $ignoreHide ? "" : "AND hide='n'";
        $checked = $ignoreChecked ? "" : "AND checked='y'";
        $sql = "SELECT * FROM $this->table WHERE gid=$blogId $hide $checked";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);

        if (!$row) {
            return false;
        }

        return [
            'log_title'    => htmlspecialchars($row['title']),
            'timestamp'    => $row['date'],
            'date'         => $row['date'],
            'logid'        => (int)$row['gid'],
            'sortid'       => (int)$row['sortid'],
            'type'         => $row['type'],
            'author'       => $row['author'],
            'log_cover'    => $row['cover'] ? getFileUrl($row['cover']) : '',
            'excerpt'      => $this->Parsedown->text($row['excerpt']),
            'excerpt_raw'  => $row['excerpt'],
            'log_content'  => $this->Parsedown->text($row['content']),
            'content_raw'  => $row['content'],
            'views'        => (int)$row['views'],
            'comnum'       => (int)$row['comnum'],
            'like_count'   => (int)$row['like_count'],
            'top'          => $row['top'],
            'sortop'       => $row['sortop'],
            'hide'         => $row['hide'],
            'checked'      => $row['checked'],
            'attnum'       => (int)$row['attnum'],
            'allow_remark' => Option::get('iscomment') == 'y' ? $row['allow_remark'] : 'n',
            'password'     => $row['password'],
            'template'     => $row['template'],
            'link'         => $row['link'],
            'tags'         => $row['tags'],
            'fields'       => Field::getFields($blogId),
            'parent_id'    => (int)$row['parent_id'],
        ];
    }

    public function getLogsForAdmin($condition = '', $hide_state = '', $page = 1, $type = 'blog', $perpage_num = 20)
    {
        $start_limit = !empty($page) ? ($page - 1) * $perpage_num : 0;
        $author = User::haveEditPermission() ? '' : 'and author=' . UID;
        $hide_state = $hide_state ? "and hide='$hide_state'" : '';
        $limit = "LIMIT $start_limit, " . $perpage_num;
        $sql = "SELECT * FROM $this->table WHERE type='$type' $author $hide_state $condition $limit";
        $res = $this->db->query($sql);
        $logs = [];
        while ($row = $this->db->fetch_array($res)) {
            $row['timestamp'] = $row['date'];
            $row['date'] = date("Y-m-d H:i", $row['date']);
            $row['title'] = !empty($row['title']) ? htmlspecialchars($row['title']) : '无标题';
            $logs[] = $row;
        }
        return $logs;
    }

    public function getLogsForHome($condition = '', $page = 1, $perPageNum = 10)
    {
        $start_limit = !empty($page) ? ($page - 1) * $perPageNum : 0;
        $limit = $perPageNum ? "LIMIT $start_limit, $perPageNum" : '';
        $now = time();
        $sql = "SELECT * FROM $this->table WHERE type='blog' and hide='n' and checked='y' and date<= $now $condition $limit";
        $res = $this->db->query($sql);
        $logs = [];
        while ($row = $this->db->fetch_array($res)) {
            $row['log_title'] = htmlspecialchars(trim($row['title']));
            $row['log_cover'] = $row['cover'] ? getFileUrl($row['cover']) : '';
            $row['log_url'] = Url::log($row['gid']);
            $row['logid'] = $row['gid'];
            $cookiePassword = isset($_COOKIE['em_logpwd_' . $row['gid']]) ? addslashes(trim($_COOKIE['em_logpwd_' . $row['gid']])) : '';
            if (!empty($row['password']) && $cookiePassword != $row['password']) {
                $row['excerpt'] = '<p>[该文章已加密，请点击标题输入密码访问]</p>';
            }

            $row['log_description'] = $this->Parsedown->text(empty($row['excerpt']) ? $row['content'] : $row['excerpt']);
            $row['attachment'] = '';
            $row['tag'] = '';
            $row['tbcount'] = 0;
            $row['fields'] = Field::getFields($row['gid']);
            $logs[] = $row;
        }
        return $logs;
    }

    /**
     * get rss article list
     */
    public function getLogsForRss($perPageNum = 10)
    {
        if ($perPageNum <= 0) {
            return [];
        }
        $now = time();
        $date_state = "and date<=$now";
        $sql = "SELECT *, t1.password as pwd FROM $this->table t1 LEFT JOIN $this->table_user t2 ON t1.author=t2.uid WHERE t1.hide='n' and t1.checked='y' and t1.type='blog' $date_state ORDER BY t1.date DESC limit 0," . $perPageNum;
        $result = $this->db->query($sql);
        $d = [];
        while ($re = $this->db->fetch_array($result)) {
            $re['id'] = $re['gid'];
            $re['title'] = htmlspecialchars($re['title']);
            $re['content'] = $this->Parsedown->text($re['content']);
            if (!empty($re['pwd'])) {
                $re['content'] = '<p>[该文章已设置加密]</p>';
            } elseif (Option::get('rss_output_fulltext') == 'n') {
                if (!empty($re['excerpt'])) {
                    $re['content'] = $re['excerpt'];
                } else {
                    $re['content'] = extractHtmlData($re['content'], 330);
                }
                $re['content'] .= ' <a href="' . Url::log($re['id']) . '">阅读全文&gt;&gt;</a>';
            }
            $d[] = $re;
        }
        return $d;
    }

    /**
     * 获取文章所在页码
     * @param $date
     * @param $pageSize
     * @param $type
     * @return false|float
     */
    public function getPageOffset($date, $type = 'blog')
    {
        $pageSize = Option::get('admin_article_perpage_num');
        if ((int)$pageSize <= 0) {
            return 1;
        }
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE type='$type' AND hide='n' AND (date >= $date OR top = 'y' OR sortop = 'y')");
        $count = $data['total'];
        return ceil($count / $pageSize);
    }

    public function getAllPageList()
    {
        $sql = "SELECT * FROM $this->table WHERE type='page'";
        $res = $this->db->query($sql);
        $pages = [];
        while ($row = $this->db->fetch_array($res)) {
            $row['date'] = date("Y-m-d H:i", $row['date']);
            $row['title'] = !empty($row['title']) ? htmlspecialchars($row['title']) : '无标题';
            $pages[] = $row;
        }
        return $pages;
    }

    public function deleteLog($blogId)
    {
        $blogId = (int)$blogId;
        $this->checkEditable($blogId);
        $detail = $this->getDetail($blogId);
        $author = User::haveEditPermission() ? '' : 'and author=' . UID;
        $this->db->query("DELETE FROM $this->table where gid=$blogId $author");
        if ($this->db->affected_rows() < 1) {
            emMsg('权限不足！', './');
        }
        // comment
        $this->db->query("DELETE FROM $this->table_comment where gid=$blogId");
        // tag
        if (!empty($detail['tags'])) {
            $TagModel = new Tag_Model();
            $tags = explode(',', $detail['tags']);
            foreach ($tags as $tag) {
                $TagModel->removeBlogIdFromTag($tag, $blogId);
            }
        }
    }

    public function hideSwitch($blogId, $state)
    {
        $blogId = (int)$blogId;
        $author = User::haveEditPermission() ? '' : 'and author=' . UID;
        $this->db->query("UPDATE $this->table SET hide='$state' WHERE gid=$blogId $author");
        $this->db->query("UPDATE $this->table_comment SET hide='$state' WHERE gid=$blogId");
        $Comment_Model = new Comment_Model();
        $Comment_Model->updateCommentNum($blogId);
    }

    public function checkSwitch($blogId, $state)
    {
        $blogId = (int)$blogId;
        $this->db->query("UPDATE $this->table SET checked='$state' WHERE gid=$blogId");
        $state = $state == 'y' ? 'n' : 'y';
        $this->db->query("UPDATE $this->table_comment SET hide='$state' WHERE gid=$blogId");
        $Comment_Model = new Comment_Model();
        $Comment_Model->updateCommentNum($blogId);
    }

    public function unCheck($blogId, $feedback)
    {
        $blogId = (int)$blogId;
        $this->db->query("UPDATE $this->table SET checked='n', feedback='$feedback' WHERE gid=$blogId");
        $this->db->query("UPDATE $this->table_comment SET hide='y' WHERE gid=$blogId");
        $Comment_Model = new Comment_Model();
        $Comment_Model->updateCommentNum($blogId);
    }

    public function updateViewCount($blogId)
    {
        $blogId = (int)$blogId;
        $this->db->query("UPDATE $this->table SET views=views+1 WHERE gid=$blogId");
    }

    public function isRepeatPost($title, $time)
    {
        $sql = "SELECT gid FROM $this->table WHERE title='$title' and date='$time' LIMIT 1";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);
        return isset($row['gid']) ? (int)$row['gid'] : false;
    }

    public function neighborLog($date)
    {
        $now = time();
        $date_state = "and date<=$now";
        $neighborlog = [];
        $neighborlog['nextLog'] = $this->db->once_fetch_array("SELECT title,gid FROM $this->table WHERE date < $date and hide = 'n' and checked='y' and type='blog' $date_state ORDER BY date DESC LIMIT 1");
        $neighborlog['prevLog'] = $this->db->once_fetch_array("SELECT title,gid FROM $this->table WHERE date > $date and hide = 'n' and checked='y' and type='blog' $date_state ORDER BY date LIMIT 1");
        if ($neighborlog['nextLog']) {
            $neighborlog['nextLog']['title'] = htmlspecialchars($neighborlog['nextLog']['title']);
        }
        if ($neighborlog['prevLog']) {
            $neighborlog['prevLog']['title'] = htmlspecialchars($neighborlog['prevLog']['title']);
        }
        return $neighborlog;
    }

    public function getRandLog($num)
    {
        global $CACHE;
        $now = time();
        $num = (int)$num;
        $date_state = "and date<=$now";
        $sta_cache = $CACHE->readCache('sta');
        $lognum = $sta_cache['lognum'];
        $start = $lognum > $num ? em_rand(0, $lognum - $num) : 0;
        $sql = "SELECT gid,title FROM $this->table WHERE hide='n' and checked='y' and type='blog' $date_state LIMIT $start, $num";
        $res = $this->db->query($sql);
        $logs = [];
        while ($row = $this->db->fetch_array($res)) {
            $row['gid'] = (int)$row['gid'];
            $row['title'] = htmlspecialchars($row['title']);
            $logs[] = $row;
        }
        return $logs;
    }

    public function getHotLog($num)
    {
        $now = time();
        $num = (int)$num;
        $date_state = "and date<=$now";
        $sql = "SELECT * FROM $this->table WHERE hide='n' and checked='y' and type='blog' $date_state ORDER BY views DESC, comnum DESC LIMIT 0, $num";
        $res = $this->db->query($sql);
        $logs = [];
        while ($row = $this->db->fetch_array($res)) {
            $row['gid'] = (int)$row['gid'];
            $row['title'] = htmlspecialchars($row['title']);
            $row['cover'] = $row['cover'] ? getFileUrl($row['cover']) : '';
            $row['log_url'] = Url::log($row['gid']);
            $logs[] = $row;
        }
        return $logs;
    }

    // 检查文章别名，别名重复则重命名为 xxx-1 格式
    public function checkAlias($alias, $logalias_cache, $logid)
    {
        if (!preg_match('/^[a-zA-Z0-9_\-]+$/', $alias)) {
            return '';
        }
        static $i = 2;
        $key = array_search($alias, $logalias_cache);
        if (false !== $key && $key != $logid) {
            if ($i == 2) {
                $alias .= '-' . $i;
            } else {
                $alias = preg_replace("|(.*)-([\d]+)|", "$1-{$i}", $alias);
            }
            $i++;
            return $this->checkAlias($alias, $logalias_cache, $logid);
        }
        return $alias;
    }

    public function authPassword($postPwd, $cookiePwd, $logPwd, $logid)
    {
        $url = BLOG_URL;
        $pwd = $cookiePwd ?: $postPwd;
        if ($pwd !== addslashes($logPwd)) {
            if (view::isTplExist('pw')) {
                include view::getView('pw');
            } else {
                echo <<<EOT
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer  content=webkit>
<title>请输入文章访问密码</title>
<link rel="stylesheet" type="text/css" href="{$url}admin/views/css/bootstrap.min.css">
</head>
<body class="text-center">
    <form action="" method="post" class="form-signin" style="width: 100%;max-width: 330px;padding: 15px;margin: 0 auto;">
      <input type="password" id="logpwd" name="logpwd" class="form-control" placeholder="请输入文章的访问密码" required autofocus>
      <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">提交</button>
      <p class="mt-5 mb-3 text-muted"><a href="$url">&larr;返回首页</a></p>
    </form>
</body>
</html>
EOT;
            }
            if ($cookiePwd) {
                setcookie('em_logpwd_' . $logid, ' ', time() - 31536000);
            }
            exit;
        }

        setcookie('em_logpwd_' . $logid, $logPwd);
    }

    public function checkEditable($gid)
    {
        if (User::haveEditPermission()) {
            return;
        }
        $r = $this->getOneLogForAdmin($gid);
        if (!$r || !isset($r['checked'])) {
            return;
        }
        if ($r['checked'] === 'y' && Option::get('article_uneditable') === 'y') {
            emMsg('审核通过的文章不可编辑和删除');
        }
    }
}
