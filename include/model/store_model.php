<?php
/**
 * store model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Store_Model {

	public function getTemplates() {
		return $this->reqEmStore('tpl');
	}

	public function getPlugins() {
		return $this->reqEmStore('plu');
	}

	// Get application store data
	public function reqEmStore($type) {
		$url = OFFICIAL_SERVICE_HOST . 'store/pro';
		$emcurl = new EmCurl();
		$emcurl->setPost(['emkey' => Option::get('emkey'), 'ver' => Option::EMLOG_VERSION, 'type' => $type]);
		$emcurl->request($url);

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
				$data = $ret['data']['templates'] ?? [];
				break;
			case 'plu':
				$data = $ret['data']['plugins'] ?? [];
				break;
		}
		return $data;
	}

}
