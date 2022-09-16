<?php
/**
 * article and page model
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Log_Model {

	private $db;
	private $Parsedown;

	function __construct() {
		$this->db = Database::getInstance();
		$this->Parsedown = new Parsedown();
		$this->Parsedown->setBreaksEnabled(true); //automatic line wrapping
	}

	/**
	 * create article
	 */
	function addlog($logData) {
		$kItem = [];
		$dItem = [];
		foreach ($logData as $key => $data) {
			$kItem[] = $key;
			$dItem[] = $data;
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog ($field) VALUES ($values)");
		return $this->db->insert_id();
	}

	/**
	 * update article
	 */
	function updateLog($logData, $blogId) {
		$author = User::haveEditPermission() ? '' : 'and author=' . UID;
		$Item = [];
		foreach ($logData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET $upStr WHERE gid=$blogId $author");
	}

	/**
	 * Gets the number of articles for the specified condition
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
		} else {
			$author = User::haveEditPermission() ? '' : 'and author=' . UID;
		}

		$data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE type='$type' $hide_state $author $condition");
		return $data['total'];
	}

	/**
	 * Get single article for admin
	 */
	function getOneLogForAdmin($blogId) {
		$author = User::haveEditPermission() ? '' : 'AND author=' . UID;
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE gid=$blogId $author";
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
	 * get single article
	 */
	function getOneLogForHome($blogId) {
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE gid=$blogId AND hide='n' AND checked='y'";
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
			'log_content'  => $this->Parsedown->text($row['content']),
			'views'        => (int)$row['views'],
			'comnum'       => (int)$row['comnum'],
			'top'          => $row['top'],
			'sortop'       => $row['sortop'],
			'attnum'       => (int)$row['attnum'],
			'allow_remark' => Option::get('iscomment') == 'y' ? $row['allow_remark'] : 'n',
			'password'     => $row['password'],
			'template'     => $row['template'],
		];
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
		$perpage_num = Option::get('admin_perpage_num');
		$start_limit = !empty($page) ? ($page - 1) * $perpage_num : 0;
		$author = User::haveEditPermission() ? '' : 'AND author=' . UID;
		$hide_state = $hide_state ? "AND hide='$hide_state'" : '';
		$limit = "LIMIT $start_limit, " . $perpage_num;
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE type='$type' $author $hide_state $condition $limit";
		$res = $this->db->query($sql);
		$logs = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['date'] = date("Y-m-d H:i", $row['date']);
			$row['title'] = !empty($row['title']) ? htmlspecialchars($row['title']) : '无标题';
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
	function getLogsForHome($condition = '', $page = 1, $perPageNum = 10) {
		$start_limit = !empty($page) ? ($page - 1) * $perPageNum : 0;
		$limit = $perPageNum ? "LIMIT $start_limit, $perPageNum" : '';
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE type='blog' AND hide='n' AND checked='y' $condition $limit";
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
			$row['tbcount'] = 0;//兼容未删除引用的模板
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * get rss article list
	 *
	 * @param int $perPageNum
	 * @return array
	 */
	function getLogsForRss($perPageNum = 10) {
		if ($perPageNum <= 0) {
			return [];
		}
		$sql = "SELECT * FROM " . DB_PREFIX . "blog  WHERE hide='n' AND checked='y' AND type='blog' ORDER BY date DESC LIMIT 0," . $perPageNum;
		$result = $this->db->query($sql);
		$d = [];
		while ($re = $this->db->fetch_array($result)) {
			$re['id'] = $re['gid'];
			$re['title'] = htmlspecialchars($re['title']);
			$re['content'] = $this->Parsedown->text($re['content']);
			if (!empty($re['password'])) {
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
	 * 获取全部页面列表
	 */
	function getAllPageList() {
		$sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE type='page'";
		$res = $this->db->query($sql);
		$pages = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['date'] = date("Y-m-d H:i", $row['date']);
			$row['title'] = !empty($row['title']) ? htmlspecialchars($row['title']) : '无标题';
			$pages[] = $row;
		}
		return $pages;
	}

	/**
	 * delete article
	 */
	function deleteLog($blogId) {
		$author = User::haveEditPermission() ? '' : 'AND author=' . UID;
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog WHERE gid=$blogId $author");
		if ($this->db->affected_rows() < 1) {
			emMsg('权限不足！', './');
		}
		// comment
		$this->db->query("DELETE FROM " . DB_PREFIX . "comment WHERE gid=$blogId");
		// tag
		$this->db->query("UPDATE " . DB_PREFIX . "tag SET gid= REPLACE(gid,',$blogId,',',') WHERE gid LIKE '%" . $blogId . "%' ");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tag WHERE gid=',' ");
	}

	/**
	 * 隐藏/显示文章
	 *
	 * @param int $blogId
	 * @param string $state
	 */
	function hideSwitch($blogId, $state) {
		$author = User::haveEditPermission() ? '' : 'and author=' . UID;
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET hide='$state' WHERE gid=$blogId $author");
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
		$sql = "SELECT gid FROM " . DB_PREFIX . "blog WHERE title='$title' AND date='$time' LIMIT 1";
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
		$neighborlog = [];
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
		$start = $lognum > $num ? mt_rand(0, $lognum - $num) : 0;
		$sql = "SELECT gid,title FROM " . DB_PREFIX . "blog WHERE hide='n' AND checked='y' AND type='blog' LIMIT $start, $num";
		$res = $this->db->query($sql);
		$logs = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['gid'] = (int)$row['gid'];
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 获取热门文章
	 */
	function getHotLog($num) {
		$sql = "SELECT gid,title FROM " . DB_PREFIX . "blog WHERE hide='n' AND checked='y' AND type='blog' ORDER BY views DESC, comnum DESC LIMIT 0, $num";
		$res = $this->db->query($sql);
		$logs = [];
		while ($row = $this->db->fetch_array($res)) {
			$row['gid'] = (int)$row['gid'];
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 处理文章别名，防止别名重复
	 */
	function checkAlias($alias, $logalias_cache, $logid) {
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

	/**
	 * 加密文章访问验证
	 */
	function authPassword($postPwd, $cookiePwd, $logPwd, $logid) {
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
		} else {
			setcookie('em_logpwd_' . $logid, $logPwd);
		}
	}
}
