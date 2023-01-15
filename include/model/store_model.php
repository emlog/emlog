<?php
/**
 * store model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Store_Model {

	public function getTemplates($tag, $keyword) {
		return $this->reqEmStore('tpl', $tag, $keyword);
	}

	public function getPlugins($tag, $keyword) {
		return $this->reqEmStore('plu', $tag, $keyword);
	}

	public function reqEmStore($type, $tag = '', $keyword = '', $page = 1) {
		$emcurl = new EmCurl();

		$post_data = [
			'emkey'   => Option::get('emkey'),
			'ver'     => Option::EMLOG_VERSION,
			'type'    => $type,
			'tag'     => $tag,
			'keyword' => $keyword,
			'page'    => $page
		];
		$emcurl->setPost($post_data);
		$emcurl->request('https://www.emlog.net/store/pro');

		$retStatus = $emcurl->getHttpStatus();
		if ($retStatus !== MSGCODE_SUCCESS) {
			emDirect("./store.php?action=error&error=1");
		}
		$response = $emcurl->getRespone();
		$ret = json_decode($response, 1);
		if (empty($ret)) {
			emDirect("./store.php?action=error&error=1");
		}
		if ($ret['code'] === MSGCODE_EMKEY_INVALID) {
			Option::updateOption('emkey', '');
			$CACHE = Cache::getInstance();
			$CACHE->updateCache('options');
			emDirect("./auth.php?error_store=1");
		}

		$data = [];
		switch ($type) {
			case 'tpl':
				$data['templates'] = isset($ret['data']['templates']) ? $ret['data']['templates'] : [];
				$data['count'] = isset($ret['data']['count']) ? $ret['data']['count'] : 0;
				break;
			case 'plu':
				$data['plugins'] = isset($ret['data']['plugins']) ? $ret['data']['plugins'] : [];
				$data['count'] = isset($ret['data']['count']) ? $ret['data']['count'] : 0;
				break;
		}
		return $data;
	}

}
