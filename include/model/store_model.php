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

	public function getMyAddon() {
		return $this->reqEmStore('mine');
	}

	public function reqEmStore($type, $tag = '', $keyword = '') {
		$emcurl = new EmCurl();
		$emcurl->setPost(['emkey' => Option::get('emkey'), 'ver' => Option::EMLOG_VERSION, 'type' => $type, 'tag' => $tag, 'keyword' => $keyword]);
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
				$data = isset($ret['data']['templates']) ? $ret['data']['templates'] : [];
				break;
			case 'plu':
				$data = isset($ret['data']['plugins']) ? $ret['data']['plugins'] : [];
				break;
		}
		return $data;
	}

}
