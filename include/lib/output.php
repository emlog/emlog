<?php
/**
 * Output class
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Output {


	public static function ok($data) {

		header('Content-Type: application/json; charset=UTF-8');

		$result = [
			'code' => 0,
			'msg'  => 'ok',
			'data' => $data
		];

		die(json_encode($result, JSON_UNESCAPED_UNICODE));
	}

	public static function error($msg) {

		header('Content-Type: application/json; charset=UTF-8');

		$result = [
			'code' => 1,
			'msg'  => $msg,
			'data' => ''
		];

		die(json_encode($result, JSON_UNESCAPED_UNICODE));
	}

}
