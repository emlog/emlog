<?php
/**
 * Global setting options
 * @copyright (c) Emlog All Rights Reserved
 */

//Blog root directory
define('EMLOG_ROOT', dirname(__FILE__));
//Version number
define('EMLOG_VERSION', '3.5.2');
//Maximum width of image thumbnail
define('IMG_ATT_MAX_W',	420);
//Maximum height of image thumbnail
define('IMG_ATT_MAX_H',	460);
//Maximum width of avatar thumbnail
define('ICON_MAX_W', 	140);
//Maximum height of avatar thumbnail
define('ICON_MAX_H',	220);
//Maximum attachment size (unit: byte, default 20M)
define('UPLOADFILE_MAXSIZE', 20971520);
//File upload directory, relative path and must start with '../'
define('UPLOADFILE_PATH',  '../content/uploadfile/');
//Allowed attachment types
$att_type = array('rar','zip','gif', 'jpg', 'jpeg', 'png', 'bmp');
//Whether the generate thumbnails for uploaded images, 1: Yes, 0: No
define('IS_THUMBNAIL', 1);
//Display number of items per page at background
define('ADMIN_PERPAGE_NUM', 15);
//RSS output entries
define('RSS_OUTPUT_NUM', 10);
//Whether RSS is output in full text, 1: Yes, 0: No
define('RSS_FULL_FEED', 0);
//Admin panel template name
define('ADMIN_TPL', 'default');
//The current page names
define('CURPAGE_HOME',  'home');
define('CURPAGE_TW',    'twitter');
define('CURPAGE_LOG',   'echo_log');
