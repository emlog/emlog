<?php
header("location: ./install.php");exit;
//mysql database address
const DB_HOST = '127.0.0.1';
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
//Management back-end security entrance: /admin/?s=xxx
//const ADMIN_PATH_CODE = 'F6MRkx9a';

//vot: blog language
define('EMLOG_LANGUAGE','en'); //'en', 'ru', 'sc', 'tc', etc.

//vot: blog language direction
define('EMLOG_LANGUAGE_DIR','ltr'); //'ltr', 'rtl'
