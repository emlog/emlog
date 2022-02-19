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
//管理后台安全入口：/admin/account.php?action=signin&s=xxx （xxx只能是字母数字，不要包含特殊字符）
//const ADMIN_PATH_CODE = 'xxx';