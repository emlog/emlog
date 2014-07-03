<?php
header("location: ./install.php");exit;

//mysql database address
define('DB_HOST','127.0.0.1');// or 'localhost'

//mysql database user
define('DB_USER','root');

//database password
define('DB_PASSWD','');

//database name
define('DB_NAME','emlog');

//database prefix
define('DB_PREFIX','emlog_');

//auth key
define('AUTH_KEY','emlog-key');

//cookie name
define('AUTH_COOKIE_NAME','emlog-cookie');

//blog language //vot
define('EMLOG_LANGUAGE','en'); //'en', 'ru', 'sc', 'tc', etc.

//Version number //vot
define('EMLOG_VERSION','5.3.0');

