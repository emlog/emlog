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
	public $Cache;

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
			$this->Cache = Cache::getInstance();
			$this->$_func();
		} else {
			Output::error('API function is not exist');
		}
	}

	private function article_post() {
		$req_sign = isset($_POST['req_sign']) ? addslashes(trim($_POST['req_sign'])) : '';
		$req_time = isset($_POST['req_time']) ? addslashes(trim($_POST['req_time'])) : '';
		$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
		$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
		$excerpt = isset($_POST['excerpt']) ? addslashes(trim($_POST['excerpt'])) : '';
		$author_uid = isset($_POST['author_uid']) ? (int)trim($_POST['author_uid']) : 1;
		$post_date = isset($_POST['post_date']) ? trim($_POST['post_date']) : '';
		$sort_id = isset($_POST['sort_id']) ? (int)$_POST['sort_id'] : -1;
		$tags = isset($_POST['tags']) ? addslashes(trim($_POST['tags'])) : '';
		$cover = isset($_POST['cover']) ? addslashes(trim($_POST['cover'])) : '';

		if (empty($req_sign) || empty($req_time) || empty($title) || empty($content)) {
			Output::error('parameter error');
		}

		$this->checkApiKey($req_sign, $req_time);

		$logData = [
			'title'   => $title,
			'content' => $content,
			'excerpt' => $excerpt,
			'author'  => $author_uid,
			'sortid'  => $sort_id,
			'cover'   => $cover,
			'date'    => strtotime($post_date ?: date('Y-m-d H:i:s')),
		];

		$article_id = $this->Log_Model->addlog($logData);
		$this->Tag_Model->addTag($tags, $article_id);

		$this->Cache->updateCache();

		output::ok(['article_id' => $article_id,]);
	}

	private function article_list() {
		$page = isset($_GET['page']) ? (int)trim($_GET['page']) : 1;
		$count = isset($_GET['count']) ? (int)trim($_GET['count']) : Option::get('index_lognum');
		$sort_id = isset($_GET['sort_id']) ? (int)trim($_GET['sort_id']) : 0;
		$keyword = isset($_GET['keyword']) ? addslashes(htmlspecialchars(urldecode(trim($_GET['keyword'])))) : '';
		$keyword = str_replace(['%', '_'], ['\%', '\_'], $keyword);

		$sub = '';
		if ($sort_id) {
			$sub .= ' and sortid = ' . $sort_id;
		}
		if ($keyword) {
			$sub .= " and title like '%{$keyword}%'";
		}

		$r = $this->Log_Model->getLogsForHome($sub . " ORDER BY top DESC ,date DESC", $page, $count);
		$sort_cache = $this->Cache->readCache('sort');
		$author_cache = $this->Cache->readCache('user');
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
				'author_name' => isset($author_cache[$value['author']]['name']) ? $author_cache[$value['author']]['name'] : '',
				'sort_id'     => (int)$value['sortid'],
				'sort_name'   => isset($sort_cache[$value['sortid']]['sortname']) ? $sort_cache[$value['sortid']]['sortname'] : '',
				'views'       => (int)$value['views'],
				'comnum'      => (int)$value['comnum'],
				'top'         => $value['top'],
				'sortop'      => $value['sortop'],
			];
		}

		output::ok(['articles' => $articles,]);
	}

	private function article_detail() {
		$id = isset($_GET['id']) ? (int)trim($_GET['id']) : 0;

		$r = $this->Log_Model->getOneLogForHome($id);
		$sort_cache = $this->Cache->readCache('sort');
		$author_cache = $this->Cache->readCache('user');
		$article = '';
		if (empty($r)) {
			output::ok(['article' => $article,]);
		}

		$article = [
			'title'       => $r['log_title'],
			'date'        => date('Y-m-d H:i:s', $r['date']),
			'id'          => (int)$r['logid'],
			'sort_id'     => (int)$r['sortid'],
			'sort_name'   => isset($sort_cache[$r['sortid']]['sortname']) ? $sort_cache[$r['sortid']]['sortname'] : '',
			'type'        => $r['type'],
			'author_id'   => (int)$r['author'],
			'author_name' => isset($author_cache[$r['author']]['name']) ? $author_cache[$r['author']]['name'] : '',
			'content'     => $r['log_content'],
			'cover'       => $r['log_cover'],
			'views'       => (int)$r['views'],
			'comnum'      => (int)$r['comnum'],
			'top'         => $r['top'],
			'sortop'      => $r['sortop'],
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
		$req_sign = isset($_POST['req_sign']) ? addslashes(trim($_POST['req_sign'])) : '';
		$req_time = isset($_POST['req_time']) ? addslashes(trim($_POST['req_time'])) : '';
		$t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';
		$author_uid = isset($_POST['author_uid']) ? (int)trim($_POST['author_uid']) : 1;

		if (empty($req_sign) || empty($req_time) || empty($t)) {
			Output::error('parameter error');
		}

		$this->checkApiKey($req_sign, $req_time);

		$data = [
			'content' => $t,
			'author'  => $author_uid,
			'date'    => time(),
		];

		$id = $this->Twitter_Model->addTwitter($data);
		$this->Cache->updateCache(array('sta', 'newtw'));
		output::ok(['note_id' => $id,]);
	}

	private function checkApiKey($req_sign, $req_time) {
		$apikey = Option::get('apikey');
		$sign = md5($req_time . $apikey);

		if ($sign !== $req_sign) {
			Output::error('sign error');
		}
	}
}
