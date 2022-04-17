<?php
/**
 * Output class
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Output {


	public static function ok($data) {

		$result = [
			'code' => 0,
			'msg'  => 'ok',
			'data' => $data
		];

		echo json_encode($result);

		exit;
	}

	public static function error($data, $code = 1) {

		$result = [
			'code' => $code,
			'msg'  => 'error',
			'data' => $data
		];

		echo json_encode($result);

		exit;
	}

}
