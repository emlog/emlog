<?php
/**
 * 全局设置选项
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.1
 * $Id$
 */

//博客根目录
define('EMLOG_ROOT', dirname(__FILE__));
//版本编号
define('EMLOG_VERSION', '3.5.1');
//图片附件缩略图最大宽
define('IMG_ATT_MAX_W',	420);
//图片附件缩略图最大高
define('IMG_ATT_MAX_H',	460);
//头像缩略图最大宽
define('ICON_MAX_W', 	140);
//头像缩略图最大高
define('ICON_MAX_H',	220);
//附件大小上限 （单位：字节，默认20M）
define('UPLOADFILE_MAXSIZE', 20971520);
//文件上传目录, 相对路径且必须以'../'开头
define('UPLOADFILE_PATH',  '../content/uploadfile/');
//允许上传的附件类型
$att_type = array('rar','zip','gif', 'jpg', 'jpeg', 'png', 'bmp');
//上传图片是否生成缩略图 1:是 0:否
define('IS_THUMBNAIL', 1);
//后台管理每页显示条目
define('ADMIN_PERPAGE_NUM', 15);
//RSS输出条目
define('RSS_OUTPUT_NUM', 10);
//后台模板名
define('ADMIN_TPL', 'default');
//当前页面
define('CURPAGE_HOME',  'home');
define('CURPAGE_TW',    'twitter');
define('CURPAGE_LOG',   'echo_log');
