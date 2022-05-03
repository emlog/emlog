<?php
/**
 * Rest API controller
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Api_Controller {

	public $Log_Model;

	public $Cache;

	/**
	 * starter
	 */
	function starter($params) {

		$_func = isset($_GET['rest-api']) ? addslashes($_GET['rest-api']) : '';

		if (empty($_func)) {
			Output::error('error router');
		}

		if (method_exists($this, $_func)) {
			$this->Log_Model = new Log_Model();
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
		$sort = isset($_POST['sort']) ? (int)$_POST['sort'] : -1;
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
			'sort'    => $sort,
			'cover'   => $cover,
			'date'    => strtotime($post_date ?: date('Y-m-d H:i:s')),
		];

		$article_id = $this->Log_Model->addlog($logData);
		$this->Cache->updateCache();

		output::ok([
			'article_id' => $article_id,
		]);

	}

	private function checkApiKey($req_sign, $req_time) {
		$apikey = Option::get('apikey');
		$sign = md5($req_time . $apikey);

		if ($sign !== $req_sign) {
			Output::error('sign error');
		}
	}


}
