<?php
//mysql database address
const DB_HOST = '127.0.0.1';
//mysql database user
const DB_USER = 'BT_DB_USERNAME';
//database password
const DB_PASSWD = 'BT_DB_PASSWORD';
//database name
const DB_NAME = 'BT_DB_NAME';
//database prefix
const DB_PREFIX = 'emlog_';
//auth key
define("AUTH_KEY", sha1('BT_DB_PASSWORD'));
//cookie name
define("AUTH_COOKIE_NAME", 'emlog-cookie' . md5('BT_DB_PASSWORD'));