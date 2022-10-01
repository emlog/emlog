<?php
/**
 * register check
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Register {

	public static function isRegLocal() {
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		$emkey = isset($options_cache['emkey']) ? $options_cache['emkey'] : '';

		if (empty($emkey)) {
			return false;
		}
		return true;
	}

	public static function getRegType() {
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		return isset($options_cache['emkey_type']) ? (int)$options_cache['emkey_type'] : '';
	}

	public static function isRegServer() {
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		$emkey = isset($options_cache['emkey']) ? $options_cache['emkey'] : '';
		return self::checkEmKey($emkey);
	}

	public static function checkEmKey($emkey) {
		if (empty($emkey)) {
			return false;
		}

		$emcurl = new EmCurl();
		$emcurl->setPost(['emkey' => $emkey]);
		$emcurl->request('https://www.emlog.net/proauth/register');
		if ($emcurl->getHttpStatus() !== 200) {
			return false;
		}
		$response = $emcurl->getRespone();
		$response = json_decode($response, 1);
		if ($response['code'] !== 200) {
			$CACHE = Cache::getInstance();
			Option::updateOption('emkey', '');
			$CACHE->updateCache('options');
			return false;
		}

		return $response;
	}

}
