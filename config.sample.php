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

//vot: blog language
define('EMLOG_LANGUAGE','en'); //'en', 'ru', 'zh-CN', 'zh-TW', etc.

//vot: blog language direction
define('EMLOG_LANGUAGE_DIR','ltr'); //'ltr', 'rtl'
