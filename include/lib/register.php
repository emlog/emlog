<?php
/**
 * register check
 * @package EMLOG (www.emlog.net)
 */

class Register {

	/**
	 * check user is register
	 */
	public static function isReg() {
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');

		$emkey = $options_cache['emkey'] ?? '';

		if ($emkey) {
			return true;
		} else {
			return false;
		}
	}

}
