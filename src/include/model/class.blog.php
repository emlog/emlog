<?php
/**
 * 日志、页面管理
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id: class.blog.php 1781 2010-10-14 09:04:55Z emloog $
 */

class emBlog {
	/**
	 * 内部数据对象
	 * @var MySql
	 */
	private $db;

	function __construct() {
		$this->db = MySql::getInstance();
	}

	/**
	 * 前台日志列表页面输出
	 */
	function displayBlog($params) {
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		extract($options_cache);
	    $navibar = unserialize($navibar);
        $curpage = CURPAGE_HOME;
        $blogtitle = $blogname;

    	if (isset($params[1]) && $params[1] == 'page') {
    		$page = abs(intval($params[2]));
    	} elseif(isset($params[4]) && $params[4] == 'page') {
    		$page = abs(intval($params[5]));
    	} else{
    		$page = 1;
    	}

    	$record = isset($params[1]) && $params[1] == 'record' ? intval($params[2]) : '' ;
    	$sortid = isset($params[1]) && $params[1] == 'sort' ? intval($params[2]) : '' ;
    	$author = isset($params[1]) && $params[1] == 'author' ? intval($params[2]) : '' ;
    	$tag = isset($params[1]) && $params[1] == 'tag' ? addslashes(urldecode(trim($params[2]))) : '';
    	$keyword = isset($params[1]) && $params[1] == 'keyword' ? addslashes(urldecode(trim($params[2]))) : '';

    	$start_limit = ($page - 1) * $index_lognum;
    	$pageurl = '';

    	if ($record) {
    		$blogtitle = $record.' - '.$blogname;
    		if (preg_match("/^([\d]{4})([\d]{2})$/", $record, $match)) {
    		    $days = getMonthDayNum($match[2], $match[1]);
    		    $record_stime = emStrtotime($record . '01');
    		    $record_etime = $record_stime + 3600 * 24 * $days;
    		} else {
    		    $record_stime = emStrtotime($record);
    		    $record_etime = $record_stime + 3600 * 24;
    		}
    		$sqlSegment = "and date>=$record_stime and date<$record_etime order by top desc ,date desc";
    		$lognum = $this->getLogNum('n', $sqlSegment);
    		$pageurl .= Url::record($record, 'page');
    	} elseif ($tag) {
    		$emTag = new emTag();
    		$blogtitle = stripslashes($tag).' - '.$blogname;
    		$blogIdStr = $emTag->getTagByName($tag);
    		if ($blogIdStr === false) {
    			emMsg('不存在该标签', BLOG_URL);
    		}
    		$sqlSegment = "and gid IN ($blogIdStr) order by date desc";
    		$lognum = $this->getLogNum('n', $sqlSegment);
    		$pageurl .= Url::tag(urlencode($tag), 'page');
    	} elseif ($keyword) {
            $keyword = str_replace('%','\%',$keyword);
            $keyword = str_replace('_','\_',$keyword);
    		$sqlSegment = "and title like '%{$keyword}%' order by date desc";
    		$lognum = $this->getLogNum('n', $sqlSegment);
    		$pageurl .= BLOG_URL.'?keyword='.urlencode($keyword).'&page';
    	} elseif ($sortid) {
    		$sort_cache = $CACHE->readCache('sort');
    	    if (!isset($sort_cache[$sortid])) {
                emMsg('不存在该分类', BLOG_URL);
            }
    		$sortName = $sort_cache[$sortid]['sortname'];
    		$blogtitle = $sortName.' - '.$blogname;
    		$sqlSegment = "and sortid=$sortid order by date desc";
    		$lognum = $this->getLogNum('n', $sqlSegment);
    		$pageurl .= Url::sort($sortid, 'page');
    	} elseif ($author) {
    		$user_cache = $CACHE->readCache('user');
    	    if (!isset($user_cache[$author])) {
                emMsg('不存在该作者', BLOG_URL);
            }
    		$blogtitle = $user_cache[$author]['name'].' - '.$blogname;
    		$sqlSegment = "and author=$author order by date desc";
    		$sta_cache = $CACHE->readCache('sta');
    		$lognum = $sta_cache[$author]['lognum'];
    		$pageurl .= Url::author($author, 'page');
    	}else {
    		$sqlSegment ='ORDER BY top DESC ,date DESC';
    		$sta_cache = $CACHE->readCache('sta');
    		$lognum = $sta_cache['lognum'];
    		$pageurl .= Url::logPage();
    	}
    	$logs = $this->getLogsForHome($sqlSegment, $page, $index_lognum);
    	$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

        include View::getView('header');
    	include View::getView('log_list');
	}

	/**
	 * 前台日志内容页面输出
	 */
	function displayContent($params) {
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');
        extract($options_cache);
        $navibar = unserialize($navibar);

	    $logid = isset($params[1]) && $params[1] == 'post' ? intval($params[2]) : '' ;
    
    	$emComment = new emComment();
    	$emTrackback = new emTrackback();
    
    	$logData = $this->getOneLogForHome($logid);
    	if ($logData === false) {
    		emMsg('不存在该条目', BLOG_URL);
    	}
    	extract($logData);
  
    	if (!empty($password)) {
    		$postpwd = isset($_POST['logpwd']) ? addslashes(trim($_POST['logpwd'])) : '';
    		$cookiepwd = isset($_COOKIE['em_logpwd_'.$logid]) ? addslashes(trim($_COOKIE['em_logpwd_'.$logid])) : '';
    		$this->AuthPassword($postpwd, $cookiepwd, $password, $logid);
    	}
    	$blogtitle = $log_title.' - '.$blogname;
	    //comments
	    $verifyCode = $comment_code == 'y' ? "<img src=\"".BLOG_URL."include/lib/checkcode.php\" align=\"absmiddle\" /><input name=\"imgcode\"  type=\"text\" class=\"input\" size=\"5\">" : '';
	    $ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
	    $ckmail = isset($_COOKIE['postermail']) ? $_COOKIE['postermail'] : '';
	    $ckurl = isset($_COOKIE['posterurl']) ? $_COOKIE['posterurl'] : '';
	    $comments = $emComment->getComments(0, $logid, 'n');

    	$curpage = CURPAGE_LOG;
    	include View::getView('header');
    	if ($type == 'blog') {
    		$this->updateViewCount($logid);
    		$neighborLog = $this->neighborLog($timestamp);
    		$tb = $emTrackback->getTrackbacks(null, $logid, 0);
    		$tb_url = BLOG_URL . 'tb.php?sc=' . $tbscode . '&id=' . $logid; 
    		require_once View::getView('echo_log');
    	}elseif ($type == 'page') {
    		include View::getView('page');
    	}
	}

	/**
	 * 添加日志、页面
	 *
	 * @param array $logData
	 * @return int
	 */
	function addlog($logData) {
		$kItem = array();
		$dItem = array();
		foreach ($logData as $key => $data) {
			$kItem[] = $key;
			$dItem[] = $data;
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog ($field) VALUES ($values)");
		$logid = $this->db->insert_id();
		return $logid;
	}

	/**
	 * 更新日志内容
	 *
	 * @param array $logData
	 * @param int $blogId
	 */
	function updateLog($logData, $blogId) {
		$author = ROLE == 'admin' ? '' : 'and author=' . UID;
		$Item = array();
		foreach ($logData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET $upStr WHERE gid=$blogId $author");
	}

	/**
	 * 获取指定条件的日志条数
	 *
	 * @param int $spot 0:前台 1:后台
	 * @param string $hide
	 * @param string $condition
	 * @param string $type
	 * @return int
	 */
	function getLogNum($hide = 'n', $condition = '', $type = 'blog', $spot = 0) {
		$hide_state = $hide ? "and hide='$hide'" : '';

		if ($spot == 0) {
			$author = '';
		}else {
			$author = ROLE == 'admin' ? '' : 'and author=' . UID;
		}

		$res = $this->db->query("SELECT gid FROM " . DB_PREFIX . "blog WHERE type='$type' $hide_state $author $condition");
		$LogNum = $this->db->num_rows($res);
		return $LogNum;
	}

	/**
	 * 后台获取单条日志
	 *
	 * @param int $blogId
	 * @return array
	 */
	function getOneLogForAdmin($blogId) {
		$timezone = Option::get('timezone');
		$author = ROLE == 'admin' ? '' : 'AND author=' . UID;
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE gid=$blogId $author";
		$res = $this->db->query($sql);
		if ($this->db->affected_rows() < 1) {
			formMsg('权限不足！', './', 0);
		}
		$row = $this->db->fetch_array($res);
		if ($row) {
			$row['date'] = $row['date'] + $timezone * 3600;
			$row['title'] = htmlspecialchars($row['title']);
			$row['content'] = htmlspecialchars($row['content']);
			$row['excerpt'] = htmlspecialchars($row['excerpt']);
			$row['password'] = htmlspecialchars($row['password']);
			$logData = $row;
			return $logData;
		}else {
			return false;
		}
	}

	/**
	 * 前台获取单条日志
	 *
	 * @param int $blogId
	 * @return array
	 */
	function getOneLogForHome($blogId) {
		$timezone = Option::get('timezone');
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE gid=$blogId AND hide='n'";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
		if ($row) {
			$logData = array(
			    'log_title' => htmlspecialchars($row['title']),
				'timestamp' => $row['date'],
				'date' => $row['date'] + $timezone * 3600,
				'logid' => intval($row['gid']),
				'sortid' => intval($row['sortid']),
				'type' => $row['type'],
				'author' => $row['author'],
				'tbscode' => substr(md5(gmdate('Ynd')), 0, 5),
				'log_content' => rmBreak($row['content']),
				'views' => intval($row['views']),
				'comnum' => intval($row['comnum']),
				'tbcount' => intval($row['tbcount']),
				'top' => $row['top'],
				'attnum' => intval($row['attnum']),
				'allow_remark' => $row['allow_remark'],
				'allow_tb' => $row['allow_tb'],
				'password' => $row['password']
				);
			return $logData;
		}else {
			return false;
		}
	}

	/**
	 * 后台获取日志列表
	 *
	 * @param string $condition
	 * @param string $hide_state
	 * @param int $page
	 * @param string $type
	 * @return array
	 */
	function getLogsForAdmin($condition = '', $hide_state = '', $page = 1, $type = 'blog') {
		$timezone = Option::get('timezone');
		$perpage_num = Option::get('admin_perpage_num');
		$start_limit = !empty($page) ? ($page - 1) * $perpage_num : 0;
		$author = ROLE == 'admin' ? '' : 'and author=' . UID;
		$hide_state = $hide_state ? "and hide='$hide_state'" : '';
		$limit = "LIMIT $start_limit, " . $perpage_num;
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE type='$type' $author $hide_state $condition $limit";
		$res = $this->db->query($sql);
		$logs = array();
		while ($row = $this->db->fetch_array($res)) {
			$row['date'] = gmdate("Y-m-d H:i", $row['date'] + $timezone * 3600);
			$row['title'] = !empty($row['title']) ? htmlspecialchars($row['title']) : 'No Title';
			$row['gid'] = $row['gid'];
			$row['comnum'] = $row['comnum'];
			$row['istop'] = $row['top'] == 'y' ? "<font color=\"red\">[置顶]</font>" : '';
			$row['attnum'] = $row['attnum'] > 0 ? "<font color=\"green\">[附件:" . $row['attnum'] . "]</font>" : '';
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 前台获取日志列表
	 *
	 * @param string $condition
	 * @param int $page
	 * @param int $prePageNum
	 * @return array
	 */
	function getLogsForHome($condition = '', $page = 1, $prePageNum) {
		$timezone = Option::get('timezone');
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE type='blog' and hide='n' $condition $limit";
		$res = $this->db->query($sql);
		$logs = array();
		while ($row = $this->db->fetch_array($res)) {
			$row['date'] += $timezone * 3600;
			$row['log_title'] = htmlspecialchars(trim($row['title']));
			$row['log_url'] = Url::log($row['gid']);
			$row['logid'] = $row['gid'];
			$row['log_description'] = empty($row['excerpt']) ? breakLog($row['content'], $row['gid']) : $row['excerpt'];
			$row['attachment'] = '';
			$row['tag'] = '';
		    $cookiePassword = isset($_COOKIE['em_logpwd_' . $row['gid']]) ? addslashes(trim($_COOKIE['em_logpwd_' . $row['gid']])) : '';
            if (!empty($row['password']) && $cookiePassword != $row['password']) {
                $row['excerpt'] = '<p>[该日志已设置加密，请点击标题输入密码访问]</p>';
            }else {
                if (!empty($row['excerpt'])) {
                    $row['excerpt'] .= '<p><a href="' . Url::log($row['logid']) . '">阅读全文&gt;&gt;</a></p>';
                }
            }
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 删除日志
	 *
	 * @param int $blogId
	 */
	function deleteLog($blogId) {
		$author = ROLE == 'admin' ? '' : 'and author=' . UID;
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog where gid=$blogId $author");
		if ($this->db->affected_rows() < 1) {
			formMsg('权限不足！', './', 0);
		}
		// 评论
		$this->db->query("DELETE FROM " . DB_PREFIX . "comment where gid=$blogId");
		// 引用
		$this->db->query("DELETE FROM " . DB_PREFIX . "trackback where gid=$blogId");
		// 标签
		$this->db->query("UPDATE " . DB_PREFIX . "tag SET gid= REPLACE(gid,',$blogId,',',') WHERE gid LIKE '%" . $blogId . "%' ");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tag WHERE gid=',' ");
		// 附件
		$query = $this->db->query("select filepath from " . DB_PREFIX . "attachment where blogid=$blogId ");
		while ($attach = $this->db->fetch_array($query)) {
			if (file_exists($attach['filepath'])) {
				$fpath = str_replace('thum-', '', $attach['filepath']);
				if ($fpath != $attach['filepath']) {
					@unlink($fpath);
				}
				@unlink($attach['filepath']);
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "attachment where blogid=$blogId");
	}

	/**
	 * 隐藏/显示日志
	 *
	 * @param int $blogId
	 * @param string $hideState
	 */
	function hideSwitch($blogId, $hideState) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET hide='$hideState' WHERE gid=$blogId");
		$this->db->query("UPDATE " . DB_PREFIX . "comment SET hide='$hideState' WHERE gid=$blogId");
	}

	/**
	 * 获取日志发布时间
	 *
	 * @param int $timezone
	 * @param string $postDate
	 * @param string $oldDate
	 * @return date
	 */
	function postDate($timezone = 8, $postDate = null, $oldDate = null) {
		$timezone = Option::get('timezone');
		$localtime = time();
		$logDate = $oldDate ? $oldDate : $localtime;
		$unixPostDate = '';
		if ($postDate) {
			$unixPostDate = emStrtotime($postDate);
			if ($unixPostDate === false) {
				$unixPostDate = $logDate;
			}
		} else {
			return $localtime;
		}
		return $unixPostDate;
	}

	/**
	 * 增加阅读次数
	 *
	 * @param int $blogId
	 */
	function updateViewCount($blogId) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET views=views+1 WHERE gid=$blogId");
	}

	/**
	 * 判断是否重复发文
	 */
	function isRepeatPost($title, $time) {
		$sql = "SELECT gid FROM " . DB_PREFIX . "blog WHERE title='$title' and date='$time' LIMIT 1";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
		return isset($row['gid']) ? (int)$row['gid'] : false;
	}

	/**
	 * 获取相邻日志
	 *
	 * @param int $date unix时间戳
	 * @return array
	 */
	function neighborLog($date) {
		$neighborlog = array();
		$neighborlog['nextLog'] = $this->db->once_fetch_array("SELECT title,gid FROM " . DB_PREFIX . "blog WHERE date < $date and hide = 'n' and type='blog' ORDER BY date DESC LIMIT 1");
		$neighborlog['prevLog'] = $this->db->once_fetch_array("SELECT title,gid FROM " . DB_PREFIX . "blog WHERE date > $date and hide = 'n' and type='blog' ORDER BY date LIMIT 1");
		if ($neighborlog['nextLog']) {
			$neighborlog['nextLog']['title'] = htmlspecialchars($neighborlog['nextLog']['title']);
		}
		if ($neighborlog['prevLog']) {
			$neighborlog['prevLog']['title'] = htmlspecialchars($neighborlog['prevLog']['title']);
		}
		return $neighborlog;
	}

	/**
	 * 随机获取指定数量日志
	 *
	 * @param int $num
	 * @return array
	 */
	function getRandLog($num) {
		$sql = "SELECT gid,title FROM " . DB_PREFIX . "blog WHERE hide='n' and type='blog' ORDER BY rand() LIMIT 0, $num";
		$res = $this->db->query($sql);
		$logs = array();
		while ($row = $this->db->fetch_array($res)) {
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 加密日志访问验证
	 *
	 * @param string $pwd
	 * @param string $pwd2
	 */
	function authPassword($postPwd, $cookiePwd, $logPwd, $logid) {
		$url = BLOG_URL;
		$pwd = $cookiePwd ? $cookiePwd : $postPwd;
		if ($pwd !== addslashes($logPwd)) {
			echo <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog message</title>
<style type="text/css">
<!--
body{background-color:#F7F7F7;font-family: Arial;font-size: 12px;line-height:150%;}
.main{background-color:#FFFFFF;margin-top:20px;font-size: 12px;color: #666666;width:580px;margin:10px 200px;padding:10px;list-style:none;border:#DFDFDF 1px solid;}
-->
</style>
</head>
<body>
<div class="main">
<form action="" method="post">
请输入该日志的访问密码<br>
<input type="password" name="logpwd" /><input type="submit" value="进入.." />
<br /><br /><a href="$url">&laquo;返回首页</a>
</form>
</div>
</body>
</html>
EOT;
			if ($cookiePwd) {
				setcookie('em_logpwd_' . $logid, ' ', time() - 31536000);
			}
			exit;
		}else {
			setcookie('em_logpwd_' . $logid, $logPwd);
		}
	}
}
