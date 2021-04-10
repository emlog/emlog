<?php
/**
 * register check
 * @package EMLOG (www.emlog.net)
 */

class Register {

	/**
	 * check user is registered
	 */
	public static function isReg() {
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');

		$emkey = $options_cache['emkey'] ?? '';

		if (self::checkEmKey($emkey)) {
			return true;
		} else {
			Option::updateOption("emkey", '');
			$CACHE->updateCache('options');
			return false;
		}
	}

	/**
	 * check emkey
	 */
	public static function checkEmKey($emkey) {
		if (empty($emkey)) {
			return false;
		}

		$emcurl = new EmCurl();
		$emcurl->setPost(['emkey' => $emkey]);
		$emcurl->request(OFFICIAL_SERVICE_HOST . 'register/auth');
		if ($emcurl->getHttpStatus() !== 200) {
			return false;
		}
		$respone = $emcurl->getRespone();
		$respone = json_decode($respone, 1);
		if (!$respone || $respone['msg'] != 'ok') {
			return false;
		}

		return true;
	}

}
