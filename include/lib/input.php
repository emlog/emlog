<?php
/**
 * Input class
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Input {
	public static function postIntVar($var_name, $var_default = 0, $var_min = 0, $var_max = 0) {
		$options = self::setIntOption($var_default, $var_min, $var_max);
		return filter_input(INPUT_POST, $var_name, FILTER_VALIDATE_INT, $options);
	}

	public static function getIntVar($var_name, $var_default = 0, $var_min = 0, $var_max = 0) {
		$options = self::setIntOption($var_default, $var_min, $var_max);
		return filter_input(INPUT_GET, $var_name, FILTER_VALIDATE_INT, $options);
	}

	public static function postStrVar($var_name, $var_default = '') {
		$str = filter_input(INPUT_POST, $var_name);
		return $str ? addslashes(trim($str)) : $var_default;
	}

	public static function getStrVar($var_name, $var_default = '') {
		$str = filter_input(INPUT_GET, $var_name);
		return $str ? addslashes(trim($str)) : $var_default;
	}

	private static function setIntOption($var_default = 0, $var_min = 0, $var_max = 0) {
		$options['options']['default'] = $var_default;
		if ($var_max) {
			$options['options']['max_range'] = $var_max;
		}
		if ($var_min) {
			$options['options']['min_range'] = $var_min;
		}
		return $options;
	}
}
