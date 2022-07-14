<?php
header("location: ./install.php");exit;
//mysql database address
const DB_HOST = '127.0.0.1';// or 'localhost'
//mysql database user
const DB_USER = 'root';
//database password
const DB_PASSWD = '';
//database name
const DB_NAME = 'emlog';
//database prefix
const DB_PREFIX = 'emlog_';
//auth key
const AUTH_KEY = 'emlog-key';
//cookie name
const AUTH_COOKIE_NAME = 'emlog-cookie';
//Management background security entry: /admin/account.php?action=signin&s=xxx (xxx can only be alphanumeric, do not contain special characters)
//const ADMIN_PATH_CODE = 'xxx';

//vot: Default blog language
define('DEFAULT_LANG', 'en'); //'en', 'ru', 'zh-CN', 'zh-TW', 'pt-BR', etc.

//vot: Enabled language list
define('LANG_LIST', [
	'en' => [
		'name'=>'English',
		'title'=>'English',
		'dir'=>'ltr',
	],
	'ru' => [
		'name'=>'Русский',
		'title'=>'Russian',
		'dir'=>'ltr',
	],
	'zh-CN' => [
		'name'=>'简体中文',
		'title'=>'Simplified Chinese',
		'dir'=>'ltr',
	],
/*
	'ar' => [
		'name'=>'العربية',
		'title'=>'Arabic',
		'dir'=>'rtl',
	],
*/
]);
