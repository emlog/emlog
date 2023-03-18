<?php
/**
 * Rest API controller
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Api_Controller {

	public $Log_Model;
	public $Twitter_Model;
	public $Tag_Model;
	public $User_Model;
	public $Cache;
	public $authReqSign;
	public $authReqTime;
	public $curUserInfo;
	public $curUid;

	function starter($params) {
		$_func = isset($_GET['rest-api']) ? addslashes($_GET['rest-api']) : '';
		if (empty($_func)) {
			Output::error('error router');
		}

		if (Option::get('is_openapi') === 'n') {
			Output::error('api is closed');
		}

		if (method_exists($this, $_func)) {
			$this->Log_Model = new Log_Model();
			$this->Tag_Model = new Tag_Model();
			$this->Twitter_Model = new Twitter_Model();
			$this->User_Model = new User_Model();
			$this->Cache = Cache::getInstance();
			$this->$_func();
		} else {
			Output::error('api method is not exist');
		}
	}

	private function article_post() {
		$title = Input::postStrVar('title');
		$content = Input::postStrVar('content');
		$excerpt = Input::postStrVar('excerpt');
		$author_uid = isset($_POST['author_uid']) ? (int)trim($_POST['author_uid']) : 1;
		$post_date = isset($_POST['post_date']) ? trim($_POST['post_date']) : '';
		$sort_id = isset($_POST['sort_id']) ? (int)$_POST['sort_id'] : -1;
		$tags = isset($_POST['tags']) ? strip_tags(addslashes(trim($_POST['tags']))) : '';
		$cover = Input::postStrVar('cover');
		$draft = Input::postStrVar('draft', 'n');
		$this->authReqSign = Input::postStrVar('req_sign');
		$this->authReqTime = Input::postStrVar('req_time');

		if (empty($title) || empty($content)) {
			Output::error('parameter error');
		}

		$this->auth();

		if ($this->curUid) {
			$author_uid = $this->curUid;
		}

		$logData = [
			'title'   => $title,
			'content' => $content,
			'excerpt' => $excerpt,
			'author'  => $author_uid,
			'sortid'  => $sort_id,
			'cover'   => $cover,
			'date'    => strtotime($post_date ?: date('Y-m-d H:i:s')),
			'hide'    => $draft === 'y' ? 'y' : 'n',
		];

		$article_id = $this->Log_Model->addlog($logData);
		$this->Tag_Model->addTag($tags, $article_id);
		$this->Cache->updateCache();

		doAction('save_log', $article_id);

		output::ok(['article_id' => $article_id,]);
	}

	private function article_update() {
		$id = Input::postIntVar('id');
		$title = Input::postStrVar('title');
		$content = Input::postStrVar('content');
		$excerpt = Input::postStrVar('excerpt');
		$post_date = isset($_POST['post_date']) ? trim($_POST['post_date']) : '';
		$sort_id = Input::postIntVar('sort_id', -1);
		$cover = Input::postStrVar('cover');
		$tags = isset($_POST['tags']) ? strip_tags(addslashes(trim($_POST['tags']))) : '';
		$author_uid = isset($_POST['author_uid']) ? (int)trim($_POST['author_uid']) : 1;
		$draft = Input::postStrVar('draft', 'n');

		if (empty($id) || empty($title)) {
			Output::error('parameter error');
		}

		$this->authReqSign = Input::postStrVar('req_sign');
		$this->authReqTime = Input::postStrVar('req_time');
		$this->auth();

		if ($this->curUid) {
			$author_uid = $this->curUid;
		}

		$logData = [
			'title'   => $title,
			'content' => $content,
			'excerpt' => $excerpt,
			'sortid'  => $sort_id,
			'cover'   => $cover,
			'author'  => $author_uid,
			'date'    => strtotime($post_date ?: date('Y-m-d H:i:s')),
			'hide'    => $draft === 'y' ? 'y' : 'n',
		];

		$this->Log_Model->updateLog($logData, $id, $author_uid);
		$this->Tag_Model->updateTag($tags, $id);
		$this->Cache->updateCache();

		doAction('save_log', $id);

		output::ok();
	}

	private function article_list() {
		$page = isset($_GET['page']) ? (int)trim($_GET['page']) : 1;
		$count = isset($_GET['count']) ? (int)trim($_GET['count']) : Option::get('index_lognum');
		$sort_id = isset($_GET['sort_id']) ? (int)trim($_GET['sort_id']) : 0;
		$keyword = isset($_GET['keyword']) ? addslashes(htmlspecialchars(urldecode(trim($_GET['keyword'])))) : '';
		$keyword = str_replace(['%', '_'], ['\%', '\_'], $keyword);
		$tag = isset($_GET['tag']) ? addslashes(urldecode(trim($_GET['tag']))) : '';

		$sub = '';
		if ($sort_id) {
			$sub .= ' and sortid = ' . $sort_id;
		}
		if ($keyword) {
			$sub .= " and title like '%{$keyword}%'";
		}
		if ($tag) {
			$blogIdStr = $this->Tag_Model->getTagByName($tag);
			if ($blogIdStr) {
				$sub .= "and gid IN ($blogIdStr)";
			}
		}

		$r = $this->Log_Model->getLogsForHome($sub . " ORDER BY top DESC ,date DESC", $page, $count);
		$sort_cache = $this->Cache->readCache('sort');
		$articles = [];
		foreach ($r as $value) {
			$articles[] = [
				'id'          => (int)$value['gid'],
				'title'       => $value['title'],
				'cover'       => $value['log_cover'],
				'url'         => $value['log_url'],
				'description' => $value['log_description'],
				'date'        => date('Y-m-d H:i:s', $value['date']),
				'author_id'   => (int)$value['author'],
				'author_name' => $this->getAuthorName($value['author']),
				'sort_id'     => (int)$value['sortid'],
				'sort_name'   => isset($sort_cache[$value['sortid']]['sortname']) ? $sort_cache[$value['sortid']]['sortname'] : '',
				'views'       => (int)$value['views'],
				'comnum'      => (int)$value['comnum'],
				'top'         => $value['top'],
				'sortop'      => $value['sortop'],
				'tags'        => $this->getTags((int)$value['gid']),
			];
		}

		output::ok(['articles' => $articles,]);
	}

	private function article_detail() {
		$id = isset($_GET['id']) ? (int)trim($_GET['id']) : 0;

		$r = $this->Log_Model->getOneLogForHome($id);
		$sort_cache = $this->Cache->readCache('sort');
		$article = '';
		if (empty($r)) {
			output::ok(['article' => $article,]);
		}

		$user_info = $this->User_Model->getOneUser($r['author']);
		$author_name = isset($user_info['nickname']) ? $user_info['nickname'] : '';

		$article = [
			'title'       => $r['log_title'],
			'date'        => date('Y-m-d H:i:s', $r['date']),
			'id'          => (int)$r['logid'],
			'sort_id'     => (int)$r['sortid'],
			'sort_name'   => isset($sort_cache[$r['sortid']]['sortname']) ? $sort_cache[$r['sortid']]['sortname'] : '',
			'type'        => $r['type'],
			'author_id'   => (int)$r['author'],
			'author_name' => $author_name,
			'content'     => $r['log_content'],
			'cover'       => $r['log_cover'],
			'views'       => (int)$r['views'],
			'comnum'      => (int)$r['comnum'],
			'top'         => $r['top'],
			'sortop'      => $r['sortop'],
			'tags'        => $this->getTags($id),
		];

		output::ok(['article' => $article,]);
	}

	function sort_list() {
		$sort_cache = $this->Cache->readCache('sort');
		$data = [];
		foreach ($sort_cache as $sort_id => $value) {
			unset($value['children']);
			if ($value['pid'] === 0) {
				$data[$sort_id] = $value;
			} else {
				$data[$value['pid']]['children'][] = $value;
			}
		}
		sort($data);
		output::ok(['sorts' => $data,]);
	}

	function note_post() {
		$t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';
		$author_uid = isset($_POST['author_uid']) ? (int)trim($_POST['author_uid']) : 1;
		$this->authReqSign = Input::postStrVar('req_sign');
		$this->authReqTime = Input::postStrVar('req_time');

		if (empty($t)) {
			Output::error('parameter error');
		}

		$this->auth();

		if ($this->curUid) {
			$author_uid = $this->curUid;
		}

		$data = [
			'content' => $t,
			'author'  => $author_uid,
			'date'    => time(),
		];

		$id = $this->Twitter_Model->addTwitter($data);
		$this->Cache->updateCache('sta');
		output::ok(['note_id' => $id,]);
	}

	public function userinfo() {
		$this->checkAuthCookie();

		if (!$this->curUserInfo) {
			Output::error('auth error');
		}

		$data = [
			'uid'         => (int)$this->curUserInfo['uid'],
			'nickname'    => htmlspecialchars($this->curUserInfo['nickname']),
			'role'        => $this->curUserInfo['role'],
			'photo'       => $this->curUserInfo['photo'],
			'avatar'      => $this->curUserInfo['photo'] ? BLOG_URL . str_replace("../", '', $this->curUserInfo['photo']) : '',
			'email'       => $this->curUserInfo['email'],
			'description' => htmlspecialchars($this->curUserInfo['description']),
			'ip'          => $this->curUserInfo['ip'],
			'create_time' => (int)$this->curUserInfo['create_time'],
		];

		output::ok(['userinfo' => $data]);
	}

	private function getTags($id) {
		$tag_ids = $this->Tag_Model->getTagIdsFromBlogId($id);
		$tag_names = $this->Tag_Model->getNamesFromIds($tag_ids);
		$tags = [];
		if (!empty($tag_names)) {
			foreach ($tag_names as $value) {
				$tags[] = [
					'name' => htmlspecialchars($value),
					'url'  => Url::tag(rawurlencode($value)),
				];
			}
		}
		return $tags;
	}

	private function getAuthorName($uid) {
		$userInfo = $this->User_Model->getOneUser($uid);
		return isset($userInfo['nickname']) ? $userInfo['nickname'] : '';
	}

	private function auth() {
		if (isset($_COOKIE[AUTH_COOKIE_NAME])) {
			$this->checkAuthCookie();
		} else {
			$this->checkApiKey();
		}
	}

	private function checkApiKey() {
		if (empty($this->authReqSign) || empty($this->authReqTime)) {
			Output::error('parameter error');
		}

		$apikey = Option::get('apikey');
		$sign = md5($this->authReqTime . $apikey);

		if ($sign !== $this->authReqSign) {
			Output::error('sign error');
		}
	}

	private function checkAuthCookie() {
		if (!isset($_COOKIE[AUTH_COOKIE_NAME])) {
			Output::error('auth cookie error');
		}
		$userInfo = loginauth::validateAuthCookie($_COOKIE[AUTH_COOKIE_NAME]);
		if (!$userInfo) {
			Output::error('auth cookie error');
		}
		$this->curUserInfo = $userInfo;
		$this->curUid = (int)$userInfo['uid'];
	}
}
