<?php
/**
 * 文章、页面管理
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Log_Model {

	private $db;

	function __construct() {
		$this->db = MySql::getInstance();
	}

	/**
	 * 添加文章、页面
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
	 * 更新文章内容
	 *
	 * @param array $logData
	 * @param int $blogId
	 */
	function updateLog($logData, $blogId) {
		$author = ROLE == ROLE_ADMIN ? '' : 'and author=' . UID;
		$Item = array();
		foreach ($logData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET $upStr WHERE gid=$blogId $author");
	}

	/**
	 * 获取指定条件的文章条数
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
			$author = ROLE == ROLE_ADMIN ? '' : 'and author=' . UID;
		}

        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE type='$type' $hide_state $author $condition");
		return $data['total'];
	}

	/**
	 * 后台获取单篇文章
	 */
	function getOneLogForAdmin($blogId) {
		$timezone = Option::get('timezone');
		$author = ROLE == ROLE_ADMIN ? '' : 'AND author=' . UID;
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE gid=$blogId $author";
		$res = $this->db->query($sql);
		if ($this->db->affected_rows() < 1) {
			emMsg('权限不足！', './');
		}
		$row = $this->db->fetch_array($res);
		if ($row) {
			$row['date'] = $row['date'] + $timezone * 3600;
			$row['title'] = htmlspecialchars($row['title']);
			$row['content'] = htmlspecialchars($row['content']);
			$row['excerpt'] = htmlspecialchars($row['excerpt']);
			$row['password'] = htmlspecialchars($row['password']);
            $row['template'] = !empty($row['template']) ? htmlspecialchars(trim($row['template'])) : 'page';
			$logData = $row;
			return $logData;
		} else {
			return false;
		}
	}

	/**
	 * 前台获取单篇文章
	 */
	function getOneLogForHome($blogId) {
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE gid=$blogId AND hide='n' AND checked='y'";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);
		if ($row) {
			$logData = array(
				'log_title' => htmlspecialchars($row['title']),
				'timestamp' => $row['date'],
				'date' => $row['date'] + Option::get('timezone') * 3600,
				'logid' => intval($row['gid']),
				'sortid' => intval($row['sortid']),
				'type' => $row['type'],
				'author' => $row['author'],
				'log_content' => rmBreak($row['content']),
				'views' => intval($row['views']),
				'comnum' => intval($row['comnum']),
				'top' => $row['top'],
				'attnum' => intval($row['attnum']),
				'allow_remark' => Option::get('iscomment') == 'y' ? $row['allow_remark'] : 'n',
				'password' => $row['password'],
                'template' => $row['template'],
				);
			return $logData;
		} else {
			return false;
		}
	}

	/**
	 * 后台获取文章列表
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
		$author = ROLE == ROLE_ADMIN ? '' : 'and author=' . UID;
		$hide_state = $hide_state ? "and hide='$hide_state'" : '';
		$limit = "LIMIT $start_limit, " . $perpage_num;
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE type='$type' $author $hide_state $condition $limit";
		$res = $this->db->query($sql);
		$logs = array();
		while ($row = $this->db->fetch_array($res)) {
			$row['date']	= gmdate("Y-m-d H:i", $row['date'] + $timezone * 3600);
			$row['title'] 	= !empty($row['title']) ? htmlspecialchars($row['title']) : '无标题';
			//$row['gid'] 	= $row['gid'];
			//$row['comnum'] 	= $row['comnum'];
			//$row['top'] 	= $row['top'];
			//$row['attnum'] 	= $row['attnum'];
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 前台获取文章列表
	 *
	 * @param string $condition
	 * @param int $page
	 * @param int $perPageNum
	 * @return array
	 */
	function getLogsForHome($condition = '', $page = 1, $perPageNum) {
		$timezone = Option::get('timezone');
		$start_limit = !empty($page) ? ($page - 1) * $perPageNum : 0;
		$limit = $perPageNum ? "LIMIT $start_limit, $perPageNum" : '';
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE type='blog' and hide='n' and checked='y' $condition $limit";
		$res = $this->db->query($sql);
		$logs = array();
		while ($row = $this->db->fetch_array($res)) {
			$row['date'] += $timezone * 3600;
			$row['log_title'] = htmlspecialchars(trim($row['title']));
			$row['log_url'] = Url::log($row['gid']);
			$row['logid'] = $row['gid'];
			$cookiePassword = isset($_COOKIE['em_logpwd_' . $row['gid']]) ? addslashes(trim($_COOKIE['em_logpwd_' . $row['gid']])) : '';
			if (!empty($row['password']) && $cookiePassword != $row['password']) {
				$row['excerpt'] = '<p>[该文章已设置加密，请点击标题输入密码访问]</p>';
			} else {
				if (!empty($row['excerpt'])) {
					$row['excerpt'] .= '<p class="readmore"><a href="' . Url::log($row['logid']) . '">阅读全文&gt;&gt;</a></p>';
				}
			}
			$row['log_description'] = empty($row['excerpt']) ? breakLog($row['content'], $row['gid']) : $row['excerpt'];
			$row['attachment'] = '';
			$row['tag'] = '';
            $row['tbcount'] = 0;//兼容未删除引用的模板
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 获取全部页面列表
	 *
	 */
	function getAllPageList() {
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE type='page'";
		$res = $this->db->query($sql);
		$pages = array();
		while ($row = $this->db->fetch_array($res)) {
			$row['date']	= gmdate("Y-m-d H:i", $row['date'] + Option::get('timezone') * 3600);
			$row['title'] 	= !empty($row['title']) ? htmlspecialchars($row['title']) : '无标题';
			//$row['gid'] 	= $row['gid'];
			//$row['comnum'] 	= $row['comnum'];
			//$row['top'] 	= $row['top'];
			//$row['attnum'] 	= $row['attnum'];
			$pages[] = $row;
		}
		return $pages;
	}

	/**
	 * 删除文章
	 *
	 * @param int $blogId
	 */
	function deleteLog($blogId) {
		$author = ROLE == ROLE_ADMIN ? '' : 'and author=' . UID;
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog where gid=$blogId $author");
		if ($this->db->affected_rows() < 1) {
			emMsg('权限不足！', './');
		}
		// 评论
		$this->db->query("DELETE FROM " . DB_PREFIX . "comment where gid=$blogId");
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
	 * 隐藏/显示文章
	 *
	 * @param int $blogId
	 * @param string $state
	 */
	function hideSwitch($blogId, $state) {
        $author = ROLE == ROLE_ADMIN ? '' : 'and author=' . UID;
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET hide='$state' WHERE gid=$blogId $author");
        if ($this->db->affected_rows() < 1) {
			emMsg('权限不足！', './');
		}
		$this->db->query("UPDATE " . DB_PREFIX . "comment SET hide='$state' WHERE gid=$blogId");
		$Comment_Model = new Comment_Model();
		$Comment_Model->updateCommentNum($blogId);
	}

    /**
	 * 审核/驳回作者文章
	 *
	 * @param int $blogId
	 * @param string $state
	 */
	function checkSwitch($blogId, $state) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET checked='$state' WHERE gid=$blogId");
        $state = $state == 'y' ? 'n' : 'y';
		$this->db->query("UPDATE " . DB_PREFIX . "comment SET hide='$state' WHERE gid=$blogId");
		$Comment_Model = new Comment_Model();
		$Comment_Model->updateCommentNum($blogId);
	}

	/**
	 * 获取文章发布时间
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
	 * 获取相邻文章
	 *
	 * @param int $date unix时间戳
	 * @return array
	 */
	function neighborLog($date) {
		$neighborlog = array();
		$neighborlog['nextLog'] = $this->db->once_fetch_array("SELECT title,gid FROM " . DB_PREFIX . "blog WHERE date < $date and hide = 'n' and checked='y' and type='blog' ORDER BY date DESC LIMIT 1");
		$neighborlog['prevLog'] = $this->db->once_fetch_array("SELECT title,gid FROM " . DB_PREFIX . "blog WHERE date > $date and hide = 'n' and checked='y' and type='blog' ORDER BY date LIMIT 1");
		if ($neighborlog['nextLog']) {
			$neighborlog['nextLog']['title'] = htmlspecialchars($neighborlog['nextLog']['title']);
		}
		if ($neighborlog['prevLog']) {
			$neighborlog['prevLog']['title'] = htmlspecialchars($neighborlog['prevLog']['title']);
		}
		return $neighborlog;
	}

	/**
	 * 随机获取指定数量文章
	 */
	function getRandLog($num) {
        global $CACHE;
        $sta_cache = $CACHE->readCache('sta');
        $lognum = $sta_cache['lognum'];
        $start = $lognum > $num ? mt_rand(0, $lognum - $num): 0;
		$sql = "SELECT gid,title FROM " . DB_PREFIX . "blog WHERE hide='n' and checked='y' and type='blog' LIMIT $start, $num";
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
	 * 获取热门文章
	 */
	function getHotLog($num) {
		$sql = "SELECT gid,title FROM " . DB_PREFIX . "blog WHERE hide='n' and checked='y' and type='blog' ORDER BY views DESC, comnum DESC LIMIT 0, $num";
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
	 * 处理文章别名，防止别名重复
	 *
	 * @param string $alias
	 * @param array $logalias_cache
	 * @param int $logid
	 */
	function checkAlias($alias, $logalias_cache, $logid) {
		static $i=2;
		$key = array_search($alias, $logalias_cache);
		if (false !== $key && $key != $logid) {
			if($i == 2) {
				$alias .= '-'.$i;
			}else{
				$alias = preg_replace("|(.*)-([\d]+)|", "$1-{$i}", $alias);
			}
			$i++;
			return $this->checkAlias($alias, $logalias_cache, $logid);
		}
		return $alias;
	}

	/**
	 * 加密文章访问验证
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
请输入该文章的访问密码<br>
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
		} else {
			setcookie('em_logpwd_' . $logid, $logPwd);
		}
	}
}
