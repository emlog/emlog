<?php
/**
 * commment model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Comment_Model {

	private $db;

	function __construct() {
		$this->db = Database::getInstance();
	}

	/**
	 * get comment list
	 *
	 * @param int $blogId
	 * @param string $hide
	 * @param int $page
	 * @return array
	 */
	function getComments($blogId = null, $hide = null, $page = null) {
		$andQuery = '1=1';
		$andQuery .= $blogId ? " and a.gid=$blogId" : '';
		$andQuery .= $hide ? " and a.hide='$hide'" : '';
		$condition = '';

		$sql = "SELECT * FROM " . DB_PREFIX . "comment AS a WHERE $andQuery ORDER BY a.top ASC, a.date ASC $condition";

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

	/**
	 * get comment list for admin
	 *
	 * @param int $blogId
	 * @param string $hide
	 * @param int $page
	 * @return array
	 */
	function getCommentsForAdmin($blogId = null, $hide = null, $page = null) {
		$orderBy = $blogId ? "ORDER BY a.top DESC, a.date DESC" : 'ORDER BY a.date DESC';
		$andQuery = '1=1';
		$andQuery .= $blogId ? " AND a.gid=$blogId" : '';
		$andQuery .= $hide ? " AND a.hide='$hide'" : '';
		$condition = '';
		if ($page) {
			$perpage_num = Option::get('admin_perpage_num');
			if ($page > PHP_INT_MAX) {
				$page = PHP_INT_MAX;
			}
			$startId = ($page - 1) * $perpage_num;
			$condition = "LIMIT $startId, " . $perpage_num;
		}

		$andQuery .= !User::haveEditPermission() ? ' AND b.author=' . UID : '';
		$sql = "SELECT *,a.hide,a.date,a.top FROM " . DB_PREFIX . "comment AS a, " . DB_PREFIX . "blog AS b WHERE $andQuery AND a.gid=b.gid $orderBy $condition";

		$ret = $this->db->query($sql);
		$comments = [];
		while ($row = $this->db->fetch_array($ret)) {
			$row['poster'] = htmlspecialchars($row['poster']);
			$row['mail'] = htmlspecialchars($row['mail']);
			$row['url'] = htmlspecialchars($row['url']);
			$row['comment'] = htmlClean($row['comment']);
			$row['date'] = smartDate($row['date']);
			$row['top'] = $row['top'];
			$row['os'] = get_os($row['agent']);
			$row['browse'] = get_browse($row['agent']);
			$row['children'] = [];
			$comments[$row['cid']] = $row;
		}

		return $comments;
	}

	function getOneComment($commentId, $nl2br = false) {
		$sql = "SELECT * FROM " . DB_PREFIX . "comment WHERE cid=$commentId";
		$res = $this->db->query($sql);
		if ($this->db->affected_rows() < 1) {
			return false;
		}
		$commentArray = $this->db->fetch_array($res);
		$commentArray['comment'] = $nl2br ? htmlClean(trim($commentArray['comment'])) : htmlClean(trim($commentArray['comment']), FALSE);
		$commentArray['poster'] = htmlspecialchars($commentArray['poster']);
		$commentArray['date'] = date("Y-m-d H:i", $commentArray['date']);
		return $commentArray;
	}

	function getCommentNum($blogId = null, $hide = null) {
		$andQuery = '1=1';
		$andQuery .= $blogId ? " AND a.gid=$blogId" : '';
		$andQuery .= $hide ? " AND a.hide='$hide'" : '';
		if (User::haveEditPermission()) {
			$sql = "SELECT count(*) FROM " . DB_PREFIX . "comment AS a WHERE $andQuery";
		} else {
			$sql = "SELECT count(*) FROM " . DB_PREFIX . "comment AS a, " . DB_PREFIX . "blog AS b WHERE $andQuery AND a.gid=b.gid AND b.author=" . UID;
		}
		$res = $this->db->once_fetch_array($sql);
		return $res['count(*)'];
	}

	function delComment($commentId) {
		$this->isYoursComment($commentId);
		$row = $this->db->once_fetch_array("SELECT gid FROM " . DB_PREFIX . "comment WHERE cid=$commentId");
		$blogId = (int)$row['gid'];
		$commentIds = array($commentId);
		/* Get sub-comment ID */
		$query = $this->db->query("SELECT cid,pid FROM " . DB_PREFIX . "comment WHERE gid=$blogId AND cid>$commentId ");
		while ($row = $this->db->fetch_array($query)) {
			if (in_array($row['pid'], $commentIds)) {
				$commentIds[] = $row['cid'];
			}
		}
		$commentIds = implode(',', $commentIds);
		$this->db->query("DELETE FROM " . DB_PREFIX . "comment WHERE cid IN ($commentIds)");
		$this->updateCommentNum($blogId);
	}

	function delCommentByIp($ip) {
		$blogids = [];
		$sql = "SELECT DISTINCT gid FROM " . DB_PREFIX . "comment WHERE ip='$ip'";
		$query = $this->db->query($sql);
		while ($row = $this->db->fetch_array($query)) {
			$blogids[] = $row['gid'];
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "comment WHERE ip='$ip'");
		$this->updateCommentNum($blogids);
	}

	function hideComment($commentId) {
		$this->isYoursComment($commentId);
		$row = $this->db->once_fetch_array("SELECT gid FROM " . DB_PREFIX . "comment WHERE cid=$commentId");
		$blogId = (int)$row['gid'];
		$commentIds = array($commentId);
		/* Get sub-comment ID */
		$query = $this->db->query("SELECT cid,pid FROM " . DB_PREFIX . "comment WHERE gid=$blogId AND cid>$commentId ");
		while ($row = $this->db->fetch_array($query)) {
			if (in_array($row['pid'], $commentIds)) {
				$commentIds[] = $row['cid'];
			}
		}
		$commentIds = implode(',', $commentIds);
		$this->db->query("UPDATE " . DB_PREFIX . "comment SET hide='y' WHERE cid IN ($commentIds)");
		$this->updateCommentNum($blogId);
	}

	function showComment($commentId) {
		$this->isYoursComment($commentId);
		$row = $this->db->once_fetch_array("SELECT gid,pid FROM " . DB_PREFIX . "comment WHERE cid=$commentId");
		$blogId = (int)$row['gid'];
		$commentIds = array($commentId);
		/* Get the parent comment ID */
		while ($row['pid'] != 0) {
			$commentId = (int)$row['pid'];
			$commentIds[] = $commentId;
			$row = $this->db->once_fetch_array("SELECT pid FROM " . DB_PREFIX . "comment WHERE cid=$commentId");
		}
		$commentIds = implode(',', $commentIds);
		$this->db->query("UPDATE " . DB_PREFIX . "comment SET hide='n' WHERE cid IN ($commentIds)");
		$this->updateCommentNum($blogId);
	}

	function topComment($commentId, $top = 'y') {
		$this->isYoursComment($commentId);
		$commentIds = array($commentId);
		$commentIds = implode(',', $commentIds);
		$this->db->query("UPDATE " . DB_PREFIX . "comment SET top='$top' WHERE cid IN ($commentIds)");
	}

	function replyComment($blogId, $pid, $content, $hide) {
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
		if (isset($user_cache[UID])) {
			$name = addslashes($user_cache[UID]['name_orig']);
			$mail = addslashes($user_cache[UID]['mail']);
			$url = addslashes(BLOG_URL);
			$ipaddr = getIp();
			$utctimestamp = time();
			if ($pid != 0) {
				$comment = $this->getOneComment($pid);
/*vot*/				$content = '@' . addslashes($comment['poster']) . ': ' . $content;
			}
			$this->db->query("INSERT INTO " . DB_PREFIX . "comment (date,poster,gid,comment,mail,url,hide,ip,pid)
                    VALUES ('$utctimestamp','$name','$blogId','$content','$mail','$url','$hide','$ipaddr','$pid')");
			$this->updateCommentNum($blogId);
		}
	}

	function batchComment($action, $comments) {
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

	function updateCommentNum($blogId) {
		if (is_array($blogId)) {
			foreach ($blogId as $val) {
				$this->updateCommentNum($val);
			}
		} else {
			$sql = "SELECT count(*) FROM " . DB_PREFIX . "comment WHERE gid=$blogId AND hide='n'";
			$res = $this->db->once_fetch_array($sql);
			$comNum = $res['count(*)'];
			$this->db->query("UPDATE " . DB_PREFIX . "blog SET comnum=$comNum WHERE gid=$blogId");
			return $comNum;
		}
	}

	function addComment($uid, $name, $content, $mail, $url, $blogId, $pid) {
		$ipaddr = getIp();
		$timestamp = time();
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);

		if ($pid > 0) {
			$comment = $this->getOneComment($pid);
/*vot*/			$content = '@' . addslashes($comment['poster']) . ': ' . $content;
		}

		$hide = Option::get('ischkcomment') == 'y' && !User::haveEditPermission() ? 'y' : 'n';

		$sql = 'INSERT INTO ' . DB_PREFIX . "comment (uid,date,poster,gid,comment,mail,url,hide,ip,agent,pid)
                VALUES ($uid,'$timestamp','$name','$blogId','$content','$mail','$url','$hide','$ipaddr','$useragent','$pid')";
		$this->db->query($sql);
		$cid = $this->db->insert_id();
		$CACHE = Cache::getInstance();

		if ($hide == 'n') {
			$this->db->query('UPDATE ' . DB_PREFIX . "blog SET comnum = comnum + 1 WHERE gid='$blogId'");
			$CACHE->updateCache(array('sta', 'comment'));
			doAction('comment_saved', $cid);
			emDirect(Url::log($blogId) . '#' . $cid);
		} else {
			$CACHE->updateCache('sta');
			doAction('comment_saved', $cid);
/*vot*/			emMsg(lang('comment_wait_approve'), Url::log($blogId));
		}
	}

	function isCommentExist($blogId, $name, $content) {
		$data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment WHERE gid=$blogId AND poster='$name' AND comment='$content'");
		if ($data['total'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	function isYoursComment($cid) {
		if (User::haveEditPermission() || User::isVistor()) {
			return true;
		}
		$query = $this->db->query("SELECT a.cid FROM " . DB_PREFIX . "comment AS a," . DB_PREFIX . "blog AS b WHERE a.cid=$cid AND a.gid=b.gid AND b.author=" . UID);
		$result = $this->db->num_rows($query);
		if ($result <= 0) {
/*vot*/			emMsg(lang('no_permission'), './');
		}
	}

	function isNameAndMailValid($name, $mail) {
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
		foreach ($user_cache as $user) {
			if ($user['name'] == $name || ($mail != '' && $user['mail'] == $mail)) {
				return false;
			}
		}
		return true;
	}

	function isLogCanComment($blogId) {
		if (Option::get('iscomment') == 'n') {
			return false;
		}
		$query = $this->db->query("SELECT allow_remark FROM " . DB_PREFIX . "blog WHERE gid=$blogId");
		$show_remark = $this->db->fetch_array($query);
		if ($show_remark['allow_remark'] == 'n' || $show_remark === false) {
			return false;
		} else {
			return true;
		}
	}

	function isCommentTooFast() {
		$ipaddr = getIp();
		$utctimestamp = time() - Option::get('comment_interval');

		$sql = 'SELECT count(*) AS num FROM ' . DB_PREFIX . "comment WHERE date > $utctimestamp AND ip='$ipaddr'";
		$res = $this->db->query($sql);
		$row = $this->db->fetch_array($res);

		return (int)$row['num'] > 0;
	}

	function setCommentCookie($name, $mail, $url) {
		$cookietime = time() + 31536000;
		setcookie('commentposter', $name, $cookietime);
		setcookie('postermail', $mail, $cookietime);
		setcookie('posterurl', $url, $cookietime);
	}
}
